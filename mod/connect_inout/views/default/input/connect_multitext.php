<?php
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
<?php } } ?>
<p><input type="text" <?php if ($disabled) echo ' disabled="yes" '; ?> name="<?php echo $vars['internalname'] . '[]'; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}1\""; ?> value="" class="<?php echo $class ?>"/></p>
