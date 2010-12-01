<?php

/*
checks for votes on the poll
@param ElggEntity $poll
@param guid
@return true/false
*/
function polls_check_for_previous_vote($poll, $user_guid)
{	
	$votes = get_annotations($poll->guid,"object","poll","vote","",$user_guid,1);
	if ($votes) {
		return true;
	} else {
		return false;
	}
}

function polls_get_choices($poll) {
	$options = array(
		'relationship' => 'poll_choice',
		'relationship_guid' => $poll->guid,
		'inverse_relationship' => TRUE,
		'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC')
	);
	return elgg_get_entities_from_relationship($options);
}

function polls_get_choice_array($poll) {
	$choices = polls_get_choices($poll);
	$responses = array();
	if ($choices) {
		foreach($choices as $choice) {
			$responses[] = $choice->text;
		}
	}	
	return $responses;
}

function polls_add_choices($poll,$choices) {
	$i = 0;
	if ($choices) {
		foreach($choices as $choice) {
			$poll_choice = new ElggObject();
			$poll_choice->subtype = "poll_choice";
			$poll_choice->text = $choice;
			$poll_choice->display_order = $i*10;
			$poll_choice->access_id = $poll->access_id;
			$poll_choice->save();
			add_entity_relationship($poll_choice->guid, 'poll_choice', $poll->guid);
			$i += 1;
		}
	}
}

function polls_delete_choices($poll) {
	$choices = polls_get_choices($poll);
	if ($choices) {
		foreach($choices as $choice) {
			$choice->delete();
		}
	}
}

function polls_replace_choices($poll,$new_choices) {
	polls_delete_choices($poll);
	polls_add_choices($poll, $new_choices);
}

function polls_activated_for_group($group) {
	$group_polls = get_plugin_setting('group_polls', 'polls');
	if ($group && ($group_polls != 'no')) {
		if ( ($group->polls_enable == 'yes') 
			|| ((!$group->polls_enable && ((!$group_polls) || ($group_polls == 'yes_default'))))) {
			return true;
		}
	}
	return false;		
}

function polls_can_add_to_group($group,$user=null) {
	$polls_group_access = get_plugin_setting('group_access', 'polls');
	if (!$polls_group_access || $polls_group_access == 'admins') {
		return $group->canEdit();
	} else {
		if (!$user) {
			$user = get_loggedin_user();
		}
		return $group->canEdit() || $group->isMember($user);
	}
}
?>