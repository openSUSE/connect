<?php

function governance_init() {

    // Load system configuration
    global $CONFIG;

    //register_page_handler('governance','governance_page_handler');
    add_widget_type('governance', 'Governance', 'Widget showing board stuff');
   
}

register_elgg_event_handler('init', 'system', 'governance_init');
?>