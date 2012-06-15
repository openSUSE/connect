<?php
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();

$title = elgg_echo('maps:new_wmsserver');

$area2 = elgg_view_title($title);

$area2 .= elgg_view("maps/wmsserverform");

$body = elgg_view_layout('two_column_left_sidebar', false, $area2);

page_draw($title, $body);

?>


