<?php

function openfate_init() {

    // Load system configuration
    global $CONFIG, $feature_host;
    $feature_host = "http://fatedmz.suse.de:9090/sxkeeper/feature/";

    add_widget_type('myfeatures', 'My features', 'Widget showing last changed features where you are involved from http://features.opensuse.org');
    add_widget_type('changed_features', 'Changed features', 'Widget showing the last changed features from http://features.opensuse.org');
}

register_elgg_event_handler('init', 'system', 'openfate_init');
?>