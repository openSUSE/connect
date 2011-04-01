<?php

require_once('openid_server_include.php');
require_once 'lib/session.php';
require_once 'lib/actions.php';

error_log('translations: '.print_r($CONFIG->translations,true));

error_log('in server.php - trying to get server $_SESSION = '.print_r($_SESSION,true));
$store = getOpenIDServerStore();

$server =& getServer();

error_log('in server.php - trying to decode request, action='.getAction());

$request = $server->decodeRequest();
//error_log('in server.php - request:'.print_r($request,true));
setRequestInfo($request);
error_log('in server.php - after setRequestInfo');
$action = getAction();
if (!function_exists($action)) {
    $action = 'action_default';
}

error_log('in server.php - dispatching action '.$action);

$resp = $action();

writeResponse($resp);
/*if (isloggedin()) {
    error_log('in server.php - about to forward');
    forward($CONFIG->wwwroot.'mod/openid_server/actions/trust.php');
} else {
    error_log('in server.php - not logged in');
    system_message(elgg_echo('openid_server:not_logged_in'));
    forward();
}*/

?>
