<?php
/*
*
* Elgg poll_extended: Edit post action
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

    // make sure action is secure
    action_gatekeeper();

	// Get input data
	$question = get_input('question');
	$number_of_choices = (int) get_input('number_of_choices',0);
	$tags = get_input('polltags');
	$access = get_input('access_id');
	$pollpost = get_input('pollpost');
		
	// Make sure we actually have permission to edit
	$poll = get_entity($pollpost);
	$container_guid = $poll->container_guid;
	
	if ($poll->getSubtype() == "poll" && $poll->canEdit()) {
	
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
		
		// Validate the input
		if (empty($question) || ($count == 0)) {
			register_error(elgg_echo("polls:blank"));
			forward($CONFIG->url."pg/polls/edit/".$pollpost);
				
		// Otherwise, save the poll post 
		} else {
			
			// clear the previous choices
			polls_replace_choices($poll,$new_choices);
				
			// Get owning user
			$owner = get_entity($poll->getOwner());
		
			$poll->access_id = $access;
		
			// Set its question appropriately
			$poll->question = $question;
			$poll->title = $question;

			if (!$poll->save()) {
				register_error(elgg_echo("polls:error"));
				forward($CONFIG->url."pg/polls/edit/". $pollpost);
			}
			
			if (is_array($tagarray)) {
				$poll->tags = $tagarray;
			}
		
			// Success message
			system_message(elgg_echo("polls:posted"));
			
			// Remove the poll post cache
			unset($_SESSION['question']); 
			unset($_SESSION['responses']); 
			unset($_SESSION['polltags']);
		
			// Forward to the main poll page
			forward($CONFIG->wwwroot."pg/polls/list/" . get_entity($container_guid)->username);
			//forward($_SERVER['HTTP_REFERER']);

								
		}
		
	}

?>
