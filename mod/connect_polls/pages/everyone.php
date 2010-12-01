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
		
		$offset = get_input('offset');
		
		if (empty($offset)) {
			$offset = 0;
		}
		
		$limit = 10;
			
		$area2 = elgg_view_title(elgg_echo('polls:everyone'));

		$polls = get_entities('object','poll',0,'time_created desc',$limit,$offset,false,0);
		
		$count = get_entities('object','poll',0,'time_created desc',999,0,true);
		
		
		set_context('search');
		
		$area2 .= elgg_view_entity_list($polls,$count,$offset,$limit,false,false,true);
		
		$body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2);
		
	// Display page
		page_draw(elgg_echo('polls:everyone'),$body);
		
?>