<?php
    
  /**
   * Google Map view page
   *
   * @package travelqube
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author movi LLC <info@movillc.com>
   * @copyright famos LLC 2009
   * @link http://famos.com/
   */

$options = array('location', 'zoom');
foreach ($options as $opt) {
  if (isset($vars['entity']->$opt)) {
    $vars[$opt] = $vars['entity']->$opt;
  }
}
echo elgg_view('google-map/view', $vars);
?>

