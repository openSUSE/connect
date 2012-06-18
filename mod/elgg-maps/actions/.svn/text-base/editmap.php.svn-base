<?php
// only logged in users can edit maps
gatekeeper();

$debug = false;

// get the form inputs
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

$GUID = get_input('mapGUID');

//get saved entity
$mapobject = get_entity($GUID);

//set new values
$mapobject->title = $title;
$mapobject->description = $description;
$mapobject->tags = $tags;

$mapobject->extent = $extent;
$mapobject->projection = $projection;

// Set access for the map (default to ACCESS_PRIVATE if not provided
if($access_id != $mapobject->access_id) updateAccessId($mapobject, $access_id);
$mapobject->access_id = $access_id;


// owner is logged in user, owner is same as before don't touch
//if($debug) echo "Map to save<br /><pre>".print_r($mapobject,true)."</pre>";

// save to database, no need for GUID retrieval
if(!$debug) $mapobject->save();
///////////////////////////////////////////////

//por el momento solo vamos a tener un layer
//asi que todo esto se desestima y los features
//se guardan con el container_guid que tenian...
//review!!!

// $layer = new ElggObject();
// $layer->title = 'Predefinida';
// $layer->description = 'Capa genérica';
// $layer->subtype = "emLayer";
// $layer->container_guid = $newmapGUID;
// $layer->access_id = $access_id;
// $layer->owner_guid = get_loggedin_userid();
// $layer->is_default = true;
// //desde el mapa llega esto
// $layer->projection = $projection;
// //falta el style

//ahora lo traen los features esto
//$layerGUID = get_input('layerGUID');

/*
 * 'features' is an array used by class ElggMap
 * It's a hidden input that holds data from the 
 * OpenLayers.Feature.Vector objects that where modified
 * bye the use.
 * 'features' may be empty if no feature was
 * modified on the client even
 * if there are features on the layers.
 */
$features = get_input('features') ? get_input('features'): array();

foreach($features as $f){
	if(!empty($f['guid']))
	{
		//este es un feature de antes;
		$feature = get_entity($f['guid']);
		$feature->title = $f['title'];
		$feature->description = $f['description'];
		$feature->wkt = $f['wkt'];
		$feature->projection = $projection;
	}else{
		$feature = new ElggObject();
		$feature->title = $f['title'];
		$feature->description = $f['description'];
		$feature->subtype = 'emFeature';
		$feature->container_guid = $f['layerGUID'];
		$feature->owner_id = get_loggedin_userid();
		$feature->access_id = $access_id;
		$feature->wkt = $f['wkt'];
		$feature->projection = $projection;
	}
	$feature->save();
}

$delete = get_input('deleteFeatures') ? get_input('deleteFeatures') : array();


foreach($delete as $d)
{
	if(!$debug) delete_entity($d['guid']);
}

// forward user to a page that displays the map
if(!$debug) forward($mapobject->getURL());

// muy lindo muy lindo, pero necesito hacer una action editmap porque esto
// se me va de las manos si tengo que checkear si es nuevo o no

if($debug){
	echo "debug";
}

//que fulero esto... una func para re-setear los access id con recursive
function updateAccessId($entity, $access_id, $recursive = true)
{
	//echo "recursive function";
	$entity->access_id = $access_id;
	if(!$recursive) return;
	$options = array('container_guid'=>$entity->getGUID(),'owner_guid'=>$entity->owner_guid);
	$children = elgg_get_entities($options);
	foreach($children as $child) updateAccessId($child,$access_id);
}
?>
