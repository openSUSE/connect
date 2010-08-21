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
		if (!($page_owner instanceof ElggEntity)) forward();

	//set the title
        if($page_owner == $_SESSION['user']){
			$area2 = elgg_view_title(elgg_echo('polls:yourfriends'));
		} else {
			$area2 = elgg_view_title(sprintf(elgg_echo('polls:not_me_friends'),$page_owner->name));
		}
		
	// Get a list of poll posts
		$offset = get_input('offset');
		
		if (empty($offset)) {
			$offset = 0;
		}
		
		$limit = 10;
		
		$polls = get_user_friends_objects($page_owner->getGUID(),'poll',$limit,$offset);
		
		$count = count_user_friends_objects($page_owner->getGUID(),'poll');
		
		set_context('search');
		
		$area2 .= elgg_view_entity_list($polls,$count,$offset,$limit,false,false,true);

	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2);
		
	// Display page
		page_draw(elgg_echo('polls:friends'),$body);
		
?>