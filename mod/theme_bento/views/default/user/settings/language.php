<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

global $CONFIG;
$user = page_owner_entity();

if ($user) {
?>

      <?php

		$value = $CONFIG->language;
		if ($user->language) {
			$value = $user->language;
		} else {
			$value = "en";
		}

		echo elgg_view("input/hidden", array('internalname' => 'language', 'value' => $value));

	?>

</p>

<?php
}
