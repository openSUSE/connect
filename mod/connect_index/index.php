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
	//
  	$area1 = '';
	// $area1 = elgg_view("account/forms/login");
	//newest actions in the river
	$area2 = elgg_view_river_items(0, 0, '', '', '', '', 8, 0, 0, false);
	//get the newest members who have an avatar
	$area3 = elgg_get_entities(array('type' => 'user', 'limit' => 25));
	//newest groups
	$area4 = elgg_list_entities(array('type' => 'group', 'limit' => 4, 'full_view' => FALSE, 'pagination' => FALSE));
	//display the contents in our new canvas layout
	$body = elgg_view_layout('new_index',$area1, $area2, $area3, $area4);
	page_draw($title, $body);
?>
