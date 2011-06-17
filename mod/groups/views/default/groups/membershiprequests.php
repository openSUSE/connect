<div class="contentWrapper">

<?php
	if (!empty($vars['requests']) && is_array($vars['requests'])) {

		foreach($vars['requests'] as $request)
			if ($request instanceof ElggUser) {

?>
	<div class="reportedcontent_content active_report">
		<div class="groups_membershiprequest_buttons">
			<div class="group-user grid_3">
			<?php
			  // Add User Icon
				echo "<div class=\"member_icon\"><a href=\"" . $request->getURL() . "\">";
				echo elgg_view("profile/icon", array(
					'entity' => $request,
					'size' => 'small',
					'override' => 'true'
				));
				echo "</a></div>{$request->name}<br />"; // Add User Name

				echo str_replace('<a', '<a class="delete_report_button red" ', elgg_view('output/confirmlink',array(
					'href' => $vars['url'] . 'action/groups/killrequest?user_guid='.$request->guid.'&group_guid=' . $vars['entity']->guid,
					'confirm' => elgg_echo('groups:joinrequest:remove:check'),
					'text' => elgg_echo('groups:joinrequestdecline'),
				)));
			$url = elgg_add_action_tokens_to_url("{$vars['url']}action/groups/addtogroup?user_guid={$request->guid}&group_guid={$vars['entity']->guid}");
			?>
			<strong><a href="<?php echo $url; ?>" class="archive_report_button green"><?php echo elgg_echo('groups:joinrequestaccept'); ?></a></strong>
			</div>
			<?php if ($vars['extended']) {
				$thumburl = elgg_add_action_tokens_to_url("{$vars['url']}action/groups/thumbvote?user_guid={$request->guid}&group_guid={$vars['entity']->guid}");
				$annotations = $request->getAnnotations('join_vote_' . ($vars['entity']->guid));
				$vote_up = array();
				$vote_down = array();
				foreach ($annotations as $ann) {
					if (substr($ann->value, 0, 3) == 'up:') {
						$vote_up[] = $ann;
					} else
					if (substr($ann->value, 0, 3) == 'dn:') {
						$vote_down[] = $ann;
					}
				}
			?>

			<?php if ($request->contributions == true): // check if there are any contributions ?>

        <div class="groups-contributions grid_5">
  			<?php
  				echo $request->contributions;
  			?>
  			</div>
  			
        <div class="grid_4">
          <!-- <div> -->

        <form action="membershiprequests_submit" method="get" accept-charset="utf-8">
          
  			  <a class="voting vote-up" href="<?php echo $thumburl . '&vote=up:reason'; ?>">
            <img src="<?php echo $vars['url']; ?>mod/groups/graphics/thumb_up.png" alt="thumb up" /></a>
  			  <?php
    				echo '<span style="font-size: xx-large; margin: 4px;"><a href="#" id="votesup_{$request->guid}">+' . count($vote_up) . '</a> / <a href="#" id="votesdn_{$request->guid}">-' . count($vote_down) . '</a></span>';
  			  ?>
  					<script>
  					$('#votesup_<?php echo $request->guid; ?>').click(function(){ $('#voter-up_<?php echo $request->guid; ?>').toggle(); });
  					$('#votesdn_<?php echo $request->guid; ?>').click(function(){ $('#voter-dn_<?php echo $request->guid; ?>').toggle(); });
  					</script>
    				  <a class="voting vote-dn" href="<?php echo $thumburl . '&vote=dn:reason'; ?>">
                        <img src="<?php echo $vars['url']; ?>mod/groups/graphics/thumb_down.png" alt="thumb down" /></a>
			  
    			  <div id="voter-up_<?php echo $request->guid; ?>" class="voter-container">
      			<?php // show voters-avatars (pro vote)
      				foreach ($vote_up as $ann) {
      					echo elgg_view("profile/icon", array('entity' => $ann->owner, 'size' => 'small', 'override' => 'true' )) . ' ';
    					echo ' ' . substr($ann->value, 3) . ' <br/>';
      				}
      			?>
   				  </div>
    			<div id="voter-dn_<?php echo $request->guid; ?>" class="voter-container">
      		<?php // show voters-avatars (contra vote)
    			foreach ($vote_down as $ann) {
    				echo elgg_view("profile/icon", array('entity' => $ann->owner, 'size' => 'small', 'override' => 'true' )) . ' ';
  					echo ' ' . substr($ann->value, 3) . ' <br/>';
    			}
    			?>
          </div>
          
          <!-- <label for="comment">Comment</label> -->
          <input type="text" name="comment" value="reason" id="vote-comment" class="grid_4">

          <!-- <p><input type="submit" value="Continue &rarr;"></p> -->
        </form>
          
          
		    </div>
  			
			<?php else : ?>
  			<div class="groups-contributions grid_5">
          <strong>No given contributions.</strong>
  			</div>
			<?php endif ?>
	

			<?php } ?>
			<hr style="clear: both;" />
		</div>
	</div>
<?php

			}

	} else {

		echo "<p>" . elgg_echo('groups:requests:none') . "</p>";

	}

?>
</div>
