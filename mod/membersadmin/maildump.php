<?php

  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);

  $members = $membersgroup->getMembers(0);

  header('Content-type: text/plain; charset=utf-8');
  header('Content-Disposition: attachment; filename="maildump.txt"');

  foreach ($members as $m) {
    if (!$m->email_target) continue;
    if ($m->email_nick) {
      printf("%-40s %s\n", $m->email_nick, $m->email_target);
    }
    if ($m->email_full) {
      printf("%-40s %s\n", $m->email_full, $m->email_target);
    }
  }
  printf("%-40s %s\n", 'gnokii@opensuse.org', 'board@opensuse.org');
  echo "\n";
?>
