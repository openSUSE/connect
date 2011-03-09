<?php
  function obs_init() {
    global $obs_host;
    $obs_host = "https://build.opensuse.org";
    add_widget_type('obs', 'Repositories status', elgg_echo('obs:status_widget_desc'));
  }
 
  register_elgg_event_handler('init','system','obs_init');       
?>
