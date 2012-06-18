<?php

//include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

/*
gatekeeper();
$user_guid = get_loggedin_userid();
//register_entity_type('object','map');
$limit = get_input("limit", 5);
$offset = get_input("offset", 0);

$body = elgg_view_title(elgg_echo('maps:plugin_name'));

$objects = elgg_list_entities(array('types'=>'object', 'subtypes'=>'map', 'limit'=>$limit, 'offset'=>$offset,'full_view'=>FALSE));
$body .= $objects;

//$body .= list_entities('object', 'map', 0, 10, true);
//$body .= list_user_objects($user_guid,'map',10,false,true);
if(empty($objects)):
	$body .= elgg_echo('maps:empty');
endif;

//$body .= '<pre>'.print_r($objects,true).'</pre>';

$body = elgg_view_layout('two_column_left_sidebar', false, $body);

page_draw(elgg_echo("maps:plugin_name"), $body);
*/
//sacado del mod/blog

	//define('everyoneblog','true');
	require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

	set_page_owner(get_loggedin_userid());

	$offset = (int)get_input('offset', 0);
	
	$area2 = elgg_view_title(elgg_echo('maps:listing_own'));

	$list = list_user_objects(get_loggedin_userid(),'emMap', 10, false);

	// get tagcloud
	// $area3 = "This will be a tagcloud for all blog posts"; ."<pre>".print_r($list,true)."</pre>"

	$body = elgg_view_layout("two_column_left_sidebar", '', $area2.$list);
	
// Display page
	page_draw(elgg_echo('maps:plugin_name'),$body);
?>
