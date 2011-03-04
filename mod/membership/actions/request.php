<?php
  global $CONFIG;

  $contrib = get_input('contributions');
  if ($contrib) {

    $user = get_loggedin_user();
    $user->contributions = $contrib;
    $user->save();

    if (!check_entity_relationship($user->guid, 'membership_request', $CONFIG->MembersGroupID)) {
        add_entity_relationship($user->guid, 'membership_request', $CONFIG->MembersGroupID);
    }

    system_message(elgg_echo("membership:requestmade"));
    forward($vars['url'] . 'pg/dashboard/');
  } else {
    system_message(elgg_echo("membership:nocontrib"));
    forward($_SERVER['HTTP_REFERER']);
  }

?>
