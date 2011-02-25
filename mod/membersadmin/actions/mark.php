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

  forward($_SERVER['HTTP_REFERER']);
?>
