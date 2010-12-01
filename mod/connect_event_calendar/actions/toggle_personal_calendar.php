<?php
$event_id = get_input('event_id',0);
$user_id = get_loggedin_userid();
if (event_calendar_has_personal_event($event_id,$user_id)) {
	event_calendar_remove_personal_event($event_id,$user_id);
	echo elgg_echo('event_calendar:remove_from_my_calendar_response');
} else {
	event_calendar_add_personal_event($event_id,$user_id);
	echo elgg_echo('event_calendar:add_to_my_calendar_response');
}

exit;
?>