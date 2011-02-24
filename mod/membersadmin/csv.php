<?php

  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);

  $members = $membersgroup->getMembers(0);

  header('Content-type: text/csv');
  header('Content-Disposition: attachment; filename="opensuse_members.csv"');

  echo "username;email_target;email_nick;email_full;freenode_nick;freenode_cloak;cloak_applied\n";
  foreach ($members as $m) {
      echo "{$m->username};{$m->email_target};{$m->email_nick};{$m->email_full};{$m->freenode_nick};{$m->freenode_cloak};";
      echo $m->cloak_applied ? "1\n" : "0\n";
  }

?>
