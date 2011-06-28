<?php
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

  admin_gatekeeper();
  set_context('admin');

  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);

  $members = $membersgroup->getMembers(0);

  header('Content-type: text/plain; charset=utf-8');
  header('Content-Disposition: attachment; filename="opensuse_cloaks.txt"');

  foreach ($members as $m) {
    if ($m->freenode_nick && $m->freenode_cloak) {
      echo "{$m->freenode_nick}\t{$m->freenode_cloak}\n";
    }
  }

?>
