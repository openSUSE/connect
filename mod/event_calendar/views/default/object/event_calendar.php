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

 
$event = $vars['entity'];

//display follow up comments
//$count = $event->countAnnotations('arrival_comment');
//$arrival_print = $arrival_annotation[0][value];
//$item->value=elgg_view("input/longtext",array('internalname' => 'arrival_comment','value'=>$arrival_print));
//$topic = get_entity($item->value);
//$event_items[] = $item;
global $text_textarea;
global $submit_input;

$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));
$text_textarea = elgg_view('input/longtext', array('internalname' => 'arrival_comment', 'value' => $event->arrival));
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
	
	
	?>
	
<?php

		global $form_body;
		
		$form_body= <<<EOT 
		
		<form action="{$CONFIG->url}action/event_calendar/editfield" method="post">
		<div class='post_comments'>
		<p class='longtext_editarea'>
		$text_textarea
		</p>
			
		<p>
		$submit_input
					</p>
					</div>
					</form>
					
		EOT;					

?>		

<?php 
		
		global $sec_token; 
		$sec_token = elgg_view('input/securitytoken');
		  ?>
		


<?php 
		
	//	
	echo $body;
	echo $form_body;
	echo $sec_token;
	
	//echo $form_body;
	
	//$e = $event->getURL();
	//echo elgg_view('input/form', array('action' => "{$CONFIG->url}action/event_calendar/editfield", 'body' => $form_body, 'internalid' => 'editforumpostForm'));
	
	
	
	
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


