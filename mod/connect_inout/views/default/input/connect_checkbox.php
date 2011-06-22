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

if (isset($vars['options'])) {
	$data=$vars['options'];
} else {
	$tmp="profile:data:" . $vars['internalname'];
	$tmp=elgg_echo($tmp);
	$data=explode(':',$tmp);
}

?>

<select style="width: 100%;" <?php if ($disabled) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?> name="<?php echo $vars['internalname']; ?>" <?php if (isset($vars['internalid'])) echo "id=\"{$vars['internalid']}\""; ?> class="<?php echo $class; ?>" size=1>
		<option value=""  <?php if($vars['value']=="")   echo "selected";?>><?php
			echo elgg_echo("checkbox:empty");
		?></option>
		<option value="-1" <?php if($vars['value']<0)    echo "selected";?>><?php
			echo elgg_echo("checkbox:no");
		?></option>
		<option value="1" <?php if($vars['value']>0)     echo "selected";?>><?php
			echo elgg_echo("checkbox:yes");
		?></option>
</select>
