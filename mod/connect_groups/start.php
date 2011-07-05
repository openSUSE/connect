<?php
	/**
	 * Elgg groups plugin
	 *
	 * @package ElggGroups
	 */

	/**
	 * Hermes notificator, FIXME move to more general place, ie. to make it useable from
	 * other places
	 */
	function notify_hermes( $function, $options )
	{
		// ichain fun: only the username is set in the header of the request to 
		// notify.opensuse.org. Since we come through internal network, the user
		// is trusted.
		$username = 'connect_hermes'; // must exist in the hermes person table.

		$runmode = "notify";
		if( $function == 'subscribe_ml' ) {
			$runmode = 'subscribe_ml';
		}

		// do the hermes http call
		$host = "http://notify.opensuse.org/index.cgi";

		$query = "rm=". $runmode;
		foreach( $options as $option_name => $value ) {
			$query .= "&" . urlencode($option_name) . "=" . urlencode($value);
		}
		$url = $host . "?" . $query;
		elgg_log("Hermes: notify_hermes : " . $url, 'NOTICE' );
		$headers = array( headers => array("x-username" => $username, "user-agent" => "connect"));
		$result = http_parse_message( http_get( $url, $headers ))->body;
		elgg_log("Hermes notify result: " . $result );
	}

	global $CONFIG;
	register_action("groups/thumbvote",false,$CONFIG->pluginspath . "connect_groups/actions/thumbvote.php");
	add_group_tool_option('enable_ml',elgg_echo('groups:enablemailinglist'),true);
	add_group_tool_option('joinrequestvote',elgg_echo('groups:joinrequestvote'),false);
?>
