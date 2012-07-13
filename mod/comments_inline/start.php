<?php

	/**
	 * Comments Inline
	 * 
	 * @package comments_inline
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Pedro Prez
	 * @copyright 2009
	 * @link http://www.pedroprez.com.ar/
 	*/
	
	function comments_inline_init()
	{
		global $CONFIG;
		
		//** VIEWS
			extend_view('metatags','comments_inline/javascript');
		
			
		// Extend CSS
		    extend_view('css','comments_inline/css');
		    
		// Extend LONGTEXT
		    extend_view('input/longtext','comments_inline/clear');
		
	}
		
	//**BEGIN
	register_elgg_event_handler('init','system','comments_inline_init');
?>
