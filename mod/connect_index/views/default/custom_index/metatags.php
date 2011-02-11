<?php
	/**
	 * Custom Index page head extender
	 * 
	 * @package connect_index
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Henne Vogelsang <hvogel@opensuse.org>
	 * @copyright openSUSE 2011-2012
	 */
?>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/connect_index/js/prettyphoto/js/jquery.prettyPhoto.js" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$("a[rel^='prettyPhoto']").prettyPhoto({theme:'light_rounded',slideshow:7000, autoplay_slideshow:true, overlay_gallery:false});
		});
	</script>
	<link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/connect_index/js/prettyphoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
