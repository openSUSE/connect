<?php
// only logged in users can edit maps
gatekeeper();

// get the form input

$title = get_input('title');
$description = get_input('description');
$tags = string_to_tag_array(get_input('tags'));
$access_id = (int) get_input('access_id', ACCESS_PRIVATE);
$extent = array(
	'left'=>get_input('extentLeft'),
	'bottom'=>get_input('extentBottom'),
	'right'=>get_input('extentRight'),
	'top'=>get_input('extentTop')
);
$projection = get_input('projection');
// el extent podria guardarse como un solo string
// lo dejo asi para poder pedir discriminadamente cualquier bound
//$extent = get_input('extent');
// create a new map object
$mapobject = new ElggObject();
$mapobject->title = $title;
$mapobject->description = $description;
$mapobject->tags = $tags;
$mapobject->subtype = "emMap";

$mapobject->extent = $extent;
$mapobject->projection = $projection;

// Set access for the map (default to ACCESS_PRIVATE if not provided
$mapobject->access_id = $access_id;

// owner is logged in user
$mapobject->owner_guid = get_loggedin_userid();

// save to database
$newmapGUID = $mapobject->save();

//create default layer and set it as default
//save after map to set map guid to layer->container_guid
$layer = new ElggObject();
$layer->title = 'Predefinida';
$layer->description = 'Capa genérica';
$layer->subtype = "emLayer";
$layer->container_guid = $newmapGUID;
$layer->access_id = $access_id;
$layer->owner_guid = get_loggedin_userid();
$layer->is_default = true;
//desde el mapa llega esto
$layer->projection = $projection;
//falta el style

$layerGUID = $layer->save();

$features = get_input('features');
foreach($features as $f){
	$feature = new ElggObject();
	$feature->title = $f['title'];
	$feature->description = $f['description'];
	$feature->subtype = 'emFeature';
	$feature->container_guid = $layerGUID;
	$feature->owner_id = get_loggedin_userid();
	$feature->access_id = $access_id;
	$feature->wkt = $f['wkt'];
	$feature->projection = $projection;
	$feature->save();
}

// forward user to a page that displays the map
forward($mapobject->getURL());

//debug
//echo "Points to delete<br /><pre>".print_r($delete,true)."</pre>";
?>
