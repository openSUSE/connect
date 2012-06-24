<?php

/**
 * Elgg event_calendar object view
 * 
 * @package event_calendar
 * @package ElggGroups
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

gatekeeper(); // Access to the event only for logged in users.

$event = $vars['entity'];

//display follow up comments
//$count = $event->countAnnotations('arrival_comment');
//$arrival_print = $arrival_annotation[0][value];
//$item->value=elgg_view("input/longtext",array('internalname' => 'arrival_comment','value'=>$arrival_print));
//$topic = get_entity($item->value);
//$event_items[] = $item;
//global $text_textarea;
//global $submit_input;

//$post = elgg_view('input/hidden', array('internalname' => 'post', 'value' => $vars['entity']->id));
//$field = elgg_view('input/hidden', array('internalname' => 'field_num', 'value' => $vars['entity']->id));
//$topic = elgg_view('input/hidden', array('internalname' => 'topic', 'value' => get_input('topic')));
//$group = elgg_view('input/hidden', array('internalname' => 'group', 'value' => get_input('group_guid')));





if ($vars['full']) {
	
	global $body;
	$body = elgg_view('event_calendar/strapline',$vars);
	$event_items = event_calendar_get_formatted_full_items($event);
	
	$body .= '<div class="contentWrapper" >';
	
	foreach($event_items as $item) {
		
		$value = $item->value;
		if (!empty($value)) {
			if ($vars['full']) {
				$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
				$body .= "<p class=\"{$even_odd}\"><b>";
				$body .= $item->title.':</b> ';
				$body .= $item->value;
			}		
		}
	}
	
	echo $body;
	
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));
		$text_textarea = elgg_view('input/longtext', array('internalname' => 'arrival_comment', 'value' => $arrival_print));
		$sec_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		//$text_textarea
		$form_body = <<<EOT
			<form action = "{$url}" method="post">
					<div class='post_comments'>
					<p class='longtext_editarea'>
						
					</p>
				<p>
						$submit_input
						$sec_token
					</p>
		
					</div>
	</form>
		
EOT;
		//$post = get_input("arrival_comment");

		//echo $post;
		
		echo $form_body;
		//$comment = $_POST['arrival_comment'];
		//if (isset($_POST['arrival_comment'])
			//	{
					
			//		$comment = $_POST['arrival_comment'];
				//	$event->arrival = $event->arrival.
					
				//}
		$a = $event->arrival;
		
		
		
		//$b = $a.$comment;
		
		echo elgg_view("input/longtext",array('internalname' => 'arrival_comment','value'=>$a));
		
		  
		
		//echo elgg_view("output/longtext",array("value" => $comment));
		// Thelw na typwnw syndasmena dyo stoixeia apo array
		//echo $submit_input;
		//echo $text_textarea;
		
		//echo elgg_view("input/longtext",array('internalname' => 'arrival_comment','value'=>$comment));
		//echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$url}"));
		
	if ($event->long_description) {
		echo '<p>'.$event->long_description.'</p>';
	} else {
		echo '<p>'.$event->description.'</p>';
	}
	echo '</div>';
	if (get_plugin_setting('add_to_group_calendar', 'event_calendar') == 'yes') {
		echo elgg_view('event_calendar/forms/add_to_group',array('event' => $event));
	}
} else {
	$time_bit = event_calendar_get_formatted_time($event);
	$icon = elgg_view(
			"graphics/icon", array(
			'entity' => $vars['entity'],
			'size' => 'small',
		  )
		);
	$info .= '<p><b><a href="'.$event->getUrl().'">'.$event->title.'</a></b>';
	$info .= '<br />'.$time_bit;
	if ($event->description) {
		$info .= '<br /><br />'.$event->description;
	}
	
	if ($event_calendar_venue_view = get_plugin_setting('venue_view', 'event_calendar') == 'yes') {
		$info .= '<br />'.$event->venue;
	}
	$info .=  '</p>';
	
	echo elgg_view_listing($icon, $info);
}


?>


