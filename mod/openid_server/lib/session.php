<?php

//require_once(dirname(dirname(__FILE__)).'/config.php'); 
//require_once "render.php";

require_once "Auth/OpenID/Server.php";

// require_once('elgg/includes.php');

/**
 * Set up the session
 */
// get information from Elgg if logged in
// KJ - this should not be necessary as it can always be generated from the user name
function init()
{
	global $CFG;

	if (isloggedin()) {
		setLoggedInUser(normaliseUsername($_SESSION['user']->username));
	} else {
		setLoggedInUser(null);
	}
}


/**
 * Get the URL of the current script
 */
function getServerURL()
{
    global $CONFIG;
    
    return $CONFIG->wwwroot.'mod/openid_server/server.php';
}

/**
 * Build a URL to a server action
 */
function buildURL($action=null, $escaped=true)
{
    $url = getServerURL();
    if ($action) {
        $url .= '/' . $action;
    }
    return $escaped ? htmlspecialchars($url, ENT_QUOTES) : $url;
}

/**
 * Extract the current action from the request
 * KJ - this should be replaced by Elgg 1 action system
 */
function getAction()
{
    $path_info = @$_SERVER['PATH_INFO'];
    $action = ($path_info) ? substr($path_info, 1) : '';
    $function_name = 'action_' . $action;
    return $function_name;
}

/**
 * Write the response to the request
 */
function writeResponse($resp)
{
    list ($headers, $body) = $resp;
    array_walk($headers, 'header');
    header(header_connection_close);
    print $body;
}

/**
 * Instantiate a new OpenID server object
 */
function getServer()
{
    global $CONFIG;
    static $server;
    $op_endpoint = getServerURL();
    error_log("In getServer()");
    if (!isset($server)) {
        $server =& new Auth_OpenID_Server(getOpenIDServerStore(),$op_endpoint);
    }
    return $server;
}

/**
 * Return whether the trust root is currently trusted
 *
 */
function isTrusted($identity_url, $trust_root, $return_to)
{
	global $store;
	
    if ($identity_url != getLoggedInUser()) {
        return false;
    }
    
    $sites = $store->getTrustedSites($identity_url);
    
    if (empty($sites)) {
	    return false;
    } else {
		return in_array($trust_root, $sites) && fnmatch($trust_root.'*',$return_to);
	}
}


/**
 * Get the openid_url out of the cookie
 *
 * @return mixed $openid_url The URL that was stored in the cookie or
 * false if there is none present or if the cookie is bad.
 */
function getLoggedInUser()
{
    global $CONFIG;
    if (isloggedin()) {
        return $CONFIG->wwwroot.'pg/profile/'.$_SESSION['user']->username;
    } else {
        return '';
    }    
}

function getRequestInfo()
{
    return isset($_SESSION['openid_server_request'])
        ? unserialize($_SESSION['openid_server_request'])
        : false;
}

function setRequestInfo($info=null)
{
    error_log("in setRequestInfo");
    if (!isset($info)) {
        unset($_SESSION['openid_server_request']);
    } else {
        $_SESSION['openid_server_request'] = serialize($info);
    }
}

?>
