<?php
/**
 * ElggMaps pageshell
 * The standard HTML page shell that everything else fits into
 * only for site's index replacement
 * @package ElggMaps
 * use with elggmap_page_draw()
 *
 * @uses $vars['config'] The site configuration settings, imported
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 * @uses $vars['messages'] A 2d array of various message registers, passed from system_messages()
 */

// Set the content type
header("Content-type: text/html; charset=UTF-8");

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}

if(!empty($vars['mapObject']))
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

?>
<?php echo elgg_view('page_elements/header', $vars); ?>
<?php echo elgg_view('page_elements/elgg_topbar', $vars); ?>
<?php //echo elgg_view('page_elements/header_contents', $vars); ?>
<script type="text/javascript">
var buildLayout = null;
var buildLayerBox = null;
jQuery(document).ready(function(){
	buildLayout = function(resizeMapContainer)
	{
		var container = $('#map_layout_canvas');
		container.outerHeight( $(window).height() - container.offset().top - 5 );
		var mapWrapper = $('#mapWrapper');
		$('#mapSidebar').outerHeight( container.innerHeight() - $('#mapHelpbar').outerHeight() );
		mapWrapper.outerWidth( container.innerWidth() - $('#mapSidebar').outerWidth() );
		mapWrapper.outerHeight( container.innerHeight() - $('#mapHelpbar').outerHeight() );
		if(resizeMapContainer !== undefined && resizeMapContainer !== null && resizeMapContainer == true)
		{
			mapWrapper.children(':first').css('width','100%');
			mapWrapper.children(':first').css('height','100%');
		}
	}
	
	$(window).resize(function() {
		buildLayout();
		buildLayout(true);
		elggMap.triggerPan();
	});
	//fix para el chrome, cuando llama al menu hover sale resize
	$('li.drop').hover(function(){$(window).resize();});
	
	buildLayout(true);
<?if(!empty($vars['mapObject'])):?>
	elggMap.buildMap({
		initialExtent:<?php echo json_encode($vars['mapObject']->extent) ?>,
		externalLayers:<?php echo json_encode($layers);?>,
		mapGUID: <?=$vars['mapObject']->getGUID()?>
	});

<?else:?>
	elggMap.buildMap({editable:true});
<?endif;?>
	//var savedLayer = ;
	//if(savedLayer) elggMap.importLayers(savedLayer);
	//console.log('pageshell');

	
	//setup para la barrita de botones IN the map
	$('#helpBarToggles').buttonset();
	$('#c1').button();
	$('#c1').click(function(e){
		$('#formContainer').dialog('open');
	});
	$('#add_helpbarcontainer').show('slow');
	
	//function para agregar un layer. Falta code para el OL + OSK Layers
	buildLayerBox = function(id,title,description)
	{
		if(id === undefined || id === null) return false;
		if(title === undefined || title === null) title = '';
		if(description === undefined || description === null) description = '';
		var layerBox = $('<div class="layerBox" rel="'+id+'" />');
		layerBox.hide();
		layerBox.append('<h2>Layer</h2>');
		layerBox.append('<label for="title">Title</label><br />');
		layerBox.append('<input type="text" name="title" value="'+title+'" /><br />');
		layerBox.append('<label for="description">Description</label><br />');
		layerBox.append('<textarea name="description">'+description+'</textarea><br />');
		$('#layerBoxes').prepend(layerBox);
		layerBox.slideDown('slow');
	}
	
	$('#layerAdd').click(function(e){buildLayerBox(Math.floor(Math.random()*1000000))});
	$('#layerAdd').button({icons:{primary:'ui-icon-plus'}}).show();

});
</script>
<style type="text/css">
.layerBox {
	margin:5px;padding:5px;
	position:relative;
	background-color:#FAFAFA;
	-moz-border-radius:10px;
	border:1px solid #CCC;
}
.layerBox h2 {
	font-size:14px;
	margin-bottom:5px;
}
.layerBox label{font-size:12px;margin-left:5px;}
</style>

<!-- main contents -->

<!-- display any system messages -->
<?php //echo elgg_view('messages/list', array('object' => $vars['sysmessages'])); ?>


<!-- canvas -->
<div id="map_layout_canvas" style="border: 0px dashed red;">
	<div id="mapHelpbar" class="ui-layout-north" style="height:2px;background-color:#FFF;">
		<?php //echo $vars['helpbar'];?>
	</div>
	<div id="mapSidebar" class="ui-layout-west" style="width:250px;background-color:#EEE;float:left;overflow:auto;">
		<?php echo elgg_view('page_elements/owner_block',array('content'=>''));?>
		<?php //echo $vars['sidebar'];?>
		<div style="text-align:center"><button id="layerAdd" style="display:none;">Add layer</button></div>
		<div id="layerBoxes">
		</div>
	</div>
	<div id="mapWrapper" class="ui-layout-center" style="position:relative;padding:1px;min-height:400px;min-width:500px;width:500px;height:400px;float:left;">
		<?php //echo $vars['body']; ?>

			<div id="mapcontainer" style=""></div>
			<div id="add_helpbarcontainer" style="position:absolute;top:4px;right:4px;width:320px;height:28px;z-index:1200;font-size:10px;display:none;">
				<input id="c1" type="button" value="Guardar mapa" />
				<div id="helpBarToggles" style="display:inline">
					<input id="c4" type="checkbox" /><label for="c4">Estilos</label>
					<input id="c5" type="checkbox" /><label for="c5">Servidores WMS</label>
				</div>
			</div>
	</div>

</div><!-- /#layout_canvas -->

<?php
if(isloggedin()){
?>
	<!-- spotlight -->
	<?php //echo elgg_view('page_elements/spotlight', $vars); ?>
<?php
}
?>

<!-- footer -->
<?php //echo elgg_view('page_elements/footer', $vars); ?>
