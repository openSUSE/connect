<?php

	/**
	 * Elgg custom index
	 * 
	 * @package ElggCustomIndex
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	// Get the Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
    //get required data		
	set_context('search');//display results in search mode, which is list view
	//grab the login form
	$area1 = elgg_view("account/forms/login");
	//get the newest members who have an avatar
	$area2 = elgg_get_entities(array('type' => 'user', 'limit' => 25));
	//grab the latest 4 blog posts. to display more, change 4 to something else
	$area3 = elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'limit' => 2, 'full_view' => FALSE, 'pagination' => FALSE));
	//grab the latest bookmarks
	$area4 = elgg_list_entities(array('type' => 'object', 'subtype' => 'bookmarks', 'limit' => 4, 'full_view' => FALSE, 'pagination' => FALSE));
	//grab the latest files
	$area5 = elgg_list_entities(array('type' => 'object', 'subtype' => 'file', 'limit' => 4, 'full_view' => FALSE, 'pagination' => FALSE));
	//newest groups
	$area6 = elgg_list_entities(array('type' => 'group', 'limit' => 4, 'full_view' => FALSE, 'pagination' => FALSE));
	//newest polls
	$area7 = elgg_list_entities(array('type' => 'object', 'subtype' => 'poll', 'limit' => 1, 'full_view' => FALSE, 'pagination' => FALSE));
	//newest events 
	$area8 = elgg_list_entities(array('type' => 'object', 'subtype' => 'event_calendar', 'limit' => 3, 'full_view' => FALSE, 'pagination' => FALSE));
				 
    //display the contents in our new canvas layout
	$body = elgg_view_layout('new_index',$area1, $area2, $area3, $area4, $area5, $area6, $area7, $area8);
   
    page_draw($title, $body);
		
?>
