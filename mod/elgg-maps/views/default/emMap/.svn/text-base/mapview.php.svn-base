<?php

//esta view deberia poder llamarse con algunas vars tipo center y zoom
//estas vars deberian pasar a JS vars y laburar sobre el map.js para
//mostrar el mapa tal cual queremos/esta guardado
$height = 400;
if(!empty($vars['height'])) $height = $vars['height'];

/*
if(!empty($vars['mapObject']->extent) && is_array($vars['mapObject']->extent))
{
	$array = array(
		'zoomTo' => join(',',$vars['mapObject']->extent)
	);
	
	storeVars('mapOptions',$array);
}
*/
if($vars['mapObject'])
{
	$layersObject = elgg_get_entities(array(
		'type'=>'object',
		'subtype'=>'emLayer',
		'container_guid'=>$vars['mapObject']->getGUID()	
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
}
//$features = array();
elgg_maps_load_scripts();
/*
para mas facha, agregar al style:
-moz-box-shadow:1px 1px 10px #AAA;-webkit-box-shadow:1px 1px 10px #AAA;box-shadow:1px 1px 10px #AAA;
*/
?>
<div id="mapWrapper" style="padding:8px;min-height:<?php echo $height?>px;">
	<div id="mapcontainer" style=""></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	var savedLayer = <?php echo json_encode($layers);?>;
	elggMap.buildMap({
		externalLayers: savedLayer,
		initialExtent:<?php echo json_encode($vars['mapObject']->extent) ?>
	});
});
</script>