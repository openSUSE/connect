<?php

/**
 * Elgg openid_server trust page
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

global $CONFIG

$trust = $vars['trust'];

if (!$trust->ident) {
	$trust->ident = 0;
}

$trust_root_msg = elgg_echo('openid_server:trust_root');
$trust_site_msg = elgg_echo('openid_server:trust_site');
$auto_login_msg = elgg_echo('openid_server:autologin_url');
$auto_logout_msg = elgg_echo('openid_server:autologout_url');
$iframe_width_msg = elgg_echo('openid_server:iframe_width');
$iframe_height_msg = elgg_echo('openid_server:iframe_height');
$explanation = elgg_echo('openid_server:admin_explanation');
if ($trust->action == 'change') {
	$button_msg = elgg_echo('openid_server:change_button');
} else {
	$button_msg = elgg_echo('openid_server:add_button');
}


$form = <<< END
		<style type="text/css">
		label,input {
		   display: block;
		   float: left;
		   margin-bottom: 5px;
		}
		label {
		   text-align: left;
		   width: 125px;
		   padding-right: 20px;
		}			
		br {
		   clear: left;
		}
		</style> 
	$explanation
	<form action="{$CONFIG->wwwroot}mod/openid_server/actions/admin.php" method="post">
	<label for="trust_root">$trust_root_msg:</label> <input type="text" name="trust_root" size="80" value="{$trust->trust_root}"><br />
	<label for="site_name">$trust_site_msg:</label> <input type="text" name="site_name" value="{$trust->site_name}"><br />
	<label for="auto_login">$auto_login_msg:</label>  <input type="text" name="auto_login" size="80" value="{$trust->auto_login}"><br />
	<label for="auto_logout">$auto_logout_msg:</label>  <input type="text" name="auto_logout" size="80" value="{$trust->auto_logout}"><br />
	<label for="width">$iframe_width_msg:</label>  <input type="text" name="width" size="10" value="{$trust->width}"><br />
	<label for="height">$iframe_height_msg:</label> <input type="text" name="height" size="10" value="{$trust->height}"><br />
	<input type="hidden" name="action" value="{$trust->action}">
	<input type="hidden" name="trust_id" value="{$trust->ident}">
	<input type="submit" name="submit" value="$button_msg">
	</form>
END;
	return $form;
}
		

if (logged_on && run("users:flags:get", array("admin", $_SESSION['userid']))) {
	$action = trim(optional_param('action'));
	$trust_id = optional_param('trust_id',0,PARAM_INT);
	$show_full_form = true;
	$body = '';
	if ($action) {
		$trust = new StdClass;
		$trust->trust_root = optional_param('trust_root');
		$trust->site_name = optional_param('site_name');
		$trust->auto_login = optional_param('auto_login');
		$trust->auto_logout = optional_param('auto_logout');
		$trust->width = optional_param('width');
		$trust->height = optional_param('height');
		
		switch($action) {
			case 'change':
				$trust->ident = $trust_id;
				update_record('openid_server_trust',$trust);
				$messages[] = gettext("Trust root updated");
				break;
			case 'add':
				insert_record('openid_server_trust',$trust,false);
				$messages[] = gettext("Trust root added");
				break;
			case 'delete':
				delete_records('openid_server_trust','ident',$trust_id);
				$messages[] = gettext("Trust root deleted");
				break;
		}
	} else {
		if ($trust_id) {
			$trust = get_record('openid_server_trust','ident',$trust_id);
			$trust->action = 'change';
			$body = generate_trust_form($trust);
			$title = gettext("Edit trust record");
			$show_full_form = false;
		}
	}
	
	if ($show_full_form) {			
		$edit_url = $CFG->wwwroot.'mod/openid_server/admin.php?trust_id=';
		$delete_url = $CFG->wwwroot.'mod/openid_server/admin.php?action=delete&trust_id=';
		$title = gettext("Manage default trust roots");
		$results = get_records_sql("SELECT ident, site_name, trust_root FROM {$CFG->prefix}openid_server_trust WHERE openid_url IS NULL OR openid_url = ''");
		if ($results) {
			$body .= '<h2>'.gettext("Default trust roots").'</h2>'."\n";
			$body.= '<table border="0">'."\n";
			foreach($results as $item) {
				$body .= '<tr><td width="150">'.$item->site_name.'</td><td width="250">'.$item->trust_root.'</td><td><a href="'
					.$edit_url.$item->ident.'">'.gettext("Edit").'</a></td><td><a href="'
					.$delete_url.$item->ident.'">'.gettext("Delete").'</a></td></tr>'."\n";
			}
		}
		$body .= "</table>\n";
		$body .= '<h2>'.gettext("Add default trust root").'</h2>';
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

define("context", "admin");

templates_page_setup();    

echo templates_page_draw( array(
                sitename,
                templates_draw(array(
                                                'body' => $body,
                                                'title' => $title,
                                                'context' => 'contentholder'
                                            )
                                            )
        )
        );

?>
