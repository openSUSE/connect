<?php
/**
* copia de index.php
*/
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();

$user_guid =  get_loggedin_userid();
set_page_owner($user_guid);


/*
global $CONFIG;
echo "<pre>".print_r($CONFIG->views,true)."</pre>";
die($CONFIG->viewpath);
*/
//die(ELGG_MAPS_SYSTEMPATH.'views/emMap/mapview');
//set_view_location('pageshells/pageshell',ELGG_MAPS_SYSTEMPATH.'views/default/emMap/mapview');
//$body = elgg_view_layout('two_column_left_sidebar',false,elgg_view('emMap/mapview'));


elgg_maps_load_scripts();

	/* aca no van estos porque los setea start.php
	//add_submenu_item(elgg_echo('maps:new_map'), ELGG_MAPS_URL.'add','mapactions');
	add_submenu_item(elgg_echo('maps:your_maps'), ELGG_MAPS_URL.'owned', 'maplinks');
	add_submenu_item(elgg_echo('maps:all_site_maps'), ELGG_MAPS_URL.'all','maplinks');
	add_submenu_item(elgg_echo('maps:all_wmsservers'), ELGG_MAPS_URL.'wmsserver/all', 'wmsserverlinks');
	//add_submenu_item(elgg_echo('save'), '#','mapactions','javascript:$("#formContainer").dialog("open");return false;');
	*/

$sidebar = elgg_view_title(elgg_echo('maps:new_map'));
//$sidebar .= elgg_view('emMap/toolBar');
$sidebar .= elgg_view('emMap/form');

$helpBar = elgg_view('emMap/layoutMax/edit_helpBar');

$body = "";

elggmaps_page_draw(elgg_echo('maps:plugin_name'),$body,$sidebar,$helpBar);

?>

