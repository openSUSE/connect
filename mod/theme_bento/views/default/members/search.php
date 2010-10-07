<?php

	/**
	 * Simple member search
	 **/

$tag_string = elgg_echo('members:search:tags');
$name_string = elgg_echo('members:search:name');

?>

<div class="sidebarBox box box-shadow navigation alpha">

<h2 class="box-header"><?php echo elgg_echo('members:searchtag'); ?></h2>
<form id="memberssearchform" action="<?php echo $vars['url']; ?>mod/members/index.php?" method="get">
	<input type="text" name="tag" value="<?php echo $tag_string; ?>" onclick="if (this.value=='<?php echo $tag_string; ?>') { this.value='' }" class="search_input" />
	<input type="hidden" name="filter" value="search_tags" />	
	<input type="submit" value="<?php echo elgg_echo('go'); ?>" />
</form>

<h2 class="box-subheader"><?php echo elgg_echo('members:searchname'); ?></h2>
<form id="memberssearchform" action="<?php echo $vars['url']; ?>mod/members/index.php?" method="get">
	<input type="text" name="tag" value="<?php echo $name_string; ?>" onclick="if (this.value=='<?php echo $name_string; ?>') { this.value='' }" class="search_input" />
	<input type="hidden" name="subtype" value="" />
	<input type="hidden" name="object" value="user" />
	<input type="hidden" name="filter" value="search" />	
	<input type="submit" value="<?php echo elgg_echo('go'); ?>" />
</form>

</div>