<?php
	/**
	 * Custom Index page css extender
	 * 
	 * @package theme_bento
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2010
	 * @link git://git.cynapses.org/projects/cpaste.git
	 */
?>


.plugin_details {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -khtml-border-radius: 5px;
  
  margin: 1em;
  border: 2px solid #999;

  box-shadow: 0 1px 2px #ccc;
  -moz-box-shadow: 0 1px 2px #ccc;
  -webkit-box-shadow: 0 1px 2px #ccc;
  
  position: relative;
  
}
  .plugin_details.active {
    border-color: #768d99;
    border-color: #80A0B2;
    background-color: #f6f6f6;
    
/*    box-shadow: 0 1px 3px #999;
    -moz-box-shadow: 0 1px 3px #999;
    -webkit-box-shadow: 0 1px 3px #999;*/
    
  }

.plugin_details.not-active {
  background-color: #e9e9e9;
  border-color: #fff;
}
  .plugin_details h3 {
    font-size: 1.5em;
  }

.plugin_details a.button {
  border: 1px solid #c9c9c9;
}

.admin_plugin_enable_disable,
.admin_plugin_reorder {
  position: absolute;
  bottom: 1em;
  right: 1em;
}


.admin_plugin_reorder {
  bottom: auto;
  top: 1em;
}

#widget_picker_gallery th,
#widget_picker_gallery td,
#customise_page_view th,
#customise_page_view td {
  border: none;
}

#customise_page_view,
.contentWrapper {

}
#customise_editpanel {
  display: none;
}

#customise_page_view {}

#customise_page_view {
    padding: 0 !important;
    margin: 0 !important;
}

#customise_editpanel_rhs {}