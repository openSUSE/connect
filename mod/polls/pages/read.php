<?php

	/**
	 * Elgg Poll plugin
	 * @package Elggpoll
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @Original author John Mellberg
	 * website http://www.syslogicinc.com
	 * @Modified By Team Webgalli to work with ElggV1.5
	 * www.webgalli.com or www.m4medicine.com
	 */


	// Get the specified poll post
		$post = (int) get_input('pollpost');
		
		//$area1 = $post;
		//$area1 = $_SESSION['user']->username; 

	// If we can get out the poll post ...
		if ($pollpost = get_entity($post)) {
			
	// Get any comments
			$comments = $pollpost->getAnnotations('comments');
		
	// Set the page owner
			set_page_owner($pollpost->getContainer());
			$page_owner = page_owner_entity();
			
	// Display it
			$area2 .= elgg_view("object/poll",array(
											'entity' => $pollpost,
											'entity_owner' => $page_owner,
											'comments' => $comments,
											'full' => true
											));
	

	// Display through the correct canvas area
		$body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2);
			
	// If we're not allowed to see the poll post
		} else {
			
	// Display the 'post not found' page instead
			$body = elgg_view("polls/notfound");
			$title = elgg_echo("polls:notfound");
			
		}
		
	// Display page
		page_draw($title,$body);
		
?>