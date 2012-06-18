<p>
<?
/*
 * Mapas base para seleccionar
 */
$baseMapTypeOptions = array(
	elgg_echo('maps:useGoogleMapsSatelliteMap')=>'googlemapssatellite',
	elgg_echo('maps:useOpenLayersWMSLayer')=>'openlayers.wms'
);


$elgg_maps_baseMapType = get_plugin_setting('basemaptype', 'maps');
if (!$elgg_maps_baseMapType) {
        $elgg_maps_baseMapType = 'googlemapssatellite';
}
$elgg_maps_googleAPIKey = get_plugin_setting('googleapikey', 'maps');


?>
<?php echo elgg_echo('maps:baseMapType'); ?><br/>
<?php echo elgg_view('input/radio', array('internalname'=>'params[basemaptype]',
                     'value'=>$elgg_maps_baseMapType,
										 'options'=>$baseMapTypeOptions
									)
			);
?>
<?php echo elgg_echo('maps:googleAPIKey'); ?><br/>
<?php echo elgg_view('input/text', array('internalname'=>'params[googleapikey]',
                                         'value'=>$elgg_maps_googleAPIKey
									)
			);
?>
<?php echo elgg_echo('maps:useMapFrontPage'); ?>
	<select name="params[usemapfrontpage]">
		<option value="yes" <?php if ($vars['entity']->usemapfrontpage == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
		<option value="no" <?php if ($vars['entity']->usemapfrontpage != 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	</select>
</p>
