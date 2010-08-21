<?php
$group_options = array(elgg_echo('polls:settings:group_polls_default')=>'yes_default',
elgg_echo('polls:settings:group_polls_not_default')=>'yes_not_default',
elgg_echo('polls:settings:no')=>'no',
);

$polls_group_polls = get_plugin_setting('group_polls', 'polls');
if (!$polls_group_polls) {
	$polls_group_polls = 'yes_default';
}

$body .= elgg_echo('polls:settings:group:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_polls]','value'=>$polls_group_polls,'options'=>$group_options));

$body .= '<br />';

$options = array(elgg_echo('polls:settings:group_profile_display_option:left')=>'left',
	elgg_echo('polls:settings:group_profile_display_option:right')=>'right',
	elgg_echo('polls:settings:group_profile_display_option:none')=>'none',
);

$polls_group_profile_display = get_plugin_setting('group_profile_display', 'polls');
if (!$polls_group_profile_display) {
	$polls_group_profile_display = 'left';
}

$body .= elgg_echo('polls:settings:group_profile_display:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_profile_display]','value'=>$polls_group_profile_display,'options'=>$options));

$body .= '<br />';

$polls_group_access_options = array(elgg_echo('polls:settings:group_access:admins')=>'admins',
	elgg_echo('polls:settings:group_access:members')=>'members',
);

$polls_group_access = get_plugin_setting('group_access', 'polls');
if (!$polls_group_access) {
	$polls_group_access = 'admins';
}

$body .= elgg_echo('polls:settings:group_access:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_access]','value'=>$polls_group_access,'options'=>$polls_group_access_options));

$body .= '<br />';

echo $body;
?>