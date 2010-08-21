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
	 
	global $CONFIG;

	// Make sure we're logged in (send us to the front page if not)
	gatekeeper();

    // make sure action is secure
    action_gatekeeper();

	// Get input data
	$response = get_input('response');
	$pollpost = get_input('pollpost');
	
	//get the poll entity
	$poll = get_entity($pollpost);
	if ($poll->getSubtype() == "poll") {
			
		// Make sure the response isn't blank
		if (empty($response)) {
			if (get_input('callback')) {
				echo elgg_view('polls/poll_widget_content',array('entity'=>$poll,'msg'=>elgg_echo("polls:novote")));
				exit;
			} else {
				register_error(elgg_echo("polls:novote"));
				forward($poll->getUrl());
			}
				
		// Otherwise, save the poll post 
		} else {
				
			// Get owning user
			$owner = get_entity($poll->getOwner());
				
			//add vote as an annotation
			$poll->annotate('vote', $response, $poll->access_id);
				
			// Add to river
	        add_to_river('river/object/poll/vote','vote',get_loggedin_userid(),$poll->guid);
			
			//set session variable
			$_SESSION['hasVoted'] = $poll->guid;
			
			if (get_input('callback')) {
				echo elgg_view('polls/poll_widget_content',array('entity'=>$poll));
				exit;
			} else {
				// Success message
				system_message(elgg_echo("polls:responded"));	
				// Forward to the poll page
				forward($poll->getUrl());
			}
								
		}
			
	}
?>