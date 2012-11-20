<?php

  /** Only add in the google headers if they haven't been already, and only if
      we're about to load a google map widget. */

if ($vars['entity'] instanceof ElggObject 
    && $vars['entity']->getSubtype() == 'widget'
    && $vars['entity']->handler == 'google-map'
    && $vars['callback'] != 'true') {
  gmap_load_scripts();
}
?>