<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//gatekeeper();

set_page_owner(get_loggedin_userid());

$leftData = elgg_view_title($entity->title) . $entity->description;

$map = elgg_view('emLayer/view',array('layerObject'=>$entity));

//$layerList = elgg_view('emLayer/list',array('mapID'=>$entity->getGUID()));

$body = elgg_view_layout('two_column_left_sidebar', $leftData,  $map);

//page_draw(elgg_echo('maps:Map'). ": $entity->title", $body);
echo $map;
//page_draw(elgg_echo('maps:Map'). ": $entity->title", $map);
//echo printf("<pre>%s</pre>",print_r($features, true));
?>
