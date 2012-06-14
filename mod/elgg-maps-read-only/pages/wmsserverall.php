<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

//gatekeeper();

$limit = get_input("limit", 5);
$offset = get_input("offset", 0);

$user_guid = get_loggedin_userid();

$body = elgg_view_title(elgg_echo('maps:wmsservers'));

$objects = elgg_list_entities(array('types'=>'object', 'subtypes'=>'wmsserver', 'limit'=>$limit, 'offset'=>$offset,'full_view'=>FALSE));
$body .=$objects;

//$body .= list_entities('object', 'wmsserver', 0, 10, true);

//$body .= list_user_objects($user_guid,'map',10,false,true);
$body = elgg_view_layout('two_column_left_sidebar', false, $body);

page_draw(elgg_echo("maps:plugin_name"), $body);

?>
