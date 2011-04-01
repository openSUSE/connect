<?php

/**
 * Elgg openid_server admin action page
 * 
 * @package openid_server
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardiner <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 * 
 * @uses the following values in $vars:
 *
 * 'trust'               the trust object with the database information and action type
 */

require_once('../openid_server_include.php');

if (isadminloggedin()) {
	$action = trim(get_input('action'));
	$trust_id = get_input('trust_id');
	$show_full_form = true;
	$body = '';
	if ($action) {
		$trust = new StdClass;
		$trust->trust_root = get_input('trust_root');
		$trust->site_name = get_input('site_name');
		$trust->auto_login = get_input('auto_login');
		$trust->auto_logout = get_input('auto_logout');
		$trust->width = get_input('width');
		$trust->height = get_input('height');
		
		switch($action) {
			case 'change':
				$trust->ident = $trust_id;
				$store->update_default_trust_root($trust_id,$trust);
				system_message(elgg_echo('openid_server:trust_root_updated'));
				break;
			case 'add':
				$store->insert_default_trust_root($trust);
				system_message(elgg_echo('openid_server:trust_root_added'));
				break;
			case 'delete':
				$store->delete_default_trust_root($trust_id);
				system_message(elgg_echo('openid_server:trust_root_deleted'));
				break;
		}
	} else {
		if ($trust_id) {
			$trust = $store->get_trust_root($trust_id);
			$trust->action = 'change';
			$body = generate_trust_form($trust);
			$title = elgg_echo('openid_server:edit_trust_root_title');
			$show_full_form = false;
		}
	}
	
	if ($show_full_form) {
    	
    	// KJ - TODO: Move this into a separate form view		
		$edit_url = $CFG->wwwroot.'mod/openid_server/admin.php?trust_id=';
		$delete_url = $CFG->wwwroot.'mod/openid_server/admin.php?action=delete&trust_id=';
		$title = elgg_echo('openid_server:manage_trust_root_title');
		$results = $store->get_all_default_trust_roots();
		if ($results) {
			$body .= '<h2>'.elgg_echo('openid_server:trust_root_title').'</h2>'."\n";
			$body.= '<table border="0">'."\n";
			foreach($results as $item) {
				$body .= '<tr><td width="150">'.$item->site_name.'</td><td width="250">'.$item->trust_root.'</td><td><a href="'
					.$edit_url.$item->ident.'">'.elgg_echo('openid_server:edit_option').'</a></td><td><a href="'
					.$delete_url.$item->ident.'">'.elgg_echo('openid_server:delete_option').'</a></td></tr>'."\n";
			}
		}
		$body .= "</table>\n";
		$body .= '<h2>'.elgg_echo('openid_server:add_trust_root_title').'</h2>';
		$trust = new StdClass;
		$trust->trust_root = '';
		$trust->site_name = '';
		$trust->auto_login = '';
		$trust->auto_logout = '';
		$trust->width = 0;
		$trust->height = 0;
		$trust->action = 'add';
		$body .= generate_trust_form($trust);
	}
}		

page_draw($title,$body);

?>
