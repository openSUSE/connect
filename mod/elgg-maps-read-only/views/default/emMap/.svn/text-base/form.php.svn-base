<?php
if ( $vars['mapData'] ) {
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
} else {
	$GUID = false;
	$title =  "Sin título";
	$description = '';
	$tags = '';
	$access_id = ACCESS_PRIVATE;
	$extentLeft = $extentBottom = $extentRight = $extentTop = $projection = false;
}
?>
<div style='text-align:right'>
<button id='emMapStopEditButton' class='ui-button'>Listo</button>
<button id='emMapCancelEditButton' class='ui-button'>Cancelar</button>
</div>
<div id="formContainer" class="contentWrapper" style="margin-top:10px;">

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


</form>
</div>
