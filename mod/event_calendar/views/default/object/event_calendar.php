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
	
	
		$arrival_annotation = $event->getAnnotations('arrival_comment');
		$arrival_print = $arrival_annotation[0][value];
		$arrival_submit = elgg_view('input/submit', array('internalname' => 'arrival_submit', 'value' => elgg_echo('Add your Arrival here')));
		$arrival_textarea = elgg_view('input/longtext', array('internalname' => 'arrival_comment', 'value' => $arrival_print));
		$arrival_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		
		$arrival_body = <<<EOT
			<form action = "{$url}" method="post">
					<label><b>Arrival Comment:</b></label>
					<div class='arrival_comments'>
					<p class='longtext_editarea'>
						$arrival_textarea
					</p>
				<p>
						$arrival_submit
						$arrival_token
					</p>
		
					</div>
	</form>
		
EOT;
		
		$departure_annotation = $event->getAnnotations('departure_comment');
		$departure_print = $departure_annotation[0][value];
		$departure_submit = elgg_view('input/submit', array('internalname' => 'departure_submit', 'value' => elgg_echo('Add your Departure here')));
		$departure_textarea = elgg_view('input/longtext', array('internalname' => 'departure_comment', 'value' => $departure_print));
		$departure_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		
		$departure_body = <<<EOT
			<form action = "{$url}" method="post">
					<div class='departure_comments'>
					<label><b>Departure Comment:</b></label>
					<p class='longtext_editarea'>
						$departure_textarea
					</p>
				<p>
						$departure_submit
						$departure_token
					</p>
		
		 			</div>
	</form>
		
EOT;
		
		
		
		$material_annotation = $event->getAnnotations('material_comment');
		$material_print = $material_annotation[0][value];
		$material_submit = elgg_view('input/submit', array('internalname' => 'material_submit', 'value' => elgg_echo('Add your Material here')));
		$material_textarea = elgg_view('input/longtext', array('internalname' => 'material_comment', 'value' => $material_print));
		$material_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		
		$material_body = <<<EOT
			<form action = "{$url}" method="post">
					<div class='material_comments'>
					<label><b>Material Comment:</b></label>
					<p class='longtext_editarea'>
						$material_textarea
					</p>
				<p>
						$material_submit
						$material_token
					</p>
		
		 			</div>
	</form>
EOT;
	
		
		$booth_annotation = $event->getAnnotations('booth_comment');
		$booth_print = $booth_annotation[0][value];
		$booth_submit = elgg_view('input/submit', array('internalname' => 'booth_submit', 'value' => elgg_echo('Add your Booth here')));
		$booth_textarea = elgg_view('input/longtext', array('internalname' => 'booth_comment', 'value' => $booth_print));
		$booth_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		
		$booth_body = <<<EOT
			<form action = "{$url}" method="post">
					<div class='booth_comments'>
					<label><b>Booth Comment:</b></label>
					<p class='longtext_editarea'>
						$booth_textarea
					</p>
				<p>
						$booth_submit
						$booth_token
					</p>
		
		 			</div>
	</form>
EOT;
		
		$travel_annotation = $event->getAnnotations('travel_comment');
		$travel_print = $travel_annotation[0][value];
		$travel_submit = elgg_view('input/submit', array('internalname' => 'travel_submit', 'value' => elgg_echo('Add your Travel here')));
		$travel_textarea = elgg_view('input/longtext', array('internalname' => 'travel_comment', 'value' => $travel_print));
		$travel_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		
		$travel_body = <<<EOT
			<form action = "{$url}" method="post">
					<div class='travel_comments'>
					<label><b>Travel Comment:</b></label>
					<p class='longtext_editarea'>
						$travel_textarea
					</p>
				<p>
						$travel_submit
						$travel_token
					</p>
		
		 			</div>
	</form>
EOT;
		
		$talks_annotation = $event->getAnnotations('talks_comment');
		$talks_print = $talks_annotation[0][value];
		$talks_submit = elgg_view('input/submit', array('internalname' => 'takls_submit', 'value' => elgg_echo('Add your Talk here')));
		$talks_textarea = elgg_view('input/longtext', array('internalname' => 'talks_comment', 'value' => $talks_print));
		$talks_token = elgg_view('input/securitytoken');
		$url = $event->getURL();
		
		$talks_body = <<<EOT
			<form action = "{$url}" method="post">
					<div class='talks_comments'>
					<label><b>Talks Comment:</b></label>
					<p class='longtext_editarea'>
						$talks_textarea
					</p>
				<p>
						$talks_submit
						$talks_token
					</p>
		
		 			</div>
	</form>
EOT;
		
		echo $arrival_body;
		echo $departure_body;
		echo $material_body;
		echo $booth_body;
		echo $travel_body;
		echo $talks_body;
		
		if (isset($_POST['arrival_comment']))
				{
					
					$arr_comment = $_POST['arrival_comment'];
					$arr_line = "\n";
					$event->arrival = $event->arrival.$arr_line.$arr_comment;
					
				}
				
		if (isset($_POST['departure_comment']))
				{
						
					$dep_comment = $_POST['departure_comment'];
					$dep_line = "\n";
					$event->departure = $event->departure.$dep_line.$dep_comment;
						
				}
		if (isset($_POST['material_comment']))
				{
				
					$mat_comment = $_POST['material_comment'];
					$mat_line = "\n";
					$event->material = $event->material.$dep_line.$mat_comment;
				
				}
		if (isset($_POST['booth_comment']))
				{
				
					$bot_comment = $_POST['booth_comment'];
					$bot_line = "\n";
					$event->booth = $event->booth.$bot_line.$bot_comment;
				
				}
		
		if (isset($_POST['travel_comment']))
				{
				
					$tra_comment = $_POST['travel_comment'];
					$tra_line = "\n";
					$event->travel = $event->travel.$tra_line.$tra_comment;
				
				}
		if (isset($_POST['talks_comment']))
				{
				
					$tal_comment = $_POST['talks_comment'];
					$tal_line = "\n";
					$event->talks = $event->talks.$tal_line.$tal_comment;
				
				}		
				
				
		
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


