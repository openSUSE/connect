<?php
	global $CONFIG;
	
	gatekeeper();
	
	$user_guid = get_input('user_guid');
	$group_guid = get_input('group_guid');
	
	$user = get_entity($user_guid);		
	$group = get_entity($group_guid);
	
	if (($user instanceof ElggUser) && ($group instanceof ElggGroup)){
		if ($group->getOwner() != $user->getGUID()) {
			// can't kick a group owner
			if ($group->leave($user)){
				system_message(elgg_echo("group_kick:actions:kick:succes"));
			} else {
				register_error(elgg_echo("group_kick:actions:kick:error"));
			}
		} else {
			register_error(elgg_echo("group_kick:actions:kick:error"));
		}
	} else {
		register_error(elgg_echo("group_kick:actions:kick:error"));
	}
		
	forward($_SERVER['HTTP_REFERER']);
?>