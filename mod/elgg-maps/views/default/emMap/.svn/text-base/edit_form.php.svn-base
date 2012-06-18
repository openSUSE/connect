<?php
$GUID = $vars['mapData']->guid;
$title = $vars['mapData']->title;
$description = $vars['mapData']->description;
$tags = $vars['mapData']->tags;
$access_id = $vars['mapData']->access_id;
$extentLeft = $vars['mapData']->extent[0];
$extentBottom = $vars['mapData']->extent[1];
$extentRight = $vars['mapData']->extent[2];
$extentTop = $vars['mapData']->extent[3];
$projection = $vars['mapData']->projection;
?>
<div class="contentWrapper" style="margin-top:10px">

<form id="emMapSaveForm" action="<?php echo $vars['url']; ?>action/elggmaps/map/edit" method="post">

<p>
<?php echo elgg_echo("title"); ?> <br/>
<?php echo elgg_view('input/text', array('value'=>$title,'internalname' => 'title')); ?>
</p>

<p>
<?php echo elgg_echo("description");?><br/>
<?php echo elgg_view('input/longtext', array('value'=>$description,'height'=>60,'internalname' => 'description', 'internalid'=>'description')); ?>
</p>

<p>
<?php echo elgg_echo("tags"); ?><br />
<?php echo elgg_view('input/tags',array('value'=>$tags,'internalname' => 'tags')); ?>
</p>

<p>
<?php echo elgg_echo("access");?><br/>
<?php echo elgg_view('input/access', array('value'=>$access_id,'internalname' => 'access_id')); ?>
</p>

<?php
echo elgg_view('input/securitytoken');

echo elgg_view('input/hidden',array('value'=>$extentLeft,'internalid'=>'extentLeft','internalname'=>'extentLeft'));
echo elgg_view('input/hidden',array('value'=>$extentBottom,'internalid'=>'extentBottom','internalname'=>'extentBottom'));
echo elgg_view('input/hidden',array('value'=>$extentRight,'internalid'=>'extentRight','internalname'=>'extentRight'));
echo elgg_view('input/hidden',array('value'=>$extentTop,'internalid'=>'extentTop','internalname'=>'extentTop'));
echo elgg_view('input/hidden',array('value'=>$projection,'internalid'=>'projection','internalname'=>'projection'));
echo elgg_view('input/hidden',array('value'=>$GUID,'internalid'=>'mapGUID','internalname'=>'mapGUID'));
//echo elgg_view('input/hidden',array('internalid'=>'extent','internalname'=>'extent'));
//ver actions/savemap para detalles del extent
?>

<p>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('save')));?></p>
</p>

</form>
<script language="javascript">
$(document).ready(function(){
	elggMap.populateForm = true;
		
	$('#emMapSaveForm').submit(function(e){
		$('#projection').val(elggMap.map.getProjection());
		var theForm = $(this);
		//theForm.append('<input type="hidden" name="layerGUID" value="'+elggMap.activeLayer.guid+'" />');
		var features = elggMap.activeLayer.features;
		$.each(features,function(key,value){
			if (!value.dirty()) return;
			var markersTitle = $('<input type="hidden" name="features['+key+'][title]" value="'+value.attributes.title+'" />');
			var markersDescription = $('<input type="hidden" name="features['+key+'][description]" value="'+value.attributes.description+'" />');
			var markersWkt = $('<input type="hidden" name="features['+key+'][wkt]" value="'+value.geometry.toString()+'" />');
			var markersGuid = $('<input type="hidden" name="features['+key+'][guid]" value="'+value.attributes.guid+'" />');
			//var markersSave = $('<input type="hidden" name="features['+key+'][saveThis]" value="'+value.saveThis+'" />');
			var markersLayer = $('<input type="hidden" name="features['+key+'][layerGUID]" value="'+value.layer.guid+'" />');
			theForm.append(markersTitle);
			theForm.append(markersDescription);
			theForm.append(markersWkt);
			theForm.append(markersGuid);
			//theForm.append(markersSave);
			theForm.append(markersLayer);
		});
		var deleteFeatures = elggMap.deleteQueue;
		$.each(deleteFeatures, function(key, value){
			var markersRemove = $('<input type="hidden" name="deleteFeatures[][guid]" value="'+value+'" />');
			theForm.append(markersRemove);
		});
		return true;
	});
});
</script>
</div>
