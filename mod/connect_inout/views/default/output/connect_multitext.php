<?php
require_once 'connect_url-create.php';

if(is_array($vars['value'])) {
	$iter = $vars['value'];
} else {
	$iter = array( $vars['value'], "");
}

echo "<ul>";
foreach($vars['value'] as $item) {
	if($item && strlen($item) > 0)
		echo '<li>' . create_url($vars['internalname'], $item) . '</li>';
}
echo "</ul>";
?>
