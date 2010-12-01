<?php

/**
 * Elgg poll individual post view
 *  
 * @package Elggpoll_extended
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg <big_lizard_clyde@hotmail.com>
 * @copyright John Mellberg - 2009
 *
 * @uses $vars['entity'] Optionally, the poll post to view
*/
?>
<div id="poll_widget_container" class="poll_post">
	<?php echo elgg_view('polls/poll_widget_content',$vars); ?>
</div>
<script type="text/javascript">
	function toggleResults() {
		if ($("#poll_vote_form_container").is(":visible")) {
			$("#poll_vote_form_container").hide();
			$("#resultsDiv").show();
			$("#poll_show_link").html("<?php echo elgg_echo('polls:show_poll'); ?>");
		} else {
			$("#poll_vote_form_container").show();
			$("#resultsDiv").hide();
			$("#poll_show_link").html("<?php echo elgg_echo('polls:show_results'); ?>");
		}
	}	
</script>
	