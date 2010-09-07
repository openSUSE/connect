<?php
	$mygroup_guid = get_input('mygroup');
	$who_guid = get_input('who');
	$mygroup = get_entity($mygroup_guid);
	$who = get_entity($who_guid);
	if ($mygroup instanceof ElggGroup && $mygroup->canEdit()) {
		if (!check_entity_relationship($who_guid, 'operator', $mygroup_guid)) {
			add_entity_relationship($who_guid, 'operator', $mygroup_guid);
		}
	}
	forward($CONFIG->wwwroot . 'pg/group_operators/add/' . $mygroup_guid);
?>
