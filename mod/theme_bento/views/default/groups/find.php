<?php

	/**
	 * A simple group search by tag view
	 **/

$tag_string = elgg_echo('groups:search:tags');
	 
?>
<div class="sidebarBox box box-shadow navigation">
<h2 class="box-header"><?php echo elgg_echo('groups:searchtag'); ?></h2>
<form id="groupsearchform" action="<?php echo $vars['url']; ?>pg/groups/world/" method="get">
	<input type="text" name="tag" value="<?php echo $tag_string; ?>" onclick="if (this.value=='<?php echo $tag_string; ?>') { this.value='' }" class="search_input" />
	<input type="submit" value="<?php echo elgg_echo('go'); ?>" />
</form>
</div>