<?php

/**
 * openSUSE Bento theme
 **/

/**
 * Initialise the theme
 *
 */
function bento_init() {

    // Load system configuration
    global $CONFIG;

    // switch between hosted and local version of bento theming files
    $CONFIG->bento_path = "https://static.opensuse.org/themes/bento";
    // $CONFIG->bento_path = "/themes/bento";

}

// Initialise log browser
register_elgg_event_handler('init','system','bento_init');

?>