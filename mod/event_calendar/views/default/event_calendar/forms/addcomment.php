<?php

/**
 * Elgg event_calendar add comment on fields
 *
 * @package event_calendar
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 */

?>

	<form action="<?php echo $event->getURL(); ?>" method="post">
		<p class="longtext_editarea">
			<label><<br />
			<?php

				echo elgg_view("input/longtext",array(
									"internalname" => "comment_post",
									"value" => $body,
													));
			?>
			</label>
		</p>
		//<p>
		    <!-- pass across the topic guid -->
			<input type="hidden" name="topic_guid" value="<?php echo $vars['entity']->guid; ?>" />
			<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->container_guid; ?>" />
			
<?php 
		echo elgg_view('input/securitytoken');
?>
			<!-- display the post button -->
			<input type="submit" class="submit_button" value="<?php echo elgg_echo('post'); ?>" />
		</p>
	
	</form>