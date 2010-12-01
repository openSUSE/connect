<?php
	/**
	 * Elgg Poll post widget view
	 *  
	 * @package Elggpoll
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author John Mellberg
	 * @copyright John Mellberg 2009
	 * 
	 * @uses $vars['entity'] Optionally, the poll post to view
	 */
	
	//get the num of polls the user want to display
	$limit = $vars['entity']->limit;
		
	//if no number has been set, default to 5
	if(!$limit) $limit = 5;
	
	//the page owner
	$owner_guid = $vars['entity']->owner_guid;
	$owner = page_owner_entity();
	
	if($polls = get_entities('object','poll',0,'time_created desc',$limit,0,false,0)){
		$polls_ = array();		
		foreach($polls as $pollpost){
			if($pollpost->owner_guid != $owner_guid){
				echo elgg_view("polls/widget", array('entity' => $pollpost));
			}else{
				$polls_[] = $pollpost;
			}
		}	
	}
	
	if(count($polls_) >= count($polls))
	{
		echo "<div class=\"contentWrapper\">";
		echo "<p>" . elgg_echo("polls:widget:nonefound") . "</p>";	
		echo "</div>";
	}
		
?>