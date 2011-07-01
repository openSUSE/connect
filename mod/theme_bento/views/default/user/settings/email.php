<?php
/**
 * Provide a way of setting your email
 *
 * @package Elgg
 * @subpackage Core
 */

$user = page_owner_entity();

if ($user) {
?>
<h3><?php echo elgg_echo('email:settings'); ?></h3>
<p>
	<?php echo elgg_echo('email:address:label') . "<em> " . $user->email . "</em>" ?><br />
	<?php echo elgg_echo('profile:ichainsettings')?>
	<?php

		echo elgg_view('input/hidden',array('internalname' => 'email', 'value' => $user->email));

	?>
</p>

<?php
}
