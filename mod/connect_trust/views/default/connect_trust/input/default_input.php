<?php

	gatekeeper();

	$action = $vars['url'].'action/connect_trust/set';
	$opt_val = array(
		'-5' => elgg_echo("connect_trust:-5"),
		'-4' => elgg_echo("connect_trust:-4"),
		'-3' => elgg_echo("connect_trust:-3"),
		'-2' => elgg_echo("connect_trust:-2"),
		'-1' => elgg_echo("connect_trust:-1"),
		'na' => elgg_echo("connect_trust:na"),
		'+1' => elgg_echo("connect_trust:+1"),
		'+2' => elgg_echo("connect_trust:+2"),
		'+3' => elgg_echo("connect_trust:+3"),
		'+4' => elgg_echo("connect_trust:+4"),
		'+5' => elgg_echo("connect_trust:+5"),
	);

	$def = 'na';
	$ann = get_annotations($vars['entity']->getGuid(),$vars['entity']->type,$vars['$entity']->subtype,'connect_trust','',$vars['user']->getGuid());
	foreach ($ann as $a) {
		$def = $a->value;
	}
	$form_body = "<div><label>".elgg_echo("connect_trust:trust")."</label>";
	$form_body .= elgg_view('input/hidden',array('internalname'=>'guid','value'=>$vars['entity']->getGuid()));
	$form_body .= elgg_view('input/pulldown',array('internalname'=>'trust','options_values'=>$opt_val, 'value'=>$def));
	$form_body .= elgg_view('input/submit',array('value'=>elgg_echo("connect_trust:set")))."</div>";

	echo elgg_view('input/form', array('body'=>$form_body,'action'=>"{$action}"));

?>
