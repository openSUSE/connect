<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();

set_page_owner(get_loggedin_userid());


elgg_maps_load_scripts();

//$map = elgg_view('emMap/mapview',array('mapObject'=>$entity));
//$mapObject = $entity;

$sidebar = elgg_view_title($entity->title) . $entity->description;

//$sidebar .= elgg_view('emLayer/list',array('mapID'=>$entity->getGUID()));
//$sidebar .= "<pre>".print_r($mapObject,true)."</pre>";

//$body = elgg_view_layout('two_column_left_sidebar', $leftData,  $map . $layerList);

$body = "";

elggmaps_page_draw(elgg_echo('maps:Map'). ": $entity->title",$body,$sidebar,"",array('mapObject'=>$entity));

?>
