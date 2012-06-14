<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

/**
 * Actions library
 *
 * The code inhere defines the functions used by actions and API methods
 */
 
// get the form input

function emJSONError($error)
{
	echo json_encode(array('emError'=>$error));
}


function emError($error)
{
	echo $error;
}

function emGetMap($guid)
{
	
    $emMap = get_entity($guid);
	
	if (!$emMap || $emMap->getSubtype() != 'emMap') {
		$emMap = false;
	}
	return $emMap;
}

function emGetFeature($guid)
{
	
    $emFeature = get_entity($guid);
	
	if (!$emFeature || $emFeature->getSubtype() != 'emFeature') {
		$emFeature = false;
	}
	return $emFeature;
}

function emGetMapData($guid)
{
	
	if ( ! $emMap = emGetMap( $guid ) ) {
		return;
	}
    $emMapData = array();
	
	// Get basic metadata
    foreach($emMap->getExportableValues() as $name) {
	$emMapData[$name] = $emMap->$name;
    }
	// Get Extended metadata
    foreach(get_metadata_for_entity($guid) as $metadata) {
	$emMapData[$metadata->name] = $emMap->getMetadata($metadata->name);
    }
	
	//Get layers
	$layersObject = elgg_get_entities(array(
		'type'=>'object',
		'subtype'=>'emLayer',
		'container_guid'=>$emMap->getGUID()	
	));
	$layers = array();
	foreach($layersObject as $layer)
	{
		$id = $layer->getGUID();
		$layers[$id] = array(
			'title'=>$layer->title,
			'description'=>$layer->description
		);
	}
	$emMapData['layers'] = $layers;
    return $emMapData;
}

function emShowMap($guid)
{
	//emRestrictViewAccess($guid);
	
    $emMap = emGetMapData($guid);
	
	if (!$emMap) {
		emJSONError('emMap_unavailable');
		return;
	}	
    //die(print_r(get_metadata_for_entity($guid),true));
    echo json_encode($emMap);
    return $emMap;
}

function emShowVisibleMapsList($userGUID)
{
	$visibleMaps = elgg_get_entities(array(
		'type'=>'object',
		'subtype'=>'emMap'
	));
	
	if (!$visibleMaps) {
		emError('no_visible_maps');
		return;
	}
	
	echo elgg_list_entities(array('type' => 'object', 'subtype' => 'emMap', 'limit' => 100, 'offset' => $offset, 'full_view' => FALSE));
}

function emShowEditMapForm($guid)
{
	$emMap = emGetMap($guid);
	if ( $emMap )  {
		echo elgg_view('emMap/form', array('mapData'=>$emMap));
	} else {
		echo elgg_view('emMap/form');
	}
}

function emShowMapMetadata($guid)
{
	if ($emMap = emGetMap($guid) ) {
		echo elgg_view('emMap/view', array('entity'=>$emMap));
	}
	
}

/**
 * Erases a map object if current user
 * can edit it.
 *
 * @param {integer} guid The GUID of the emMap Object
 */
function emDeleteMap($guid)
{
	$map = get_entity($guid);
	if($map->canEdit()) {
		//disable(reason,recursive)???
		//$map->delete_entity(guid, recursive), no figura en la doc,
		// solo esta el delete, que no lleva args
		//$map->disable("Owner Action",true);
		$deleted = delete_entity($map->getGUID(),true);
		system_message("Mapa borrado ".$deleted);
	}else{
		system_error("No puede borrar ese mapa");
	}
	forward(ELGG_MAPS_URL.'owned');

}
/**
 * Erases a emMap object with guid
 * gotten from get_input()
 *
 * Devuelve null si no pudo borrar el mapa.
 */
function emDeleteMapAsRequested()
{
	$guid = get_input('mapGUID');
	return emDeleteMap($guid);
}

/**
 * Tries to update an emMap subtype with data
 * that arrives from get_input()
 *
 */
function emUpdateMapAsRequested()
{
	$attributes = array(
		'guid' => get_input('mapGUID'),
		'title' => get_input('title'),
		'description' => get_input('description'),
		'tags' => string_to_tag_array(get_input('tags')),
		'access_id' => (int) get_input('access_id', ACCESS_PRIVATE),
		'extent' => array(
			'left'=>get_input('extentLeft'),
			'bottom'=>get_input('extentBottom'),
			'right'=>get_input('extentRight'),
			'top'=>get_input('extentTop')
		),
		'projection' => get_input('projection'),
		/*
		 * 'features' is an array used by class ElggMap
		 * It's a hidden input that holds data from the 
		 * OpenLayers.Feature.Vector objects that where modified
		 * bye the user.
		 * 'features' may be empty if no feature was
		 * modified on the client even
		 * if there are features on the layers.
		 */
		'features' => get_input('features') ? get_input('features'): array(),
		'delete' => get_input('deleteFeatures') ? get_input('deleteFeatures') : array()
	);
	
	return emUpdateMap($attributes);
}

/**
 * Tries to update an emMap subtype with data
 * that arrives from get_input()
 *
 */
function emUpdateMapAsRequestedFromAjax()
{
	$data = get_input('metadata');
	
	/**
	 * @todo filtrar data
	 */

	$newmetadata = array();
	foreach($data as $each) {
		$newmetadata[$each['name']] = $each['value'];
	}
	$metadata = $newmetadata;

	$features = get_input('features');

	$delete = get_input('deleteFeatures');
	
	$attributes = array_merge($metadata, array(
		'tags' => string_to_tag_array($metadata['tags']),
		'access_id' => ((int) $metadata['access_id']) ? (int) $metadata['access_id'] : ACCESS_PRIVATE,		
		'extent' => array(
			'left'=>$metadata['extentLeft'],
			'bottom'=>$metadata['extentBottom'],
			'right'=>$metadata['extentRight'],
			'top'=>$metadata['extentTop']
		),
		'features' => $features ? $features : array(),
		'delete' => $delete ? $delete : array()		
	));

	return emUpdateMap($attributes['mapGUID'], $attributes);
}

/**
 * Updates map with attributes from $params;
 *
 * @param {Object} The entity properties object
 * Properties expected
 * - guid
 * - title
 * - tags
 * - access_id
 * - extent
 * - projection
 * - features (array of features to be deleted.
 * - delete (array of features to be deleted)
 * - array of features to bedeleted
 */
function emUpdateMap($guid, $newProperties)
{
	$return = false;
	//get saved entity
	$mapobject = emGetMap($guid);
	
	if ($mapobject) {
		//set new values
		if (! $mapobject->canEdit() ) {
			return false;
		}
		
		$mapobject->title = $newProperties['title'];
		$mapobject->description = $newProperties['description'];
		$mapobject->tags = $newProperties['tags'];
		$mapobject->extent = $newProperties['extent'];
		$mapobject->projection = $newProperties['projection'];

		// Set access for the map (default to ACCESS_PRIVATE if not provided
		
		// if($newProperties->access_id != $mapobject->access_id) {
			// updateAccessId($mapobject, $newProperties->access_id);
		// }
		
		$mapobject->access_id = $newProperties['access_id'];

		// save to database, no need for GUID retrieval
		$return = $mapobject->save();

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

		emUpdateFeatures($newProperties['features']);

		foreach($newProperties[ 'delete' ] as $d) {
			delete_entity($d['guid']);
		}
		
		//return $return;
	}
	return true;
}

function emUpdateFeatures($newProperties, $projection='EPSG:4326')
{
	if (is_array($newProperties) && !empty($newProperties[0])  ) {
		foreach($newProperties as $np) {
			emUpdateFeatures($np, $projection);
		}
		return;
	}

	if(!empty($newProperties['guid']) ){
		//este es un feature de antes;
		$feature = get_entity($newProperties['guid']);
		$feature->title = $newProperties['title'];
		$feature->description = $newProperties['description'];
		$feature->wkt = $newProperties['wkt'];
		$feature->projection = $projection;
	} else {
		$feature = new ElggObject();
		$feature->title = $newProperties['title'];
		$feature->description = $newProperties['description'];	
		$feature->subtype = 'emFeature';
		$feature->container_guid = $newProperties['layerGUID'];
		$feature->owner_id = get_loggedin_userid();
		$feature->access_id = $access_id;
		$feature->wkt = $newProperties['wkt'];
		$feature->projection = $projection;
	}
	$feature->save();
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
