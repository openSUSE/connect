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
	 
		gatekeeper();
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		
	//set the title
		$area2 = elgg_view_title(elgg_echo('polls:addpost'));

	// Get the form
		$area2 .= elgg_view("polls/forms/edit");
		
	// Display page
		page_draw(elgg_echo('polls:addpost'),elgg_view_layout("two_column_left_sidebar", $area1, $area2));

		
?>