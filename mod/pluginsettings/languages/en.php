<?php

// Payments
$english = array (

	'item:object:pluginsettings'  => 'Plugin Settings',
	'pluginsettings:menu:import'  => 'Import settings',
	'pluginsettings:menu:export'  => 'Export settings',
	'pluginsettings:menu:admin'  => 'Import/Export settings',

	'pluginsetttings:file:export' => "Settings have been exported to file",

	'pluginsettings:title:export' => 'Export site settings',
	'pluginsettings:title:import' => 'Import site settings',
	'pluginsettings:import:warning' => 'WARNING: This will completely replace your settings, the order of the plugins and which plugins are active/disables and/or the core settings of your Elgg installation',
	'pluginsettings:label:export' => 'Export settings:',
	'pluginsettings:label:import' => 'Import settings:',
	'pluginsettings:label:fullimport' => 'Full import',
	'pluginsettings:label:core' => 'Just core settings',
	'pluginsettings:label:plugins' => 'Just plugin order/settings',

	'pluginsettings:error:xmlreader' => 'Your PHP instance does not support XMLReader. You cannot import.',
	'pluginsettings:error:xmlwriter' => 'Your PHP instance does not support XMLWriter. You cannot export.',
);

add_translation("en",$english);

?>