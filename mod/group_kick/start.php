<?php
	
	global $CONFIG;

	function group_kick_pagesetup(){
		
		if($group = page_owner_entity()){
			if($group instanceof ElggGroup){
				if(isadminloggedin() || (get_loggedin_userid() == $group->getOwner())){
					extend_view("profile/menu/actions", "group_kick/useractions");
				}
			}
		}	
	}

	register_elgg_event_handler('pagesetup','system','group_kick_pagesetup');
	
	register_action('group/kick', false, $CONFIG->pluginspath . 'group_kick/actions/kick.php');
?>
