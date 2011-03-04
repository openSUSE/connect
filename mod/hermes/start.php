<?php

  function hermes_init() {        
    elgg_log("Hermes init called!", 'NOTICE' );
    elgg_extend_view('css','hermes/css');
    elgg_log("Hermes view extended!", 'NOTICE' );
    add_widget_type('subscriptions', 'Hermes Subscriptions', 'Hermes Subscriptions 2');
  }
  
  register_elgg_event_handler('init','system','hermes_init');       
?>
