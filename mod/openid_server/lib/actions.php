<?php

require_once "common.php";
require_once "session.php";

require_once "Auth/OpenID.php";

/**
 * Handle a standard OpenID server request
 */
function action_default()
{
	global $store;
	
    $server =& getServer();
    $method = $_SERVER['REQUEST_METHOD'];
    /*$request = null;
    if ($method == 'GET') {
        $request = $_GET;
    } else {
        $request = $_POST;
    } */

    $request = $server->decodeRequest();
    
    error_log("in action_default, request = ".print_r($request,true));

    if (!$request) {
        return ""; //about_render();
    }

    setRequestInfo($request);

    if (in_array($request->mode,
                 array('checkid_immediate', 'checkid_setup'))) {
                     
        error_log("in action_default, about to run isTrusted");

        if (isTrusted($request->identity, $request->trust_root, $request->return_to)) {
            error_log("in action_default, yes, is trusted");
            $response =& $request->answer(true);
        } else if ($request->immediate) {
             error_log("in action_default, yes, immediate");
            $response =& $request->answer(false, getServerURL());
        } else {
            if (!getLoggedInUser()) {
                 error_log("in action_default, calling login render");
                #return login_render();
                system_message(elgg_echo('openid_server:not_logged_in'));
                return gatekeeper();
                #return action_login();
            }
             error_log("in action_default, calling trust render");
            return trust_render($request);
        }
        error_log("in action_default, about to add sreg fields");
		addSregFields(&$response);

    } else {
        $response =& $server->handleRequest($request);
    }
	
    $webresponse =& $server->encodeResponse($response);

    foreach ($webresponse->headers as $k => $v) {
        header("$k: $v");
    }

    header(header_connection_close);
    print $webresponse->body;
    exit(0);
}

/**
 * Log out the currently logged in user
 */
function action_logout()
{
    setLoggedInUser(null);
    setRequestInfo(null);
    return authCancel(null);
}

/**
 * Check the input values for a login request
 */
function login_checkInput($input)
{
    $openid_url = false;
    $errors = array();

    if (!isset($input['openid_url'])) {
        $errors[] = gettext('Enter an OpenID URL to continue');
    }
    if (!isset($input['password'])) {
        $errors[] = gettext('Enter a password to continue');
    }
    if (count($errors) == 0) {
        $openid_url = $input['openid_url'];
        // don't normalise yet
        // $openid_url = Auth_OpenID::normalizeUrl($openid_url);
        $password = $input['password'];
        if (!checkLogin($openid_url, $password)) {
            $errors[] = 'The entered password does not match the ' .
                'entered identity URL.';
        }
    }
    return array($errors, $openid_url);
}

/**
 * Log in a user and potentially continue the requested identity approval
 */
function action_login()
{
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
    case 'GET':
        return login_render();
    case 'POST':
        $info = getRequestInfo();
        $fields = $_POST;
        if (isset($fields['cancel'])) {
            return authCancel($info);
        }

        list ($errors, $openid_url) = login_checkInput($fields);
        if (count($errors) || !$openid_url) {
            $needed = $info ? $info->identity : false;
            //KJ - use $openid_url instead
            // return login_render($errors, @$fields['openid_url'], $needed);
            return login_render($errors, $openid_url, $needed);
        } else {
            setLoggedInUser(normaliseUsername($openid_url));
            return doAuth($info);
        }
    default:
        return login_render(array('Unsupported HTTP method: $method'));
    }
}

/**
 * Ask the user whether he wants to trust this site
 */
function action_trust()
{
	global $store;
	
    $info = getRequestInfo();
    $trusted = isset($_POST['trust']);
    if ($info && isset($_POST['remember'])) {
        error_log("setTrustedSite0");
        $store->setTrustedSite($info->trust_root);
    }
    return doAuth($info, $trusted, true);
}

function action_sites()
{
	global $store;
	
	$sites = $store->getTrustedSites();
	
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['forget'])) {
            $store->removeAllTrustedSites();
        } elseif (isset($_POST['remove'])) {
            foreach ($_POST as $k => $v) {
                if (preg_match('/^site[0-9]+$/', $k)) {
                    $store->removeTrustedSite($v);
                }
            }
        }
    }
    return sites_render($store->getTrustedSites());
}

?>
