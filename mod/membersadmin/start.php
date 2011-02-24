<?php
  function membersadmin_init($event, $object_type, $object = null) {

    global $CONFIG;

    register_page_handler('membersadmin','membersadmin_page_handler');

    register_action('membersadmin/mark', false, $CONFIG->pluginspath . "membersadmin/actions/mark.php", true);
  }

  function membersadmin_pagesetup()
  {
    if (get_context() == 'admin' && isadminloggedin()) {
      global $CONFIG;
      add_submenu_item(elgg_echo('membersadmin'), $CONFIG->wwwroot . 'pg/membersadmin/');
    }
  }

  function membersadmin_page_handler($page)
  {
    global $CONFIG;

    if ($page[0])
    {
      switch ($page[0])
      {
        default : include($CONFIG->pluginspath . "membersadmin/index.php");
      }
    }
    else
      include($CONFIG->pluginspath . "membersadmin/index.php");
  }

  register_elgg_event_handler('init','system','membersadmin_init');
  register_elgg_event_handler('pagesetup','system','membersadmin_pagesetup');
?>
