<?php

	/**
	 * Elgg profile edit form
	 * 
	 * @package ElggProfile
	 * 
	 * @uses $vars['entity'] The user entity
	 * @uses $vars['profile'] Profile items from $CONFIG->profile, defined in profile/start.php for now 
	 */

?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/profile/edit" method="post">
<?php echo elgg_view('input/securitytoken') ?>
<?php

	//var_export($vars['profile']);
	if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0)
		foreach($vars['config']->profile as $shortname => $valtype) {
			if ($metadata = get_metadata_byname($vars['entity']->guid, $shortname)) {
				if (is_array($metadata)) {
					$value = '';
					foreach($metadata as $md) {
						if (!empty($value)) $value .= ', ';
						$value .= str_replace(',', ',/',$md->value);
						$access_id = $md->access_id;
					}
				} else {
					$value = $metadata->value;
					$access_id = $metadata->access_id;
				}
			} else {
				$value = '';
				$access_id = ACCESS_DEFAULT;
			}

			$admin_only = in_array($shortname, array('freenode_nick', 'freenode_cloak', 'email_nick', 'email_full', 'email_target'));
			if (!$admin_only || isadminloggedin()) {
?>

	<p>
		<label>
			<?php echo elgg_echo("profile:{$shortname}") ?><br />
			<?php echo elgg_view("input/{$valtype}",array(
															'internalname' => $shortname,
															'value' => $value,
															)); ?>
		</label>
			<?php echo elgg_view('input/access',array('internalname' => 'accesslevel['.$shortname.']', 'value' => $access_id)); ?>
	</p>

<?php
			}
		}

?>

	<p>
		<input type="hidden" name="username" value="<?php echo page_owner_entity()->username; ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
	</p>

</form>
</div>