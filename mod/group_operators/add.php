<?php
// Get the specified group
                $group_guid = (int) get_input('group_guid');

        // If we can get out the group
                if ($group = get_entity($group_guid)) {

        // Set the page owner
                       set_page_owner($group_guid);
			$group_owner_guid = $group->getOwner();
			$group_owner = get_entity($group_owner_guid);
        // Display it
                        $area2 = ''; //elgg_view_entity($blogpost, 2);
			$members = $group->getMembers(999);
			$operators = elgg_get_entities_from_relationship(array('types'=>'user','limit'=>0,'relationship_guid'=>$group_guid, 'relationship'=>'operator', 'inverse_relationship'=>true));
			$area2 .= '<h2>'.elgg_echo('group_operators:members').'</h2>';
			$area2 .= '<p>' . elgg_echo('group_operators:members:instructions').'</p>';
			foreach ($members as $member) {
				if ($member->getGUID() == $group_owner_guid || in_array($member, $operators))
					continue;
				$area2 .= '<a title="'.$member->name.'" href="'.elgg_add_action_tokens_to_url($CONFIG->wwwroot.'action/group_operators/add?mygroup='.$group_guid.'&who='.$member->guid).'">';
				$area2 .= '<img src="';
				$area2 .= $member->getIcon('small');
				$area2 .= '" /></a> ';
			}
			$area2 .= '<h2>'.elgg_echo('group_operators:operators').'</h2>';
			$area2 .= '<p>' . elgg_echo('group_operators:operators:instructions') . '</p>';
			foreach ($operators as $operator) {
				$area2 .= '<a title="'.$operator->name.'" href="'.elgg_add_action_tokens_to_url($CONFIG->wwwroot.'action/group_operators/remove?mygroup='.$group_guid.'&who='.$operator->guid).'">';
				$area2 .= '<img src="';
				$area2 .= $operator->getIcon('small');
				$area2 .= '" /></a> ';

			}
			$area2 .= '<img src="';
			$area2 .= $group_owner->getIcon('small');
			$area2 .= '" /></a> ';

            $title = elgg_echo("group_operators:title").": ".$group->name;

        // Display through the correct canvas area
                $body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2);

        // If we're not allowed to see the group
                } else {

        // Display the 'post not found' page instead
                        $body = elgg_view("blog/notfound");
                        $title = elgg_echo("blog:notfound");

                }

        // Display page
                page_draw($title,$body);
?>
