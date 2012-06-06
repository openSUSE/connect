<?php

  /**
   * Google Map widget
   * This plugin allows users to display a Google Map
   * 
   * @package MOVITravel
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author MOVI LLC <info@movillc.com>
   * @copyright MOVI LLC 2008
   * @link http://movillc.com/
   */
if (is_callable('geoip_readable')) {
  define('GMAP_DEFAULT_LOCATION', '"'.geoip_readable().'"');
}
else if (isset($_SESSION['user']) && is_array($_SESSION['user']->location)) {
  define('GMAP_DEFAULT_LOCATION', '"'.implode(',',$_SESSION['user']->location).'"');
}
else {
  define('GMAP_DEFAULT_LOCATION', '"Elgg, Switzerland"');
}
define('GMAP_DEFAULT_ZOOM', 13);

function gmap_init() {

  extend_view('css', 'google-map/css');
  extend_view('page_elements/footer', 'google-map/footer');
  extend_view('widgets/wrapper', 'google-map/gmap-support', 499);

  add_widget_type('google-map', elgg_echo('gmap'), elgg_echo('gmap:desc'));
}
		
/** 
 * $address address or (lat,lng)
 * $options['html'] contents of marker info window
 * $options['origin'] selector where to install a click handler which centers
 *      map and displays the info window
 * $options['type'] type of icon
 */
function gmap_marker($address, $options=array()) {
  $attr = 'address';
  $pattern = '/\([ \t]*[-+]?[0-9.]+[ \t]*,[ \t]*[-+]?[0-9.]+?[ \t]*\)/';
  $origin = isset($options['origin']) ? " origin='{$options['origin']}'" : "";
  $html = $options['html'];
  $type = isset($options['type']) ? " type='{$options['type']}'" : "";
  if (preg_match($pattern, trim($address))) {
    $attr = 'latlng';
  }
  return "<div class='gmapped' $attr='$address'$origin$type>$html</div>";
}

function gmap_load_scripts() {
  global $CONFIG;
  if (!(isset($CONFIG->views) && isset($CONFIG->views->extensions)
        && isset($CONFIG->views->extensions['google-map/metatags']))) {
    extend_view('metatags', 'google-map/metatags');
  }
}

register_elgg_event_handler('init','system','gmap_init');

?>