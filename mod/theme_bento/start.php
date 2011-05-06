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

    // setting correct base url
    $pathpart = str_replace("//","/",str_replace($_SERVER['DOCUMENT_ROOT'],"",$CONFIG->path));
    if (substr($pathpart,0,1) != "/") {
        $pathpart = "/" . $pathpart;
    }
    $protocol = "http";
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
    $CONFIG->url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $pathpart;

}

// Initialise log browser
register_elgg_event_handler('init','system','bento_init');

?>