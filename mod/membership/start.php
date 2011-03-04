<?php

function membership_init() {

    // Load system configuration
    global $CONFIG;

    // Set up the menu for logged in users
    if (isloggedin ()) {
        add_menu(elgg_echo('Membership'), $CONFIG->wwwroot . "pg/membership");
    }

    register_page_handler('membership', 'membership_page_handler');

    register_action('membership/request', false, $CONFIG->pluginspath . "membership/actions/request.php", false);

    add_widget_type('membership', 'Membership', 'Widget showing membership stuff');
}

register_elgg_event_handler('init', 'system', 'membership_init');

/**
 * membership page handler; allows the use of fancy URLs
 *
 * @param array $page From the page_handler function
 * @return true|false Depending on success
 */
function membership_page_handler($page) {
    if (isset($page[0])) {
        switch ($page[0]) {
            case "index": @include(dirname(__FILE__) . "/pages/index.php");
                break;
        }
        return TRUE;
    } else {
        @include(dirname(__FILE__) . "/pages/index.php");
        return TRUE;
    }

    return FALSE;
}

?>
