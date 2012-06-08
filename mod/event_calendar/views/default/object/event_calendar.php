<?php

/**
 * Elgg event_calendar object view
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

$event = $vars['entity'];

$link = $event->getURL();

echo ("<form action= ".$link." method="GET">
		<textarea class="input-textarea mceEditor" name="arrival" >Aj :21/06</textarea>
		<input type="submit" value="Add arrival comment!"/>
		
		</form>");


		

//echo"<a href='permalink.php?'>PermaLink</a>";
//echo"<input type='button' value='$link'>";

//<script type="text/javascript">
//	myMessage = "Hello! I'm a box!";
	

//<form name="testForm">

//<textarea name="textBox" rows="3"></textarea><br/>

//<input type="button" value="Press Me" onclick="document.testForm.textBox.value = myMessage;"/><input type="reset" value="Clear the Box"/>

//</form>
//</script>

//}
//</script>

//<!-- show the textarea -->
//<textarea class="input-textarea mceEditor" name="arrival" >Aj :21/06</textarea>
//<div class="toggle_editor_container"><a class="toggle_editor" href="javascript:toggleEditor('arrival');">Add/Remove editor</a></div>

//<script type="text/javascript">
//$(document).ready(function() {
	//$('textarea').parents('form').submit(function() {
	//	tinyMCE.triggerSave();
//	});
//});
//</script>
//<p class="odd"><b>Departure:</b> <p>Bla</p><p class="even"><b>Departure Comment:</b>
//<!-- show the textarea -->
//<textarea class="input-textarea mceEditor" name="departure" >Aj :26/06</textarea>
//<div class="toggle_editor_container"><a class="toggle_editor" href="javascript:toggleEditor('departure');">Add/Remove editor</a></div>

//<script type="text/javascript">
//$(document).ready(function() {
	//$('textarea').parents('form').submit(function() {
	//	tinyMCE.triggerSave();
//	});
//});
//</script> //

if ($vars['full']) {
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
	//$link = $event->getURL();
	//$url_body= '<a href="http://www.facebook.com/sharer.php?u="'.$link.'">Share me on Fb</a>';
	echo $body;
	//echo $url_body;
	
	
	
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



