<?php
/** 
 * Google Maps plugin for the Elgg social network engine.
 */ 

$settings = find_plugin_settings('google-map');
$key = $settings->api_key;
if (DOMAIN == 'alice.com') {
  $key = 'ABQIAAAATmXYGjIxcoW0PZTT8B5-yxS9gD-IG-XY9TtpNzaYqj1O2EUssBQLVLDAdqta9MoaHyhBNbPVTJh1PQ';
}

echo "<script src='http://maps.google.com/maps?file=api&v=2&key={$key}' type-='text/javascript'></script>"; 
echo "<script type='text/javascript'>";
include($CONFIG->pluginspath . '/google-map/js/gmap.php');
echo "var IMAGES='{$CONFIG->url}mod/google-map/images/';";
echo "</script>";
?>