<?php

	$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
	$object = get_entity($vars['item']->object_guid);
	$objecturl = $object->getURL();
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("groups:river:member"),$url) . " ";
	$string .= " <a href=\"" . $object->getURL() . "\">" . $object->name . "</a>";
	$string .= "<div class=\"river_content_display\">";
	$string .= "<table><tr><td>" . elgg_view("profile/icon",array('entity' => $performed_by, 'size' => 'small')) . "</td>";
	$string .= "<td><div class=\"following_icon\"></div></td><td>" . elgg_view("profile/icon",array('entity' => $object, 'size' => 'small')) . "</td></tr></table>";
	$string .= "</div>";
	
?>

<?php echo $string; ?>