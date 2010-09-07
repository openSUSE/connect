<?php
/**
 * Elgg text output
 * Displays some text that was input using a standard text field
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 *
 * @uses $vars['text'] The text to display
 *
 */

require_once 'connect_url_data.php';

if(is_array($vars['value'])) {
   $iter = $vars['value'];
} else {
   $iter = array($vars['value']);
}

echo "<ul>";
foreach($vars['value'] as $item) {
   echo '<li>' . create_url($vars['internalname'], $item) . '</li>';
}
echo "</ul>";
