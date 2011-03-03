<?php
// Start your engines
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . "/engine/start.php");

// run user gatekeeper
admin_gatekeeper ();

//global $CONFIG;
//echo "<style> .xdebug-var-dump { background: black; }</style>";
//var_dump($CONFIG);

set_context('pluginsettings');
	
// create view
$title = elgg_echo('pluginsettings:title:export');	
$content = elgg_view('pluginsettings/export');
    
// Format page
$body = elgg_view_layout('two_column_left_sidebar', false, $content);

// check if XMLWriter is defined
if (!class_exists('XMLWriter')) {
	register_error(elgg_echo('pluginsettings:error:xmlwriter'));
}

// Draw it
echo page_draw( $title, $body );
