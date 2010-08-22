<?php
/**
 * Elgg text input
 * Displays a text input field
 *
 * @package Elgg
 * @subpackage Core

 * @author Curverider Ltd

 * @link http://elgg.org/
 *
 * @uses $vars['value'] The current value, if any
 * @uses $vars['js'] Any Javascript to enter into the input tag
 * @uses $vars['internalname'] The name of the input field
 * @uses $vars['disabled'] If true then control is read-only
 * @uses $vars['class'] Class override
 */


if (isset($vars['class'])) {
	$class = $vars['class'];
} else {
	$class = "input-profile_checkbox";
}

$disabled = false;
if (isset($vars['disabled'])) {
	$disabled = $vars['disabled'];
}

if (isset($vars['label'])) {
	$label=$vars['label'];
} else {
	$label="profile:long:" . $vars['internalname'];
	$label=elgg_echo($label);
}

?>

<p><input type="checkbox" <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?> name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> value="<?php echo $label; ?>" <?php if($vars['value']) echo checked; ?> class="<?php echo $class; ?>"/> <?php echo $label; ?></p>
