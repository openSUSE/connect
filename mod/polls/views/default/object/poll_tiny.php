<?php

/**
 * Elgg poll individual post view using a tiny presentation
 *
 * @package Elggpoll_extended
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg <big_lizard_clyde@hotmail.com>
 * @copyright John Mellberg - 2009
 *
 * @uses $vars['entity'] Optionally, the poll post to view
 */

if (isset($vars['entity'])) {
	$responses = $vars['entity']->countAnnotations('vote');
	$response_text = elgg_echo('polls:votes');
?>

<div class="poll_post">
<!-- display the user icon -->
<div class="poll_post_icon">
<?php
  echo elgg_view("profile/icon",array('entity' => $vars['entity']->getOwnerEntity(), 'size' => 'small'));
?></div>
<div class="search_listing_info">
<p><b><a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo $vars['entity']->question; ?></a></b></p>
<!-- poll type -->
<p>
<?php echo elgg_view('output/tags', array('tags' => elgg_echo($vars["entity"]->poll_type))); ?>
</p>
<!-- show rating input -->
<p><?php echo elgg_view('rating/rating', array('entity'=> $vars['entity'])); ?></p>
<p ><?php echo friendly_time($vars['entity']->time_created);?>&nbsp;
<?php echo elgg_echo('by'); ?> <a href="<?php echo $vars['url']; ?>pg/polls/list/<?php echo $vars['entity']->getOwnerEntity()->username; ?>"><?php echo $vars['entity']->getOwnerEntity()->name; ?></a>
<br /><?php echo "$responses $response_text"; ?>
</p>
</div>
<div class="clearfloat"></div>
</div>
<?php
}
?>