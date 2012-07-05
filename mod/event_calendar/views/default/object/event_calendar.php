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
		
		/* Departure Comment field */
		
	//	$event->annotate('departure_comment', "");
	//	$departure_annotation = $event->getAnnotations('departure_comment');
	//	$departure_print = $departure_annotation[0][value];
	//	$departure_body  = '<label><b>&nbsp;&nbsp;Departure Comment:</b></label>';
	//	$departure_body  .= $newline;
	//	$departure_body  .= $newline;
	//	$departure_body .= elgg_view('input/longtext', array('internalname' => 'departure_comment', 'value' => $departure_print));
	//	$departure_body  .= $newline;
	//	$departure_body .= elgg_view('input/submit', array('internalname' => 'departure_submit', 'value' => elgg_echo('Add your Departure here')));
	//	$departure_body .= elgg_view('input/securitytoken');
	//	$url = $event->getURL();
	//	$departure_form_body = elgg_view('input/form', array('body' => $departure_body, 'action' => $url));
			
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
		
		/* Travel Comment field */
		
	//	$event->annotate('travel_comment', "");
	//	$travel_annotation = $event->getAnnotations('travel_comment');
	//	$travel_print = $travel_annotation[0][value];
	//	$travel_body  = '<label><b>&nbsp;&nbsp;Travel Comment:</b></label>';
	//	$travel_body .= $newline;
	//	$travel_body .= $newline;
	//	$travel_body .= elgg_view('input/longtext', array('internalname' => 'travel_comment', 'value' => $travel_print));
	//	$travel_body .= $newline;
	//	$travel_body .= elgg_view('input/submit', array('internalname' => 'travel_submit', 'value' => elgg_echo('Add your Travel here')));
	//	$travel_body .= elgg_view('input/securitytoken');
	//	$url = $event->getURL();		
	//	$travel_form_body = elgg_view('input/form', array('body' => $travel_body, 'action' => $url));
		
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
		
		
		$lati = $event->latitude;
		$long = $event->longitude;
		$lati_body = elgg_view("input/hidden",array('internalname' => 'lati_body','value'=>$lati));
		$long_body = elgg_view("input/hidden",array('internalname' => 'long_body','value'=>$long));
		
		$map_body = <<<EOT
		<div id="mapdiv" style="height:200px" width="100px"></div>
		<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
		<script>
		map = new OpenLayers.Map("mapdiv");
		map.addLayer(new OpenLayers.Layer.OSM());
		var lati_value = document.getElementsByName('lati_body')[0].value;
		var long_value = document.getElementsByName('long_body')[0].value;
		
		var lonLat = new OpenLayers.LonLat( long_value,lati_value )
		.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				map.getProjectionObject() // to Spherical Mercator Projection
		);
		
		var zoom=15;
		
		var markers = new OpenLayers.Layer.Markers( "Markers" );
		map.addLayer(markers);
		
		markers.addMarker(new OpenLayers.Marker(lonLat));
		
		map.setCenter (lonLat, zoom);
		</script>
    
EOT;
	
		$name = get_loggedin_user()->username;
		
		
		//echo $arrival_form_body.$newline; 
		//echo $departure_form_body.$newline;
		
		//function table_exists ($table, $db) {
			//$tables = mysql_list_tables ($db);
			//while (list ($temp) = mysql_fetch_array ($tables)) {
			//		if ($temp == $table) {
			//				return TRUE;
		//}
		//	}
		//	return FALSE;
		//}
					
		
		
		/*$con = mysql_connect($dbhost,$dbuser,$dbpass);
		$sql = 'CREATE DATABASE my_db';
		mysql_query($sql,$con);
		mysql_select_db("my_db",$con);
		$cre_query = "CREATE TABLE participant (name VARCHAR(30) primary key, arrival VARCHAR(10), departure VARCHAR(10), location VARCHAR(30));";
		mysql_query($cre_query,$con);
		$ins_query = "INSERT INTO participant (name,arrival,departure,location) VALUE ("$name","$data[1]","$data[2]","$data[3]");";
		mysql_query($ins_query,$con);
		mysql_select_db("my_db",$con);
		$sel_query = "SELECT name,arrival,departure,location FROM participant;";
		mysql_query($sel_query,$con);
		mysql_close($con);
		*/	

		
		
		if (isset($_POST['participant_comment']))
				{
					
					$par_comment = $_POST['participant_comment'];
					$data = explode("\n", $par_comment);	
					
					$dbhost = 'localhost';
					$dbuser = 'root';
					$dbpass = '';
					
					$con = mysql_connect($dbhost,$dbuser,$dbpass);
					
					$sql = 'CREATE DATABASE my_db';
					
					mysql_query($sql,$con);
					
					mysql_select_db("my_db",$con);
						
					$cre_query = "CREATE TABLE participant (name VARCHAR(30) primary key, arrival VARCHAR(10), departure VARCHAR(10), location VARCHAR(30));";
						
					mysql_query($cre_query,$con);
						
					$d1=$data[1];
					$d2=$data[2];
					$d3=$data[3];
					
					$ins_query = "INSERT INTO participant (name,arrival,departure,location) VALUE ('{$name}','{$d1}','{$d2}','{$d3}');";
						
					mysql_query($ins_query,$con);
					
					 
						
					$sel_query =mysql_fetch_array(mysql_query("SELECT * FROM participant where name='{$name}';"));
						
					
					//$name_row = $sel_query['name'];
					//$arrival_row = $sel_query['arrival'];
					//$departure_row = $sel_query['departure'];
					//$location_row = $sel_query['location'];
					//$part_print_rows = $name_row.$arrival_row.$departure_row.$location_row;
					$event->annotate('participant_comment', "");
					$participant_annotation = $event->getAnnotations('participant_comment');
					$participant_print = $participant_annotation[0][value];
					$participant_body = '<label><b>&nbsp;&nbsp;Participants:</b></label>';
					$participant_body .= $newline;
					$participant_body .= $newline;
					$participant_body .= elgg_view('input/longtext', array('internalname' => 'participant_comment', 'value' => $part_print_rows));
					$participant_body .= $newline;
					$participant_body .= elgg_view('input/submit', array('internalname' => 'participant_submit', 'value' => elgg_echo('Participate')));
					$participant_body .= elgg_view('input/securitytoken');
					$url = $event->getURL();
					$participant_form_body = elgg_view('input/form', array('body' => $participant_body, 'action' => $url));
						
					mysql_close($con);
					
				}
				
					
					/*$sel_query =mysql_query( "SELECT * FROM participant");
					 while($row=mysql_fetch_array($sel_query)){
					echo $row['name'];
					
					}*/
					
					
					
					//echo $sql['name']."-".$sql['arrival'];
												
					
								
					
					

				
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
				
	
				echo $participant_form_body.$newline;
				echo $material_form_body.$newline;
				echo $booth_form_body.$newline;
				echo $talks_form_body.$newline;
				echo $lati_body;
				echo $long_body;
				echo $map_body;
				
		
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


