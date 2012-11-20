<?php
  /**
   * Google Map default view
   *
   * @package famos
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author famos LLC <info@famos.com>
   * @copyright famos LLC 2008
   * @link http://famos.com/
   */

// Lazy-load google scripts if we're not a widget; avoids the overhead of a
// gmap script load if there are no gmaps on the page
if (!$vars['entity']) {
  gmap_load_scripts();
}

$id = isset($vars['internalid'])?$vars['internalid']:"gmap-".mt_rand();
$pattern = '/\([ \t]*([\+\-]?[0-9]+(\.[0-9]*)?)[ \t]*,[ \t]*([\+\-]?[0-9]+(\.[0-9]*)?)[ \t]*\)/';
if (preg_match($pattern, trim($vars['location']), $matches)) {
  $lat = (float)$matches[1];
  $lng = (float)$matches[3];
  $location = "{lat:$lat,lng:$lng}";
}
else {
  $location = $vars['location'];
  if (!preg_match('/^".*"$/', $location)) {
    $location = '"' . $location . '"';
  }
}
if (empty($location) || $location == '""') {
  $location = GMAP_DEFAULT_LOCATION;
}

$zoom = intval($vars['zoom']);

if ($vars['controls'] == 'none') {
  $controls = "[]";
}
else if (isset($vars['controls'])) {
  $controls = $vars['controls'];
}
else {
  // TODO: allow more flexibility with controls
  $controls = "['GSmallMapControl']";
}

$mapOptions = '{';
if (is_array($vars['mapOptions'])) {
  $comma = '';
  foreach ($vars['mapOptions'] as $key => $value) {
    $mapOptions .= $comma . $key . ":{$value}";
    $comma = ',';
  }
}
$mapOptions .= '}';

$markers = 'false';
if (is_array($vars['markers'])) {
  $markers = json_encode($vars['markers']);
}

$options = "{";
// FIXME $.gmap.center called twice w/default if address not set
if ($location) {
  $options .= "address:{$location},";
}
if ($zoom) {
  $options .= "zoom:{$zoom},";
}
$options .= "controls:{$controls},mapOptions:{$mapOptions},";
$options .= "autoPopulate:".(($vars['autoPopulate'] === false)?'false':'true');
$options .= "}";

// Uncomment to list users above map
//echo list_entities('user');

echo <<<EOT
<div id="{$id}" class='gmap' style="overflow:hidden">
  <noscript>
  Map is unavailable
  </noscript>
</div>

<script type='text/javascript'>
// Delayed load is required, or elgg page continually reloads
$(document).ready(function() {
    var el = $('#{$id}');
    el.width($("#{$id}-container").width());
    if (el.height() < 100) {
      el.height(300);
    }
    el.gmap({$options});
    var map = $.gmap.maps["{$id}"];
    if (map && map.autoPopulate) {
      $('.gmapped').each(function() {
          $.gmap.mark(map, this);
      });
       // Catch dynamically loaded content
      $(document).bind('ajaxComplete', function() {
          $('.gmapped').each(function() {
              $.gmap.mark(map, this);
            });
        });
    }
    var markers = {$markers};
    if (map && markers) {
      $.each(markers, function() {
          $.gmap.mark(map, this);
      });
    }
  });
</script>
EOT;
?>