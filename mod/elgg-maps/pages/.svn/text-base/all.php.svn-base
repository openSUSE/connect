<?php

//include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();
//sacado del mod/blog

	//define('everyoneblog','true');
	require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

	set_page_owner(get_loggedin_userid());

	$offset = (int)get_input('offset', 0);
	
	$area2 = elgg_view_title(elgg_echo('maps:listing_all'));

	$list = elgg_list_entities(array('type' => 'object', 'subtype' => 'emMap', 'limit' => 10, 'offset' => $offset, 'full_view' => FALSE));

	// get tagcloud
	// $area3 = "This will be a tagcloud for all blog posts"; ."<pre>".print_r($list,true)."</pre>"
	$area3 = "";
	//$area3 = "<pre>".print_r($CONFIG->actions,true)."</pre>";

	$body = elgg_view_layout("two_column_left_sidebar", '', $area2.$list.$area3);
	
// Display page
	page_draw(elgg_echo('maps:plugin_name'),$body);
?>
