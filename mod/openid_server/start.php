<?php

/**
 * Elgg openid server plugin
 * 
 * @package ElggOpenID
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */
 
 /*
 
 To do here:
 
 - put server link in profile page
 
*/
/*FIXME check if this extend is working or delete it*/
//extend_view('page_elements/header_contents', 'page_elements/openid_linkrel');

set_include_path(get_include_path() . PATH_SEPARATOR . $CONFIG->path . 'mod/openid_server/');

register_elgg_event_handler('init','system','openid_server_init',1);

function openid_server_init() {

	 global $CONFIG;
	register_elgg_event_handler('login','user','openid_server_handle_login');
	register_elgg_event_handler('logout','user','openid_server_handle_logout');
 
	 // Load the language file
	 register_translations($CONFIG->path . "mod/openid_server/languages/");
	 
	 set_view_location("openid_server/forms/trust", $CONFIG->path.'mod/openid_server/views/');
    
     //elgg_extend_view("metatags", "openid_server/metatags");
     extend_view("metatags", "openid_server/metatags");
     extend_view("xrds/services", "openid_server/service");
}


function openid_server_handle_login($event, $object_type, $object) {
    global $CONFIG;
    
    require_once('openid_server_include.php');
    
    $store = getOpenIDServerStore();
    
    if ($store->getAutoLoginSites()) {    
        forward($CONFIG->wwwroot.'mod/openid_server/actions/autologin.php');
    }
    
    return true;
}

function openid_server_handle_logout($event, $object_type, $object) {
    global $CONFIG;
    
    /*$store = getOpenIDServerStore();
    
    if ($store->getAutoLogoutSites()) {    
        forward($CONFIG->wwwroot.'mod/openid_server/actions/autologout.php');
    }*/
    
    return true;
}

 
?>
