<?php
// Start your engines
require_once (dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) ) . "/engine/start.php");
require_once (dirname ( dirname ( __FILE__ ) ) . "/includes/import.inc.php" ); 

// run user gatekeeper
admin_gatekeeper ();
action_gatekeeper();

// get uploaded file
$file = get_uploaded_file ( 'upload' );

// get import type
$type = strtolower(get_input('type'));

// read the xml file that was uploaded
$xml = new XMLReader ( );
$xml->setParserProperty ( XMLReader::VALIDATE, true );
$xml->XML ( $file );

// parse the XML file into an array
$xml_array = xml2assoc ( $xml );

// process the XML array
_processImportXML ( $xml_array, $type );

// clear out all site caches
_clearCache ();
// forward user to the admin tools menu
global $CONFIG;
forward ( $CONFIG->wwwroot . 'pg/admin/plugins/' );
exit ();