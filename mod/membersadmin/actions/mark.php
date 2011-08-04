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
      foreach ( elgg_get_entities(array('types' => 'user')) as $user) {
          if ($user->freenode_nick && in_array($user->freenode_nick, $nicks)) {
              $user->cloak_applied = true;
              $user->save();
          }
      }
  }

  forward($_SERVER['HTTP_REFERER']);
?>
