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


include "db_class.php";

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
	
		$newline = '<br>';
	
		/* Participants Comment field */
	
		$event->annotate('participant_comment', "");
		$participant_annotation = $event->getAnnotations('participant_comment');
		$participant_print = $participant_annotation[0][value];
		$participant_body = '<label><b>&nbsp;&nbsp;Participants:</b></label>';
		$participant_body .= $newline;
		$participant_body .= $newline;
		$participant_body .= elgg_view('input/longtext', array('internalname' => 'participant_comment', 'value' => $participant_print));
		$participant_body .= $newline;
		$participant_body .= elgg_view('input/submit', array('internalname' => 'participant_submit', 'value' => elgg_echo('Participate')));
		$participant_body .= elgg_view('input/securitytoken');
		$url = $event->getURL();
		$participant_form_body = elgg_view('input/form', array('body' => $participant_body, 'action' => $url));
		
			
		/* Material Comment field */
		
		$event->annotate('material_comment', "");
		$material_annotation = $event->getAnnotations('material_comment');
		$material_print = $material_annotation[0][value];
		$material_body  = '<label><b>&nbsp;&nbsp;Material Comment:</b></label>';
		$material_body .= $newline;
		$material_body .= $newline;
		$material_body .= elgg_view('input/longtext', array('internalname' => 'material_comment', 'value' => $material_print));
		$material_body .= $newline;
		$material_body .= elgg_view('input/submit', array('internalname' => 'material_submit', 'value' => elgg_echo('Bring your Material')));
		$material_body .= elgg_view('input/securitytoken');
		$url = $event->getURL();
		$material_form_body = elgg_view('input/form', array('body' => $material_body, 'action' => $url));
		
		/* Booth Comment field */
		
		$event->annotate('booth_comment', "");
		$booth_annotation = $event->getAnnotations('booth_comment');
		$booth_print = $booth_annotation[0][value];	
		$booth_body  = '<label><b>&nbsp;&nbsp;Booth Comment:</b></label>';
		$booth_body .= $newline;
		$booth_body .= $newline;
		$booth_body .= elgg_view('input/longtext', array('internalname' => 'booth_comment', 'value' => $booth_print));
		$booth_body .= $newline;
		$booth_body .= elgg_view('input/submit', array('internalname' => 'booth_submit', 'value' => elgg_echo('Add your Booth here')));		
		$booth_body .= elgg_view('input/securitytoken');
		$url = $event->getURL();
		$booth_form_body = elgg_view('input/form', array('body' => $booth_body, 'action' => $url));
				
		/*Talks comment field*/
		
		$event->annotate('talks_comment', "");
		$talks_annotation = $event->getAnnotations('talks_comment');
		$talks_print = $talks_annotation[0][value];	
		$talks_body  = '<label><b>&nbsp;&nbsp;Talks Comment:</b></label>';
		$talks_body .= $newline;
		$talks_body .= $newline;
		$talks_body .= elgg_view('input/longtext', array('internalname' => 'talks_comment', 'value' => $talks_print));
		$talks_body .= $newline;
		$talks_body .= elgg_view('input/submit', array('internalname' => 'takls_submit', 'value' => elgg_echo('Add your Talk here')));	
		$talks_body .= elgg_view('input/securitytoken');
		$url = $event->getURL();		
		$talks_form_body = elgg_view('input/form', array('body' => $talks_body, 'action' => $url));
						
		if (isset($_POST['participant_comment']))
				{
					$base = new database();
					$base->connect_db();
					$base->create_db();
					$base->select_db();
					$base->query_db("CREATE TABLE IF NOT EXISTS `participants` (`$name` VARCHAR(30) primary key, `arrival` VARCHAR(15), `departure` VARCHAR(15), `location` VARCHAR(20));");
					
					$par_comment = $_POST['participant_comment'];
					$data_par = explode(" ", $par_comment);
					
					$d1_par = strip_tags($data_par[0]);
					
					$d2_par = strip_tags($data_par[1]);
					
					$d3_par = strip_tags($data_par[2]);
					
					$base->query_db("INSERT IGNORE INTO `participants` (`$name`,`arrival`,`departure`,`location`) VALUE ('$name','$d1_par','$d2_par','$d3_par');");
					
				
					$row_query = mysql_query("SELECT * FROM `participants`;");
									
					while ($row=mysql_fetch_array($row_query)){
						
						$name_row_par = $row[$name];
						$arr_row = $row['arrival'];
						$dep_row = $row['departure'];
						$loc_row = $row['location'];
					 
					}
					
					$print_part_rows = $name_row_par." ".$arr_row." ".$dep_row." ".$loc_row;
					
					$event->annotate('participant_comment', "");
					$participant_annotation = $event->getAnnotations('participant_comment');
					$participant_print = $participant_annotation[0][value];
					$participant_body = '<label><b>&nbsp;&nbsp;Participants:</b></label>';
					$participant_body .= $newline;
					$participant_body .= $newline;
					$participant_body .= elgg_view('input/longtext', array('internalname' => 'participant_comment', 'value' => $print_part_rows));
					$participant_body .= $newline;
					$participant_body .= elgg_view('input/submit', array('internalname' => 'participant_submit', 'value' => elgg_echo('Participate')));
					$participant_body .= elgg_view('input/securitytoken');
					$url = $event->getURL();
					$participant_form_body = elgg_view('input/form', array('body' => $participant_body, 'action' => $url));
					
						
					$base->close_connection();
					
						
				}
				
		
		if (isset($_POST['material_comment']))
				{
					$base = new database();
					$base->connect_db();
					$base->create_db();
					$base->select_db();
					$base->query_db("CREATE TABLE IF NOT EXISTS `materials` (`$name` VARCHAR(30) primary key, `stuff_1` VARCHAR(10), `stuff_2` VARCHAR(10), `stuff_3` VARCHAR(30));");
						
					$mat_comment = $_POST['material_comment'];
					$data_mat = explode(" ", $mat_comment);
						
					$d1_mat = strip_tags($data_mat[0]);
						
					$d2_mat = strip_tags($data_mat[1]);
						
					$d3_mat = strip_tags($data_mat[2]);
						
					$base->query_db("INSERT IGNORE INTO `materials` (`$name`,`stuff_1`,`stuff_2`,`stuff_3`) VALUE ('$name','$d1_mat','$d2_mat','$d3_mat');");
						
					
					$row_query = mysql_query("SELECT * FROM `materials`;");
						
					while ($row=mysql_fetch_array($row_query)){
					
						$name_row_mat = $row[$name];
						$stuff_1_row = $row['stuff_1'];
						$stuff_2_row = $row['stuff_2'];
						$stuff_3_row = $row['stuff_3'];
					
					}
						
					$print_mat_rows = $name_row_mat." ".$stuff_1_row." ".$stuff_2_row." ".$stuff_3_row;
					
					$event->annotate('material_comment', "");
					$material_annotation = $event->getAnnotations('material_comment');
					$material_print = $participant_annotation[0][value];
					$material_body = '<label><b>&nbsp;&nbsp;Materials:</b></label>';
					$material_body .= $newline;
					$material_body .= $newline;
					$material_body .= elgg_view('input/longtext', array('internalname' => 'material_comment', 'value' => $print_mat_rows));
					$material_body .= $newline;
					$material_body .= elgg_view('input/submit', array('internalname' => 'material_submit', 'value' => elgg_echo('Materials')));
					$material_body .= elgg_view('input/securitytoken');
					$url = $event->getURL();
					$material_form_body = elgg_view('input/form', array('body' => $material_body, 'action' => $url));
					
					
					$base->close_connection();
					
				}

				if (isset($_POST['talks_comment']))
				{
				
					$base = new database();
					$base->connect_db();
					$base->create_db();
					$base->select_db();
					$base->query_db("CREATE TABLE IF NOT EXISTS `talks` (`$name` VARCHAR(30) primary key, `title` VARCHAR(30), `date` VARCHAR(15), `place` VARCHAR(30));");
						
					$tal_comment = $_POST['talks_comment'];
					
					$data_tal = explode(",", $tal_comment);
					
					$d1_tal = strip_tags($data_tal[0]);
					
					$d2_tal = strip_tags($data_tal[1]);
					
					$d3_tal = strip_tags($data_tal[2]);
						
					
					$base->query_db("INSERT IGNORE INTO `talks` (`$name`,`title`,`date`,`place`) VALUE ('$name','$d1_tal','$d2_tal','$d3_tal');");
					
						
					$row_query = mysql_query("SELECT * FROM `talks`;");
						
					while ($row=mysql_fetch_array($row_query)){
							
						$name_row_tal = $row[$name];
						$title_row = $row['title'];
						$date_row = $row['date'];
						$place_row = $row['place'];
							
					}
					
					$print_tal_rows = $name_row_tal." ".$title_row." ".$date_row." ".$place_row;
					
					$event->annotate('talks_comment', "");
					$talks_annotation = $event->getAnnotations('talks_comment');
					$talks_print = $talks_annotation[0][value];
					$talks_body = '<label><b>&nbsp;&nbsp;Materials:</b></label>';
					$talks_body .= $newline;
					$talks_body .= $newline;
					$talks_body .= elgg_view('input/longtext', array('internalname' => 'talks_comment', 'value' => $print_tal_rows));
					$talks_body .= $newline;
					$talks_body .= elgg_view('input/submit', array('internalname' => 'talks_submit', 'value' => elgg_echo('Talks')));
					$talks_body .= elgg_view('input/securitytoken');
					$url = $event->getURL();
					$talks_form_body = elgg_view('input/form', array('body' => $talks_body, 'action' => $url));
						

					$base->close_connection();
				}		
				
	
				echo $participant_form_body.$newline;
				echo $material_form_body.$newline;
				echo $talks_form_body.$newline;
				//echo $lati_body;
				//echo $long_body;
				//echo $map_body;
				
		
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


