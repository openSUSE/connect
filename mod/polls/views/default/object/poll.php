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

	if (isset($vars['entity'])) {
			
		if (get_context() == "groups") {
			echo elgg_view("polls/listing",$vars);
		}
		
		if (get_context() == "search") {
				
			//display the correct layout depending on gallery or list view
			if (get_input('search_viewtype') == "gallery") {

				//display the gallery view
            	echo elgg_view("polls/gallery",$vars);

			} else {
				
				echo elgg_view("polls/listing",$vars);

			}

		} else {
			
	?>
		<!-- patches by webgalli -->
	<div class="contentWrapper singleview">
		<div class="poll_edit_link">
				<!-- display edit options if it is the poll post owner -->
		<?php
		if ($vars['entity']->canEdit()) {
		?>
			<a href="<?php echo $vars['url']; ?>pg/polls/edit/<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo("edit"); ?></a>
			<?php
					
					echo elgg_view("output/confirmlink", array(
									'href' => $vars['url'] . "action/polls/delete?pollpost=" . $vars['entity']->getGUID(),
									'text' => elgg_echo('delete'),
									'confirm' => elgg_echo('deleteconfirm'),
									));
	
					// Allow the menu to be extended
					echo elgg_view("editmenu",array('entity' => $vars['entity']));
					
				}
			
			?>
		</div>
	<div class="poll_post">
		<h3><a href="<?php echo $url; ?>"><?php echo $vars['entity']->title; ?></a></h3>
		<!-- display the user icon -->
			<div class="poll_post_icon">
				<?php					
					echo elgg_view("profile/icon",array('entity' => $vars['entity']->getOwnerEntity(), 'size' => 'medium'));
				?>
			</div>
			<p class="strapline">
				<?php echo sprintf(elgg_echo("polls:strapline"), date("F j, Y",$vars['entity']->time_created)); ?>
				<?php echo elgg_echo('by'); ?> <a href="<?php echo $vars['url']; ?>pg/ad/<?php echo $vars['entity']->getOwnerEntity()->username; ?>"><?php echo $vars['entity']->getOwnerEntity()->name; ?></a> 
				<!-- display the comments link -->
				<?php
			    //get the number of responses
				$num_responses = $vars['entity']->countAnnotations('vote');
				//get the number of comments
				$num_comments = elgg_count_comments($vars['entity']);
			    ?>
			    <?php echo "(" . $num_responses . " " . sprintf(elgg_echo('polls:votes')) . ")"; ?> 
			<a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo sprintf(elgg_echo("comments")) . " (" . $num_comments . ")"; ?></a><BR>		
			</p>
			<!-- display tags -->
				<?php
	
					$tags = elgg_view('output/tags', array('tags' => $vars['entity']->tags));
					if (!empty($tags)) {
						echo '<p class="tags">' . $tags . '</p>';
					} else {
						echo '<p>&nbsp;</p>';
					}
				?>
			</div></div>
<div class="clearfloat"></div>
	<div class="poll_post">
		<div class="poll_post_body">

			<!-- display the actual poll post -->
	<div class="contentWrapper">
			<?php
				$priorVote = polls_check_for_previous_vote($vars['entity'], get_loggedin_userid());				
				//if user has voted, show the results
				if ($priorVote)	{
				
					echo "<p>";
					echo elgg_echo("polls:voted");
					echo "</p>";
					echo elgg_view('polls/results', array('entity' => $vars['entity']));
					
				} else {
					
					//else show the form
					echo elgg_view('polls/forms/vote', array('entity' => $vars['entity'],'full'=>$vars['full']));
					
				}
			?>
		</div>
		</div>
		<div class="clearfloat"></div>
			
		
	<?php 
			
		if (!$priorVote)
		{			
	?>
		<!-- show results -->
		<div class="contentWrapper">
		<p align="center"><a onclick="toggleResults();" style="cursor:hand;">Show Results</a></p>
		</div>
		<div id="resultsDiv" class="poll_post_body" style="display:none;">
			<?php echo elgg_view('polls/results',array('entity' => $vars['entity'])); ?>
	</div>
		
	<?php
		}
	?>
		
		<div class="clearfloat"></div>
						

	</div>

	<script type="text/javascript">
		function toggleResults()
		{
			var resultsDiv = document.getElementById('resultsDiv');
			
			if (resultsDiv.style.display == 'none')
			{
				resultsDiv.style.display = 'block';
			}
			else 
			{	
				resultsDiv.style.display = 'none';
			}
		}		
	</script>
	
<?php

			// If we've been asked to display the full view
			if (isset($vars['full']) && $vars['full'] == true) {
				echo elgg_view_comments($vars['entity']);
			}
				
		}

	}

?>