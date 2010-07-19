<?php
$yn_options = array(elgg_echo('event_calendar:settings:yes')=>'yes',
	elgg_echo('event_calendar:settings:no')=>'no',
);

$listing_options = array(elgg_echo('event_calendar:settings:paged')=>'paged',
	elgg_echo('event_calendar:settings:month')=>'month',
);

$body = '';

$event_calendar_listing_format = get_plugin_setting('listing_format', 'event_calendar');
if (!$event_calendar_listing_format) {
	$event_calendar_listing_format = 'month';
}

$body .= elgg_echo('event_calendar:settings:listing_format:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[listing_format]','value'=>$event_calendar_listing_format,'options'=>$listing_options));

$body .= '<br />';

$event_calendar_times = get_plugin_setting('times', 'event_calendar');
if (!$event_calendar_times) {
	$event_calendar_times = 'no';
}

$body .= elgg_echo('event_calendar:settings:times:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[times]','value'=>$event_calendar_times,'options'=>$yn_options));

$body .= '<br />';

$event_calendar_autopersonal = get_plugin_setting('autopersonal', 'event_calendar');
if (!$event_calendar_autopersonal) {
	$event_calendar_autopersonal = 'yes';
}

$body .= elgg_echo('event_calendar:settings:autopersonal:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[autopersonal]','value'=>$event_calendar_autopersonal,'options'=>$yn_options));

$body .= '<br />';

$event_calendar_autogroup = get_plugin_setting('autogroup', 'event_calendar');
if (!$event_calendar_autogroup) {
	$event_calendar_autogroup = 'no';
}

$body .= elgg_echo('event_calendar:settings:autogroup:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[autogroup]','value'=>$event_calendar_autogroup,'options'=>$yn_options));

$body .= '<br />';

$event_calendar_agenda_view = get_plugin_setting('agenda_view', 'event_calendar');
if (!$event_calendar_agenda_view) {
	$event_calendar_agenda_view = 'no';
}

$body .= elgg_echo('event_calendar:settings:agenda_view:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[agenda_view]','value'=>$event_calendar_agenda_view,'options'=>$yn_options));

$body .= '<br />';

$event_calendar_venue_view = get_plugin_setting('venue_view', 'event_calendar');
if (!$event_calendar_venue_view) {
	$event_calendar_venue_view = 'no';
}

$body .= elgg_echo('event_calendar:settings:venue_view:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[venue_view]','value'=>$event_calendar_venue_view,'options'=>$yn_options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:no')=>'no',
	elgg_echo('event_calendar:settings:site_calendar:admin')=>'admin',
	elgg_echo('event_calendar:settings:site_calendar:loggedin')=>'loggedin',
);

$event_calendar_site_calendar = get_plugin_setting('site_calendar', 'event_calendar');
if (!$event_calendar_site_calendar) {
	$event_calendar_site_calendar = 'admin';
}

$body .= elgg_echo('event_calendar:settings:site_calendar:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[site_calendar]','value'=>$event_calendar_site_calendar,'options'=>$options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:no')=>'no',
	elgg_echo('event_calendar:settings:group_calendar:admin')=>'admin',
	elgg_echo('event_calendar:settings:group_calendar:members')=>'members',
);

$event_calendar_group_calendar = get_plugin_setting('group_calendar', 'event_calendar');
if (!$event_calendar_group_calendar) {
	$event_calendar_group_calendar = 'members';
}

$body .= elgg_echo('event_calendar:settings:group_calendar:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_calendar]','value'=>$event_calendar_group_calendar,'options'=>$options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:group_default:yes')=>'yes',
	elgg_echo('event_calendar:settings:group_default:no')=>'no',
);

$event_calendar_group_default = get_plugin_setting('group_default', 'event_calendar');
if (!$event_calendar_group_default) {
	$event_calendar_group_default = 'yes';
}

$body .= elgg_echo('event_calendar:settings:group_default:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_default]','value'=>$event_calendar_group_default,'options'=>$options));

$body .= '<br />';

$event_calendar_group_always_display = get_plugin_setting('group_always_display', 'event_calendar');
if (!$event_calendar_group_always_display) {
	$event_calendar_group_always_display = 'no';
}

$body .= elgg_echo('event_calendar:settings:group_always_display:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_always_display]','value'=>$event_calendar_group_always_display,'options'=>$yn_options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:group_profile_display_option:left')=>'left',
	elgg_echo('event_calendar:settings:group_profile_display_option:right')=>'right',
	elgg_echo('event_calendar:settings:group_profile_display_option:none')=>'none',
);

$event_calendar_group_profile_display = get_plugin_setting('group_profile_display', 'event_calendar');
if (!$event_calendar_group_profile_display) {
	$event_calendar_group_profile_display = 'right';
}

$body .= elgg_echo('event_calendar:settings:group_profile_display:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_profile_display]','value'=>$event_calendar_group_profile_display,'options'=>$options));

$body .= '<br />';

$event_calendar_region_display = get_plugin_setting('region_display', 'event_calendar');
if (!$event_calendar_region_display) {
	$event_calendar_region_display = 'no';
}

$body .= elgg_echo('event_calendar:settings:region_display:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[region_display]','value'=>$event_calendar_region_display,'options'=>$yn_options));

$body .= '<br />';

$event_calendar_region_list = get_plugin_setting('region_list', 'event_calendar');
if (!$event_calendar_region_list) {
	$event_calendar_region_list = '';
}

$body .= elgg_echo('event_calendar:settings:region_list:title');
$body .= '<br />';
$body .= elgg_view('event_calendar/input/longtext',array('internalname'=>'params[region_list]','value'=>$event_calendar_region_list));

$body .= '<br /><br />';

$event_calendar_type_display = get_plugin_setting('type_display', 'event_calendar');
if (!$event_calendar_type_display) {
	$event_calendar_type_display = 'no';
}

$body .= elgg_echo('event_calendar:settings:type_display:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[type_display]','value'=>$event_calendar_type_display,'options'=>$yn_options));

$body .= '<br />';

$event_calendar_type_list = get_plugin_setting('type_list', 'event_calendar');
if (!$event_calendar_type_list) {
	$event_calendar_type_list = '';
}

$body .= elgg_echo('event_calendar:settings:type_list:title');
$body .= '<br />';
$body .= elgg_view('event_calendar/input/longtext',array('internalname'=>'params[type_list]','value'=>$event_calendar_type_list));

$body .= '<br /><br />';

$event_calendar_first_date = get_plugin_setting('first_date', 'event_calendar');
if (!$event_calendar_first_date) {
	$event_calendar_first_date = '';
}

$body .= elgg_echo('event_calendar:settings:first_date:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[first_date]','value'=>$event_calendar_first_date));

$body .= '<br /><br />';

$event_calendar_last_date = get_plugin_setting('last_date', 'event_calendar');
if (!$event_calendar_last_date) {
	$event_calendar_last_date = '';
}

$body .= elgg_echo('event_calendar:settings:last_date:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[last_date]','value'=>$event_calendar_last_date));

echo $body;
?>