<?php
// Start your engines
require_once (dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) ) . "/engine/start.php");

// get elgg version and release
require_once (dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) ) . "/version.php");

// run user gatekeeper
admin_gatekeeper ();
action_gatekeeper();

// get plugin information
$plugin_list = get_plugin_list ();

global $CONFIG;

// serve xml doc as xml
header ( 'Content-Disposition: attachment; filename="site-export.xml"' );
header ( 'Content-type: application/xml' );

$xml = new XmlWriter ( );
$xml->openMemory ();
$xml->setIndent ( true );
$xml->startDocument ( '1.0', 'UTF-8' );
$xml->startElement ( 'elgg' );

$xml->writeAttribute ( 'timestamp', time () );
$xml->writeAttribute ( 'version', $version );
$xml->writeAttribute ( 'release', $release );

// reserved: to be used in the future to save core settings
$xml->startElement ( 'core' );

$xml->startElement ( 'database' );
$xml->writeAttribute ( 'table_prefix', $CONFIG->dbprefix );
if ($CONFIG->db->split) {
	$xml->writeAttribute ( 'split_connections', 'true' );	
} else {
	$xml->writeAttribute ( 'split_connections', 'false' );
}

// handle multiple connections for reading and writing
if (! empty ( $CONFIG->db->split )) {
	
	foreach ( array ('read', 'write' ) as $dblinkname ) {
		
		if (is_array ( $CONFIG->db [$dblinkname] )) {
			
			foreach ( $CONFIG->db [$dblinkname] as $connection ) {
				$xml->startElement ( 'connection' );
				$xml->writeAttribute ( 'type', $dblinkname );
				
				$xml->startElement ( 'username' );
				$xml->text ( $connection->dbuser );
				$xml->endElement ();
				
				$xml->startElement ( 'password' );
				$xml->text ( $connection->dbpass );
				$xml->endElement ();
				
				$xml->startElement ( 'database' );
				$xml->text ( $connection->dbname );
				$xml->endElement ();
				
				$xml->startElement ( 'host' );
				$xml->text ( $connection->dbhost );
				$xml->endElement ();
				
				$xml->endElement (); // end connection
			}
		} else {
			$xml->startElement ( 'connection' );
			$xml->writeAttribute ( 'type', $dblinkname );
			
			$xml->startElement ( 'username' );
			$xml->text ( $CONFIG->db [$dblinkname]->dbuser );
			$xml->endElement ();
			
			$xml->startElement ( 'password' );
			$xml->text ( $CONFIG->db [$dblinkname]->dbpass );
			$xml->endElement ();
			
			$xml->startElement ( 'database' );
			$xml->text ( $CONFIG->db [$dblinkname]->dbname );
			$xml->endElement ();
			
			$xml->startElement ( 'host' );
			$xml->text ( $CONFIG->db [$dblinkname]->dbhost );
			$xml->endElement ();
			
			$xml->endElement (); // end connection
		}
	}

} else {
	// dump the single read/write connection
	$xml->startElement ( 'connection' );
	$xml->writeAttribute ( 'type', 'readwrite' );
	
	$xml->startElement ( 'username' );
	$xml->text ( $CONFIG->dbuser );
	$xml->endElement ();
	
	$xml->startElement ( 'password' );
	$xml->text ( $CONFIG->dbpass );
	$xml->endElement ();
	
	$xml->startElement ( 'database' );
	$xml->text ( $CONFIG->dbname );
	$xml->endElement ();
	
	$xml->startElement ( 'host' );
	$xml->text ( $CONFIG->dbhost );
	$xml->endElement ();
	
	$xml->endElement (); // end readwrite connection
}
$xml->endElement (); // end database


$xml->startElement ( 'config' );

$xml->startElement ( 'path' );
$xml->text ( $CONFIG->path );
$xml->endElement ();

$xml->startElement ( 'dataroot' );
$xml->text ( $CONFIG->dataroot );
$xml->endElement ();

$xml->startElement ( 'view' );
$xml->text ( $CONFIG->view );
$xml->endElement ();

$xml->startElement ( 'language' );
$xml->text ( $CONFIG->language );
$xml->endElement ();

$xml->startElement ( 'default_access' );
switch ($CONFIG->default_access) {
	case - 1 :
		$xml->text ( 'ACCESS_DEFAULT' );
		break;
	case 0 :
		$xml->text ( 'ACCESS_PRIVATE' );
		break;
	case 1 :
		$xml->text ( 'ACCESS_LOGGED_IN' );
		break;
	case 2 :
		$xml->text ( 'ACCESS_PUBLIC' );
		break;
	case - 2 :
		$xml->text ( 'ACCESS_FRIENDS' );
		break;
}
$xml->endElement ();

$xml->startElement ( 'allow_user_default_access' );
if ($CONFIG->allow_user_default_access) {
	$xml->text ( 'true' );
} else {
	$xml->text ( 'false' );
}
$xml->endElement ();

$xml->startElement ( 'simplecache_enabled' );
if ($CONFIG->simplecache_enabled) {
	$xml->text ( 'true' );
} else {
	$xml->text ( 'false' );
}
$xml->endElement ();

$xml->startElement ( 'debug' );
if ($CONFIG->simplecache_enabled) {
	$xml->text ( 'true' );
} else {
	$xml->text ( 'false' );
}
$xml->endElement ();

$xml->startElement ( 'https_login' );
if ($CONFIG->https_login) {
	$xml->text ( 'true' );
} else {
	$xml->text ( 'false' );
}
$xml->endElement ();

$xml->startElement ( 'enable_api' );
if ($CONFIG->disable_api) {
	$xml->text ( 'false' );
} else {
	$xml->text ( 'true' );
}
$xml->endElement ();

$xml->startElement ( 'ping_home' );
if ($CONFIG->ping_home) {
	$xml->text ( 'false' );
} else {
	$xml->text ( 'true' );
}
$xml->endElement ();

$xml->endElement (); // end config


$xml->startElement ( 'site' );

$xml->startElement ( 'id' );
$xml->text ( $CONFIG->site_id );
$xml->endElement ();

$xml->startElement ( 'name' );
$xml->text ( $CONFIG->sitename );
$xml->endElement ();

$xml->startElement ( 'description' );
$xml->text ( $CONFIG->sitedescription );
$xml->endElement ();

$xml->startElement ( 'url' );
$xml->text ( $CONFIG->wwwroot );
$xml->endElement ();

$xml->startElement ( 'email' );
$xml->text ( $CONFIG->siteemail );
$xml->endElement ();

$xml->endElement (); // end site
$xml->endElement (); // end core


if ($plugin_list) {
	$xml->startElement ( 'plugins' );
	
	foreach ( $plugin_list as $order => $mod ) {
		// start plugin element
		

		$xml->startElement ( 'plugin' );
		
		/*
		$xml->startElement ( 'order' );
		$xml->text ( $order );
		$xml->endElement ();
		*/
		
		$xml->startElement ( 'name' );
		$xml->text ( htmlentities ( $mod ) );
		$xml->endElement ();
		
		$xml->startElement ( 'enabled' );
		if (is_plugin_enabled ( $mod )) {
			$xml->text ( 'true' );
		} else {
			$xml->text ( 'false' );
		}
		$xml->endElement ();
		
		$plugin_entity = find_plugin_settings ( $mod );
		if ($plugin_entity) {
			$plugin_settings = get_all_private_settings ( $plugin_entity->guid );
			if ($plugin_settings) {
				
				$xml->startElement ( 'settings' );
				
				foreach ( $plugin_settings as $name => $value ) {
					$xml->startElement ( 'setting' );
					
					$xml->startElement ( 'name' );
					$xml->text ( htmlentities ( $name ) );
					$xml->endElement ();
					
					$xml->startElement ( 'value' );
					if (is_bool ( $value )) {
						if ($value) {
							$value = 'true';
						} else {
							$value = 'false';
						}
						$xml->text ( $value );
					} else {
						$value = htmlentities ( $value );
						if (preg_match ( '/\n/', $value )) {
							
							$xml->writeCData ( $value );
							$value = "\n<![CDATA[\n" . $value . "\n]]>\n";
						} else {
							$xml->text ( $value );
						}
					}
					// end value element
					$xml->endElement ();
					
					// end setting element
					$xml->endElement ();
				}
				
				// end settings element
				$xml->endElement ();
			}
		
		}
		
		// end plugin element
		$xml->endElement ();
	}
	// end plugins element
	$xml->endElement ();
}

// end the document and output


$xml->endElement ();
echo utf8_encode ( $xml->outputMemory ( true ) );
exit ();