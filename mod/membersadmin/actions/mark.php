<?php
  global $CONFIG;

  admin_gatekeeper();

  $apply = get_input('apply');

  if (is_array($apply)) {
    foreach ($apply as $guid) {
      $user = get_entity($guid);
      if ($user) {
        $user->cloak_applied = true;
        $user->save();
      }
    }
  }

  $applylist = get_input('applylist');
  if ($applylist) {
      $nicks = array();
      $tok = strtok($applylist, " \t\r\n");
      while ($tok !== false) {
          $nicks[] = $tok;
          $tok = strtok(" \t\r\n");
      }
      $users = elgg_get_entities_from_metadata(array('types' => 'user', 'metadata_names' => array('freenode_nick'), 'metadata_values' => $nicks, 'limit' => 9999));
      foreach ($users as $user) {
          $user->cloak_applied = true;
          $user->save();
      }
  }

  forward($_SERVER['HTTP_REFERER']);
?>
