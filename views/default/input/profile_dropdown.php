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
	$class = "input-profile_dropdown";
}

$disabled = false;
if (isset($vars['disabled'])) {
	$disabled = $vars['disabled'];
}

if (isset($vars['options'])) {
	$data=$vars['options'];
} else {
	$tmp="profile:data:" . $vars['internalname'];
	$tmp=elgg_echo($tmp);
	$data=explode(':',$tmp);
}

?>

<select <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?> name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> class="<?php echo $class; ?>" size=1>
		<option value=""  <?php if($vars['value']=="")   echo "selected";?>><?php
			echo elgg_echo("checkbox:empty");
		?></option>
<?php
	foreach($data as $option) {
		$label = "profile:data:" . $vars['internalname'] . ":" . $option;
		$label = elgg_echo($label);
		if($vars['value'] == $vars['internalname'] . ":" . $option)
			$checked="selected";
		else
			$checked="";
		echo "<option value=\"${vars['internalname']}:${option}\" $checked>" . $label . "</option>";
	}
?>
</select>
