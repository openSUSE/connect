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
  border: 1px dotted #666;
  margin: 0.5em 0;
  position: relative;
}
  .plugin_details.active {
    background: white;
  }
  .plugin_details h3 {
    font-size: 1.5em;
  }
.plugin_details.not-active {
  background-color: #ddd;
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