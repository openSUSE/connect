<?php

  define('MEMBERSID', 111);

  $membersgroup = new ElggGroup(MEMBERSID);

  $members = $membersgroup->getMembers();

  echo "<pre>\n";
  echo "username;email_target;email_nick;email_full;freenode_nick;freenode_cloak\n";
  foreach ($members as $m) {
      echo "{$m->username};{$m->email_target};{$m->email_nick};{$m->email_full};{$m->freenode_nick};{$m->freenode_cloak}\n";
  }
  echo "</pre>\n";

?>
