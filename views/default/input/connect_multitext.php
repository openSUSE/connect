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
	$class = "input-text";
}

$disabled = false;
if (isset($vars['disabled'])) {
	$disabled = $vars['disabled'];
}

$values = str_replace(',/',',',explode(', ',$vars['value']));

?>

<?php
foreach($values as $item) {
	if($item != "") {
?>
	<p><input type="text" <?php if ($disabled) echo ' disabled="yes" '; ?> name="<?php echo $vars['internalname'] . '[]'; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> value="<?php echo htmlentities($item, ENT_QUOTES, 'UTF-8'); ?>" class="<?php echo $class ?>"/></p>
<?php }} ?>
 <p><input type="text" <?php if ($disabled) echo ' disabled="yes" '; ?> name="<?php echo $vars['internalname'] . '[]'; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}1\""; ?> value="" class="<?php echo $class ?>"/></p>
