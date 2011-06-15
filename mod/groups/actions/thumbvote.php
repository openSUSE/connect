<?php

	global $CONFIG;

	gatekeeper();

	$logged_in_user = get_loggedin_user();

	$user_guid = get_input('user_guid');
	$group_guid = get_input('group_guid');
	$vote = get_input('vote');

	$user = get_entity($user_guid);
	$group = get_entity($group_guid);

	if ($user && $group && $group->canEdit())
	{
		$user->annotate('join_vote_' . $group_guid, $vote);
	}

	forward($_SERVER['HTTP_REFERER']);

?>
