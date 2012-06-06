<?php

  /**
   * Google Map edit page
   *
   * @package MOVITravel
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author MOVI LLC <info@movillc.com>
   * @copyright MOVI LLC 2008
   * @link http://movillc.com/
   */

?>
<p>
<?php
echo elgg_echo("gmap:location");
echo elgg_view('input/text', array('internalname'=>'params[location]',
                                   'value'=>$vars['entity']->location));
echo elgg_echo("gmap:zoom"); 
$zoom = GMAP_DEFAULT_ZOOM;
if (isset($vars['entity']->zoom)) {
  $zoom = $vars['entity']->zoom;
}
echo elgg_view('input/pulldown', array('internalname'=>'params[zoom]',
                                       'value'=>$zoom,
                                       'options'=>range(0,20)));
echo "<br />";

?>
</p>