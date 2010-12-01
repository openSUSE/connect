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

		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	//set poll title
		if($page_owner == $_SESSION['user']){
			$area2 = elgg_view_title(elgg_echo('polls:your'));
		}else{
			$area2 = elgg_view_title(sprintf(elgg_echo('polls:not_me'),$page_owner->name));
		}
		
	// TODO: fix this to properly paginate polls instead of using a fixed 50 for limit
		
	// Get poll posts
		$polls = $page_owner->getObjects('poll',50,0);
		
		foreach($polls as $poll)
		{
			$area2 .= elgg_view("polls/listing", array('entity' => $poll));
		}

		
	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area2);
		
	// Display page
		page_draw(sprintf(elgg_echo('polls:user'),$page_owner->name),$body);
		
?>