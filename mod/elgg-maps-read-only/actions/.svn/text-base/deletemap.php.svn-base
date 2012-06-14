<?php
// only logged in users can edit maps
//gatekeeper();

$guid = get_input('mapGUID');
$map = get_entity($guid);
if($map->canEdit())
{
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
?>
