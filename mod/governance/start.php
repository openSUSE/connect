<?php

function governance_init() {

    // Load system configuration
    global $CONFIG;

    // Set up the menu for logged in users
    if (isloggedin ()) {
        add_menu(elgg_echo('Governance'), $CONFIG->wwwroot . "pg/groups/10501/opensuse-board/");
    }

    register_page_handler('governance', 'governance_page_handler');

    //register_page_handler('governance','governance_page_handler');
    add_widget_type('governance', 'Governance', 'Widget showing board stuff');
}

register_elgg_event_handler('init', 'system', 'governance_init');

/**
 * governance page handler; allows the use of fancy URLs
 *
 * @param array $page From the page_handler function
 * @return true|false Depending on success
 */
function governance_page_handler($page) {
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