<?php 

	function advanced_comments_init(){
		
		// extend css
		elgg_extend_view("css/elgg", "advanced_comments/css");
		
		// extend metatags
		elgg_extend_view("js/elgg", "advanced_comments/js");
		
		// register page handler for nice URL's
		elgg_register_page_handler("advanced_comments", "advanced_comments_page_handler");
	}
	
	function advanced_comments_page_handler($page){
		
		switch($page[0]){
			case "load":
				include(dirname(__FILE__) . "/procedures/load.php");
				return true;
			default:
				return false;
		}
	}
	
	// register default elgg events
	elgg_register_event_handler("init", "system", "advanced_comments_init");
	