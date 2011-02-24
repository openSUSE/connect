<?php

  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);

  $members = $membersgroup->getMembers(0);

  header('Content-type: text/plain');
  header('Content-Disposition: attachment; filename="opensuse_cloaks.txt"');

  foreach ($members as $m) {
      echo "{$m->freenode_nick}\t{$m->freenode_cloak}\n";
  }

?>
