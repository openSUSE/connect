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
						$vote_up[] = $ann->owner;
					} else
					if (substr($ann->value, 0, 3) == 'dn:') {
						$vote_down[] = $ann->owner;
					}
				}
				$vote_up = array_unique($vote_up);
				$vote_down = array_unique($vote_down);
			?>

			<?php if ($request->contributions == true): // check if there are any contributions ?>

        <div class="groups-contributions grid_5">
  			<?php
  				echo $request->contributions;
  			?>
  			</div>
        <div style="float: left;" class="grid_4">

  				<div><a href="<?php echo $thumburl . '&vote=up:noreason'; ?>"><img src="<?php echo $vars['url']; ?>mod/groups/graphics/thumb_up.png" alt="thumb up" /></a>
  			<?php
  				echo '<span style="font-size: xx-large; margin: 4px;">' . count($vote_up) . '</span>';
  				foreach ($vote_up as $voter) {
  					echo elgg_view("profile/icon", array('entity' => $voter, 'size' => 'small', 'override' => 'true' )) . ' ';
  				}
  			?>
  				</div>
  				<br/>
  				<div><a href="<?php echo $thumburl . '&vote=dn:noreason'; ?>"><img src="<?php echo $vars['url']; ?>mod/groups/graphics/thumb_down.png" alt="thumb down" /></a>
  			<?php
  				echo '<span style="font-size: xx-large; margin: 4px;">' . count($vote_down) . '</span>';
  				foreach ($vote_down as $voter) {
  					echo elgg_view("profile/icon", array('entity' => $voter, 'size' => 'small', 'override' => 'true' )) . ' ';
  				}
  			?>
  				</div>
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
