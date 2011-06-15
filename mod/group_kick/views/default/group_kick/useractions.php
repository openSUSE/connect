<?php 

	$group = page_owner_entity();
	$current_user = get_loggedin_user();
	
	$user = $vars["entity"];
	
	if(($group instanceof ElggGroup) 
		&& ($user instanceof ElggUser) 
		&& ($group->getOwner() != $user->getGUID()) 
		&& ($group->getOwner() == $current_user->getGUID() || isadminloggedin())
		&& ($user->getGUID() != $current_user->getGUID())){
		echo elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/group/kick?user_guid=" . $user->getGUID() . "&group_guid=" . $group->getGUID(), "text" => elgg_echo("group_kick:kick")));
	}

?>