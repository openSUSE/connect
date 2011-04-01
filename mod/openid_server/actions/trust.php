<?php

/**
 * Elgg openid_server: handle trust form
 * 
 * @package ElggOpenID
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */
 
error_log("in trust.php");

require_once(dirname(dirname(__FILE__)).'/openid_server_include.php');

require_once ('lib/common.php');
require_once ('lib/session.php');

$info = getRequestInfo();
$trusted = get_input('trust');
$remember = get_input('remember');
$trust_root = get_input('trust_root');
error_log("in trust.php, getting store".$info->trust_root);
$store = getOpenIDServerStore();
if ($remember) {
      $store->setTrustedSite($info);
      //$store->setTrustedSite($info->trust_root);
}

if (!$info) {
        // There is no authentication information, so bail
        error_log("in trust.php, no info");
        system_message(elgg_echo("openid_server:cancelled"));
        forward();
} else {

    if ($idpSelect = $info->idSelect()) {
        if ($idpSelect) {
            $req_url = idURL($idpSelect);
	    //XXX fixing dirty https stuff
	    //$req_url = str_replace('http', 'https', $req_url);
        } else {
            $trusted = false;
        }
    } else {
        $req_url = normaliseUsername($info->identity);
	//XXX fixing dirty https stuff
	//$req_url = str_replace('http', 'https', $req_url);
    }
    
    error_log("in trust.php, getLoggedInUser");
    
    $user = getLoggedInUser();
    error_log("in trust.php, setRequestInfo");
    setRequestInfo($info);
    $user = str_replace('https', 'http', $user);
    $req_url_path = substr($req_url, strpos($req_url, ":"));
    $user_path = substr($user, strpos($user, ":"));
    if ($req_url_path != $user_path) {
        register_error(sprintf(elgg_echo("openid_server:loggedin_as_wrong_user"),$req_url, $user));
        forward();
    } else {
    
        $trust_root = $info->trust_root;
       //XXX fixing dirty https stuff
        error_log("in trust.php, trust_root = $trust_root");
        
        $trusted = isset($trusted) ? $trusted : isTrusted($req_url,$trust_root);
        if ($trusted) {
            setRequestInfo();
            $server =& getServer();
            $response =& $info->answer(true, null, $req_url);
            
            error_log("in trust.php, addSregFields");
       
	    //XXX this call gives fatal error: call to a member function isOpenID1()
	    //on a non-object (OpenID/Extension.php 
            addSregFields($response, $info, $req_url);
//            error_log("in trust.php, response = " . print_r($response));
            error_log("in trust.php, encodeResponse");
            //XXX falla encoding de esta respuesta 
            $webresponse =& $server->encodeResponse($response);
            
            error_log('in trust.php, webresponse ='.print_r($webresponse,true));
        
            $new_headers = array();
        
            foreach ($webresponse->headers as $k => $v) {
                $new_headers[] = $k.": ".$v;
            }
        
            writeResponse( array($new_headers, $webresponse->body));
        } elseif ($fail_cancels) {
            setRequestInfo();
            forward($info->getCancelURL());
        } else {
            writeResponse(trust_render($info));
        }
    }
}

?>
