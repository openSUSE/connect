<?php
/*
 * views/default/object/emPointGroup.php
 * Vista predeterminada para un listado de objetos pointGroup
 */

$insidePoints = elgg_get_entities(
	array(
		'type' => 'object',
		'subtype' => 'emPoint',
		'container_guid' => $vars['entity']->guid,
		'count' => true
	)
);
$insidePoints = empty($insidePoints) ? 0 : $insidePoints;
$icon = elgg_view(
	"graphics/icon", array(
		"entity" => $vars['entity'],
		'size' =>  'small'
	)
);
//$info = "<p><b>" . $vars['entity']->title . "</b></p>";
$info = "<p><b><a href='".$vars['entity']->getURL()."'>" . $vars['entity']->title . "</a></b></p>";
$info .= "<p>" . $vars['entity']->description . "</p>";
$info .= "<p>".$insidePoints." puntos en este grupo</p>";
//aca hay que agregar 2 cosas:
//1 el icono, y mostrarlo
//2 un boton/link para editar el pointGroup

//$info .= elgg_view_friendly_time($vars['entity']->time_created);
//$info .= "<p class='tags'>".elgg_view('output/tags', array('tags' => $vars['entity']->tags))."</p>";
//die(elgg_view_listing($icon, $info));
echo elgg_view_listing($icon, $info);
?>