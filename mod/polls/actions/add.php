<?php
/*
*
* Elgg poll_extended: add post action
* 
* @package Elgg poll_extended
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author John Mellberg
* @copyright John Mellberg 2009
*
*/

	global $CONFIG;

// Make sure we're logged in (send us to the front page if not)
	gatekeeper();

	// Make sure action is secure
	action_gatekeeper();

	// Get input data
	$question = get_input('question');
	$number_of_choices = (int) get_input('number_of_choices',0);
	$tags = get_input('polltags');
	$access = get_input('access_id');
	$container_guid = get_input('container_guid');
	
	// Cache to the session
	$_SESSION['question'] = $question;
	$_SESSION['polltags'] = $tags;

	// Convert string of tags into a preformatted array
	$tagarray = string_to_tag_array($tags);
	
	//get response choices
	$count = 0;
	$new_choices = array();
	if ($number_of_choices) {
		for($i=0;$i<$number_of_choices;$i++) {
			$text = get_input('choice_text_'.$i,'');
			if ($text) {
				$new_choices[] = $text;
				$count ++;
			}
		}
	}
		
	// Make sure the question / responses aren't blank
	if (empty($question) || ($count == 0)) {
		register_error(elgg_echo("polls:blank"));
		forward($CONFIG->url."pg/polls/add");
			
	// Otherwise, save the poll post 
	} else {
			
		// Initialise a new ElggObject
		$poll = new ElggObject();
	
		// Tell the system it's a poll post
		$poll->subtype = "poll";
	
		// Set its owner to the current user
		$poll->owner_guid = $_SESSION['user']->getGUID();
		$poll->container_guid = $container_guid;
		
		$poll->access_id = $access;
	
		// Set its title and description appropriately
		$poll->question = $question;
		$poll->title = $question;
			
		// Before we can set metadata, we need to save the poll post
		if (!$poll->save()) {
			register_error(elgg_echo("polls:error"));
			forward($CONFIG->url."pg/polls/add");
			exit;
		}
	
		polls_add_choices($poll,$new_choices);
	
		// Now let's add tags. We can pass an array directly to the object property! Easy.
		if (is_array($tagarray)) {
			$poll->tags = $tagarray;
		}
		
		add_to_river('river/object/poll/publish','create',get_loggedin_userid(),$poll->guid);
	
		// Success message
		system_message(elgg_echo("polls:posted"));
		
		// Remove the poll post cache
		unset($_SESSION['question']); 
		unset($_SESSION['polltags']);
	
		// Forward to the main poll page
		forward($CONFIG->url."pg/polls/list/" . get_entity($container_guid)->username);			
	}
		
	// function for turning comma delimited strings 
	// into an array for storage as metadata 
	function string_to_response_array($string) {
		
		if (is_string($string)) {
			$ar = explode(",",$string);
			$ar = array_map('trim', $ar);
	
			return $ar;
		}
		
		return false;
	}


?>