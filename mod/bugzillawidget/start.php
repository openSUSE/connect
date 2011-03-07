<?php

function bugzillawidget_init() {
    add_widget_type('bugzilla', 'My Bugs', 'Widget showing bugs from Bugzilla');
}

register_elgg_event_handler('init', 'system', 'bugzillawidget_init');

?>
