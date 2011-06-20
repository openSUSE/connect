<div class="contentWrapper">

<?php
	if (!empty($vars['requests']) && is_array($vars['requests'])) {

		foreach($vars['requests'] as $request)
			if ($request instanceof ElggUser) {

?>
	<div class="reportedcontent_content active_report">
		<div class="groups_membershiprequest_buttons">
			<div class="group-user grid_3" id="vote_<?php echo $request->guid; ?>">
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
			<br/><br/>
			<a href="#" id="vallinks_<?php echo $request->guid; ?>">validation links</a>
			<script>
			<?php
				echo "$('#vallinks_{$request->guid}').click(function(){ $('#vallinks_div_{$request->guid}').toggle(); return false; });";
			?>
			</script>
			<div class="voter-container" id="vallinks_div_<?php echo $request->guid; ?>">
			<ul>
			<?php
			  $val_username = urlencode($request->username);
			  $val_email = urlencode($request->email);
			  $val_name = urlencode($request->name);
			?>
				<li><a href="https://bugzilla.novell.com/buglist.cgi?query_format=advanced&classification=openSUSE&bug_status=UNCONFIRMED&bug_status=NEW&bug_status=ASSIGNED&bug_status=NEEDINFO&bug_status=REOPENED&bug_status=RESOLVED&bug_status=VERIFIED&bug_status=CLOSED&emailassigned_to1=1&emailreporter1=1&emailinfoprovider1=1&emailqa_contact1=1&emailcc1=1&emaillongdesc1=1&emailtype1=exact&email1=<?php echo $val_email;  ?>&bugidtype=include&cmdtype=doit&order=Reuse+same+sort+as+last+time" target="_blank">Bugzilla by Email</a></li>
				<li><a href="https://bugzilla.novell.com/userlookup.cgi?matchstr=<?php echo $val_name;  ?>&matchtype=substr" target="_blank">Search Bugzilla User</a></li>
				<li><a href="http://en.opensuse.org/User:<?php echo $val_username;  ?>" target="_blank">Wiki User Page</a></li>
				<li><a href="http://en.opensuse.org/Special:Contributions/<?php echo $val_username;  ?>" target="_blank">Wiki Contributions</a></li>
				<li><a href="http://lists.opensuse.org/cgi-bin/search.cgi?query=%22<?php echo $val_name;  ?>%22&list=all" target="_blank">Mailinglist Archive by Fullname</a></li>
				<li><a href="http://lists.opensuse.org/cgi-bin/search.cgi?query=<?php echo $val_email;  ?>&list=all" target="_blank">Mailinglist Archive by Email</a></li>
				<li><a href="http://www.google.com/search?q=opensuse+%22<?php echo $val_name;  ?>%22" target="_blank">Google the Fullname</a></li>
				<li><a href="https://build.opensuse.org/home/list_my?user=<?php echo $val_username;  ?>" target="_blank">Build Service</a></li>
				<li><a href="http://forums.opensuse.org/members/<?php echo $val_username;  ?>.html" target="_blank">Forums</a></li>
			</ul>
			</div>
			</div>
			<?php if ($vars['extended']) {
				$thumburl = elgg_add_action_tokens_to_url("{$vars['url']}action/groups/thumbvote?mode=add&user_guid={$request->guid}&group_guid={$vars['entity']->guid}");
				$annotations = $request->getAnnotations('join_vote_' . ($vars['entity']->guid));
				$vote_up = array();
				$vote_down = array();
				$already_voted = false;
				foreach ($annotations as $ann) {
					if ($ann->owner_guid == get_loggedin_userid()) {
						$already_voted = true;
					}
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
          <?php if (!$already_voted) { ?>
  			  <a class="voting vote-up" href="<?php echo $thumburl . '&vote=up:reason'; ?>" id="#voteup_<?php echo $request->guid; ?>">
            <img src="<?php echo $vars['url']; ?>mod/groups/graphics/thumb_up.png" alt="thumb up" /></a>
  			  <?php
                }
    				echo '<span style="font-size: xx-large; margin: 4px;"><a href="#" id="votesup_' . $request->guid . '">+' . count($vote_up) . '</a> / <a href="#" id="votesdn_' . $request->guid . '">-' . count($vote_down) . '</a></span>';
  			  ?>
  					<script>
  					<?php
  						echo "$('#votesup_{$request->guid}').click(function(){ $('#voter-up_{$request->guid}').toggle(); $('#voter-dn_{$request->guid}').hide(); return false; });";
  						echo "$('#votesdn_{$request->guid}').click(function(){ $('#voter-dn_{$request->guid}').toggle(); $('#voter-up_{$request->guid}').hide(); return false; });";
  					?>
  					</script>
  					<?php if (!$already_voted) { ?>
    				  <a class="voting vote-dn" href="<?php echo $thumburl . '&vote=dn:reason'; ?>" id="#votedn_<?php echo $request->guid; ?>">
                        <img src="<?php echo $vars['url']; ?>mod/groups/graphics/thumb_down.png" alt="thumb down" /></a>
                    <?php } ?>
			  
    			  <div id="voter-up_<?php echo $request->guid; ?>" class="voter-container">
      			<?php // show voters-avatars (pro vote)
      				foreach ($vote_up as $ann) {
      				$delurl = elgg_add_action_tokens_to_url("{$vars['url']}action/groups/thumbvote?mode=del&user_guid={$request->guid}&group_guid={$vars['entity']->guid}&ann_id={$ann->id}");
    				echo elgg_view("profile/icon", array('entity' => get_entity($ann->owner_guid), 'size' => 'small', 'override' => 'true' )) . ' ';
    				echo ' ' . substr($ann->value, 3);
    				if ($ann->owner_guid == get_loggedin_userid()) {
  						echo ' <a href="' . $delurl . '">[x]</a>';
  					}
  					echo '<br/>';
      				}
      			?>
   				  </div>
    			<div id="voter-dn_<?php echo $request->guid; ?>" class="voter-container">
      		<?php // show voters-avatars (contra vote)
    			foreach ($vote_down as $ann) {
    				$delurl = elgg_add_action_tokens_to_url("{$vars['url']}action/groups/thumbvote?mode=del&user_guid={$request->guid}&group_guid={$vars['entity']->guid}&ann_id={$ann->id}");
    				echo elgg_view("profile/icon", array('entity' => get_entity($ann->owner_guid), 'size' => 'small', 'override' => 'true' )) . ' ';
    				echo ' ' . substr($ann->value, 3);
    				if ($ann->owner_guid == get_loggedin_userid()) {
  						echo ' <a href="' . $delurl . '">[x]</a>';
  					}
  					echo '<br/>';
    			}
    			?>
          </div>
          <?php if (!$already_voted) { ?>
          <input type="text" name="comment" value="reason" id="vote-comment_<?php echo $request->guid; ?>" class="grid_4">
          <?php } ?>
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
<div style="height: 200px;"></div>
</div>
