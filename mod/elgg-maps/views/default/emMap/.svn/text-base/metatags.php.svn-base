<?php
/** 
 * Javascript includes for openlayers
 */ 
//$settings = find_plugin_settings('google-map');
//$key = $settings->api_key;
/*
 * TODO: call elgg function to guess plugin url -> lesto, mirar el start.php->init
 */
/*
TODO 2:
no encontre otra manera de traer variables aca que no fuera por $_SESSION
ver el wrapper en start.php -> storeVars/restoreVars
*/
echo "<link tyle='text/css' href='". ELGG_MAPS_WEBPATH ."css/cupertino/jquery-ui-1.8.11.custom.css' rel='stylesheet'>";

//lite build???
//echo "<script src='" . ELGG_MAPS_WEBPATH . "js/lib/OpenLayers-2.9/build/OpenLayers.js'></script>\n";

//full build
echo "<script src='" . ELGG_MAPS_WEBPATH . "js/lib/OpenLayers-2.9/OpenLayers.js'></script>\n";

//for google, v2.10
//echo '<script src="http://maps.google.com/maps/api/js?v=3.3&amp;sensor=false"></script>';
//echo "<script src='http://www.openlayers.org/dev/OpenLayers.js'></script>\n";

echo "<script type='text/javascript'>\n" .
	"var ELGG_MAPS_WEBPATH = '" . ELGG_MAPS_WEBPATH . "';\n" .
	"var ELGG_MAPS_URL = '" . ELGG_MAPS_URL . "';\n" .
"</script>\n";
echo "<script src='" . ELGG_MAPS_WEBPATH . "js/ElggMap.constants.js'></script>\n";
echo "<script src='" . ELGG_MAPS_WEBPATH . "js/OpenLayers.Feature.Vector.ext.js'></script>\n";
echo "<script src='" . ELGG_MAPS_WEBPATH . "js/OpenLayers.Layer.Vector.emKML.js'></script>\n";
echo "<script src='" . ELGG_MAPS_WEBPATH . "js/ElggMap.js'></script>\n";
?>
