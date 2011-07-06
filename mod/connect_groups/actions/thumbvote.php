<?php

	global $CONFIG;

	gatekeeper();

	$logged_in_user = get_loggedin_user();

	$mode = get_input('mode');

	$group_guid = get_input('group_guid');
	$group = get_entity($group_guid);
	$user_guid = get_input('user_guid');
	$user = get_entity($user_guid);

	if ($mode == 'add' && $group->canEdit()) {
		$vote = get_input('vote');
		if ($user && $group) {
			$user->annotate('join_vote_' . $group_guid, $vote, ACCESS_PUBLIC);
		}
	}

	if ($mode == 'del' && $group->canEdit()) {
		$ann_id = get_input('ann_id');
		$annotation = get_annotation($ann_id);
		$annotation->delete();
	}

	forward($_SERVER['HTTP_REFERER'] . "#vote_{$user_guid}");

?>
