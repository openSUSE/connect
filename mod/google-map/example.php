<?php

  /** Example google map usage. */
  // example of how to add map markers: this adds one for each user displayed
  // on the page.  comment out this line if you don't want to see users
  // on your map.
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// The map view needs an initial zoom level
$options = array('zoom'=>2);

// The map view needs an initial location on which to center
if ($_SESSION['guid']) {
  $user = get_entity($_SESSION['guid']);
  if ($user->location) {
    $options['location'] = implode(' ', $user->location);
  }
}
if (!isset($options['location'])) {
  $options['location'] = 'Boston';
}


// You can explicitly add markers to the map view
$options['markers'] = array(array('address'=>'Boston',
                                  'html'=>'This is Boston',
                                  'type'=>'user'),
                            array('address'=>'(0,0)',
                                  'html'=>'<i>Middle of</i> <b>Nowhere</b>',
                                  'type'=>'attraction'));
$map = elgg_view('google-map/view', $options);

// Tack on gmap marker information to each user view
// This extra markup is read automatically by the map and converted into
// markers unless 
// $vars['autoPopulate'] == false
extend_view('profile/icon', 'google-map/user');
$users = list_entities('user');

$body = <<<EOT
<div id='users' style='float:left'>{$users}</div>
<div id='map'>{$map}</div>

EOT;

page_draw("Example of Google Map view usage", $body);

?>