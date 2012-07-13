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

?>
<script type='text/javascript'>
	jQuery(document).ready(function(){
		jQuery("textarea[@name='generic_comment']").click(function(){
			jQuery(this).html('');
			jQuery('div.contentWrapper input[type="submit"]').show();
			jQuery('div.contentWrapper textarea.input-textarea').css({'color':'#333333','font-style':'normal'});
		})
		
		
	})
	
	
	
</script>