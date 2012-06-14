<?php

require(ELGG_MAPS_SYSTEMPATH.'vendors/geoPHP/geoPHP.inc');

$layerFeatures = array();

if($vars['layerObject']) {
	$layer = $vars['layerObject'];
	
	$layerFeatures = elgg_get_entities(array(
		'type'=>'object',
		'subtype'=>'emFeature',
		'container_guid'=>$layer->getGUID()
	));
	
	if(gettype($layerFeatures) != 'array') {
		$layerFeatures = array();
	}
	
}
?>
<?='<?xml version="1.0" encoding="UTF-8"?> '?>
	<kml xmlns="http://earth.google.com/kml/2.1"><Document>
	<Style id="pal1">
		<IconStyle>
		  <color>a1ff00ff</color>
		  <scale>1.399999976158142</scale>
		  <Icon>
			<href><?=ELGG_MAPS_WEBPATH?>/styles/pal1/icon1.png</href>
		  </Icon>
		</IconStyle>
		<LabelStyle>
		  <color>7fffaaff</color>
		  <scale>1.5</scale>
		</LabelStyle>
		<LineStyle>
		  <color>ff4f4072</color>
		  <width>2</width>
		</LineStyle>
		<PolyStyle>
		  <color>4c5253e8</color>

		</PolyStyle>
	  </Style>
	<?	
		foreach($layerFeatures as $f):
		//$f->access_id = 2;
		//$f->save();
		//$a = -58 + rand(0,3);
		//$f->wkt = "POINT($a -38)";
		//$f->save();
		//$s = $decoder->geomFromText($f->wkt)->toKML(); <- gisconverter
		//$s = wkt2kml($f->wkt);
		$s = geoPHP::load($f->wkt,'wkt');

			
		?>
		<Placemark id="feature<?=$f->getGUID()?>">
		<name><![CDATA[ <?=$f->title?> ]]></name>
		<title><![CDATA[ <?=$f->title?> ]]></title>
		<description><![CDATA[ <?=$f->description?> ]]></description>
		<guid><?=$f->getGUID()?></guid>
		<projection><?=$f->projection?></projection>
		<styleUrl>#pal1</styleUrl>
		<?=$s->out('kml')?>
        </Placemark>
	<?endforeach;?>
	</Document>
	</kml> 
	<?
	header('Content-type: application/vnd.google-earth.kml+xml');
	?>

