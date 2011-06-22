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

echo create_url($vars['internalname'],$vars['value']);
?>
