<?php
  function openfate_init() {
    add_widget_type('myfeatures', 'My features widget', 'Widget showing changes to features where you are involved from http://features.opensuse.org');
    //add_widget_type('new_features', 'My features widget', 'The hello, world widget');
    //add_widget_type('last_changed_features', 'My features widget', 'The hello, world widget');
  }

  register_elgg_event_handler('init','system','openfate_init');
?>