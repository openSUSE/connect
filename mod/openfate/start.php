<?php

function openfate_init() {

    // Load system configuration
    global $CONFIG;


    add_widget_type('myfeatures', 'My features widget', 'Widget showing last changed features where you are involved from http://features.opensuse.org');
    //add_widget_type('new_features', 'My features widget', 'The hello, world widget');
    add_widget_type('changed_features', 'Changed features widget', 'Widget showing the last changed features from http://features.opensuse.org');
}

register_elgg_event_handler('init', 'system', 'openfate_init');
?>