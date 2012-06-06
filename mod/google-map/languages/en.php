<?php

	$english = array(
	
           'gmap' => 'Google Maps',
           'gmap:desc' => 'This plugin allows you to place Google Maps on your Elgg site.',
           'gmap:nokey' => "You've installed the Google Map plugin but you still need to supply a GMap API key in the <a href='%spg/admin/plugins'>Tool Administration panel</a>.",

           'gmap:location' => 'Enter the location',
           'gmap:zoom' => 'Enter the zoom level',
           'gmap:notfound' => 'Address \'%s\' not found',
           
           'gmap:submit' => 'Submit',
           'gmap:modify' => 'Enter your Google Maps API Key<br /><small>You can obtain an API Key <a target="_blank" href="http://code.google.com/apis/maps/signup.html">here</a>.</small>',
           'gmap:modify:success' => 'Successfully updated the Google Maps API settings.',
           'gmap:modify:failed' => 'Failed to update the Google Maps API settings.',
           'gmap:failed:keyrequired' => 'You must provide an API key.',
           'gmap:nomap' => 'Map argument is required.',
           'gmap:noopts' => 'No location options were provided.',
           'gmap:noloc' => 'An address or lat/lng is required.',
           'gmap:failed:geocode' => 'Geocoding failed.',
           
           'gmap:last'
	);
					
	add_translation("en",$english);

?>