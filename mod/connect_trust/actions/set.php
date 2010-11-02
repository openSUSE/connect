<?php

	action_gatekeeper();

	$guid = (int) get_input('guid');
	$trust = (int) get_input('trust');

	if(!($entity = get_entity($guid)))
	{
		register_error(sprintf(elgg_echo('connect_trust:bad_guid'),$guid));
		forward($_SERVER['HTTP_REFERER']);
	}

	$user = get_loggedin_user();

	$olds = get_annotations($guid,$entity->type,$entity->getSubtype(),'connect_trust','',$user->getGuid());
	foreach ($olds as $old) {
		delete_annotation($old->id);
	}
	
	if ($trust != 'na') {
		if($entity->annotate('connect_trust', $trust, 2, $user->getGUID()))
		{
			system_message(elgg_echo('connect_trust:saved'));
		}
		else
		{
			register_error(elgg_echo('connect_trust:cant_annotate'));
		}
	} else {
		system_message(elgg_echo('connect_trust:reset'));
	}

	forward($_SERVER['HTTP_REFERER']);

?>
