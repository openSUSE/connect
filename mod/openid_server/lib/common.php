<?php

require_once "session.php";

require_once "Auth/OpenID/Server.php";
require_once "Auth/OpenID/SReg.php";
try {
                include_once "Auth/OpenID/HMACSHA1.php";
} catch(Exception $e) {
                // new way :P
                require_once "Auth/OpenID/HMAC.php";
}

function getUsernameFromUrl($url)
{
	$un = trim($url);
    $lun = strlen($un);
    $last_stroke_pos = strrpos($un,"/");
    if ($last_stroke_pos === false) {
	    // no slash, so assume that this is already a username
	    $username = $url;
	} else {
	    if ($last_stroke_pos == ($lun - 1)) {
			// this url ends in a slash - ignore it	    
	    	$un = substr($un, 0,-1);
		}
	    $last_stroke_pos = strrpos($un,"/");
	    $username = substr($un,$last_stroke_pos+1);
	}
    
    return $username;
}

function normaliseUsername($username)
// check to see if the current username contains a slash
// if so, assume that this is an OpenID URL
// if not, munge it until it is
// normalise OpenID URLs to include a closing slash
{
	global $CONFIG;
	
	$stroke_pos = strpos($username,"/");
	if ($stroke_pos === false) {
		return $CONFIG->wwwroot."pg/profile/".$username;
	} else {
		if (substr($username,-1,1) == "/") {
			return substr($username, 0, strlen($username-1));
		} else {
			return $username;
		}
	}
}

function addSregFields(&$response,$info, $req_url)
{
	$username = getUsernameFromUrl($req_url);
	$user = get_user_by_username($username);
	if ($user) {
    	$email = $user->email;
    	$fullname = $user->name;
    	
    	$sreg_data = array(
                           'fullname'   => $fullname,
                           'email'      => $email
        );
    	
    	// Add the simple registration response values to the OpenID
        // response message.
        $sreg_request = Auth_OpenID_SRegRequest::fromOpenIDRequest($info);
    
        $sreg_response = Auth_OpenID_SRegResponse::extractResponse(
                                              $sreg_request, $sreg_data);
	error_log('DEBUG:' . (string)($response->fields));
        $sreg_response->toMessage($response->fields);
    }

}

// KJ - this code is now used in trust.php

/*function authCancel($info)
{
    if ($info) {
        setRequestInfo();
        $url = $info->getCancelURL();
    } else {
        $url = getServerURL();
    }
    return redirect_render($url);
}

function doAuth($info, $trusted=null, $fail_cancels=false,$idpSelect=null)
{
    if (!$info) {
        // There is no authentication information, so bail
        return authCancel(null);
    }

    if ($info->idSelect()) {
        if ($idpSelect) {
            $req_url = idURL($idpSelect);
        } else {
            $trusted = false;
        }
    } else {
        $req_url = normaliseUsername($info->identity);
    }

    $user = getLoggedInUser();
    setRequestInfo($info);

    if ($req_url != $user) {
        return login_render(array(), $req_url, $req_url);
    }

    $trust_root = $info->trust_root;
    // $fail_cancels = $fail_cancels || isset($sites[$trust_root]);
    $trusted = isset($trusted) ? $trusted : isTrusted($req_url,$trust_root);
    if ($trusted) {
        setRequestInfo();
        $server =& getServer();
        $response =& $info->answer(true, null, $req_url);

        addSregFields($response, $info, $req_url);

        $webresponse =& $server->encodeResponse($response);

        $new_headers = array();

        foreach ($webresponse->headers as $k => $v) {
            $new_headers[] = $k.": ".$v;
        }

        return array($new_headers, $webresponse->body);
    } elseif ($fail_cancels) {
        return authCancel($info);
    } else {
        return trust_render($info);
    }
}*/


function trust_render($info) {
    
    $vars = array('openid_url' =>getLoggedInUser(), 'openid_trust_root' =>htmlspecialchars($info->trust_root));
	
	return array(array(),page_draw(elgg_echo('openid_server:trust_title'), elgg_view("openid_server/forms/trust",$vars)));
}

function login_render($errors=null, $input=null, $needed=null) {
    system_message(elgg_echo('openid_server:not_logged_in'));
    forward(current_page_url());
}

?>
