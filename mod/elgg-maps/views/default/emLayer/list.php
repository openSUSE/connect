<?php
$insideGroups = elgg_get_entities(
	array(
		'type' => 'object',
		'subtype' => 'emLayer',
		'container_guid' => $vars['mapID'] ,
		'count' => true
	)
);
?>
<div id="mapPointGroupList">
<h2>Capas en este mapa (<?php echo $insideGroups;?>)</h2>
<?php
echo elgg_list_entities(
	array(
		'type' => 'object',
		'subtype' => 'emLayer',
		'container_guid' => $vars['mapID'] ,
		'full_view' => FALSE
	)
);
?>
</div>