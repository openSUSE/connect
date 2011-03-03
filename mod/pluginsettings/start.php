<?php
    function pluginsettings_init() {
    	global $CONFIG;
    	register_action ( "pluginsettings/import", false, $CONFIG->pluginspath . "pluginsettings/actions/import.php", true );
		register_action ( "pluginsettings/export", false, $CONFIG->pluginspath . "pluginsettings/actions/export.php", true );
    	register_page_handler ( 'pluginsettings', 'pluginsettings_page_handler' );
    	register_elgg_event_handler ( 'pagesetup', 'system', 'pluginsettings_pagesetup' );
    }
    
    function pluginsettings_pagesetup() {
	
		global $CONFIG;

    	if (get_context() == 'admin' && isadminloggedin()) {
			add_submenu_item(elgg_echo('pluginsettings:menu:admin'), $CONFIG->wwwroot . 'pg/pluginsettings/export');
		}		
		
		// add submenu options
		if (get_context () == "pluginsettings") {
			if ((page_owner () == $_SESSION ['guid'] || ! page_owner ()) && isadminloggedin ()) {
				add_submenu_item ( elgg_echo ( 'pluginsettings:menu:export' ), $CONFIG->wwwroot . "pg/pluginsettings/export" );
				add_submenu_item ( elgg_echo ( 'pluginsettings:menu:import' ), $CONFIG->wwwroot . "pg/pluginsettings/import" );
			}
		}
	
	}    
    
    function pluginsettings_page_handler($page) {
	
		global $CONFIG;
		
		if (isset ( $page [0] )) {
			switch ($page [0]) {
				case "export" :
					@include (dirname ( __FILE__ ) . "/export.php");
					break;
				case "import" :
					@include (dirname ( __FILE__ ) . "/import.php");
					if ($page[1]) {
						set_input('config', $page[1]);
					}
					break;
				default :
					@include (dirname ( __FILE__ ) . "/export.php");
					return true;
			}
		} else {
			@include (dirname ( __FILE__ ) . "/export.php");
			return true;			
		}
    }
    
    
    
    register_elgg_event_handler('init','system','pluginsettings_init');
?>