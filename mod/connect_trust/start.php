<?php

	function connect_trust_init()
	{
		global $CONFIG;
		register_translations($CONFIG->pluginspath.'connect_trust/languages/');
		elgg_extend_view('user/default','connect_trust/input/default_input',400);
	}

	global $CONFIG;

	register_elgg_event_handler('init','system','connect_trust_init');
	register_action('connect_trust/set',false,$CONFIG->pluginspath.'connect_trust/actions/set.php');
?>
