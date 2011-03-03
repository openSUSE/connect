<?php
// Start your engines
global $CONFIG;
if (!isset($CONFIG))
	$CONFIG = new stdClass;
define('externalpage',true);

$_SERVER["PHP_SELF"] = 'action_handler.php';

require_once ( dirname ( dirname ( dirname ( __FILE__ ) ) )  . "/engine/start.php");
require_once ( dirname ( __FILE__ )  . "/includes/import.inc.php" ); 

if (!$argv) {
	global $CONFIG;
	forward ( $CONFIG->wwwroot );
}

// check if file exists and get it's contents
if (file_exists($argv[1])) {
	$file = file_get_contents($argv[1]);
}

if ($argv[2]) {
	$type = strtolower($argv[2]);
} else {
	$type = 'full';
}

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
exit ();