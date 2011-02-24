<?php

  define('MEMBERSID', 111);

  $membersgroup = new ElggGroup(MEMBERSID);

  $members = $membersgroup->getMembers(0);

  echo "<div>\n";
  $form_body  = "<table>\n";
  $form_body .= "<tr><th>username</th><th>nick</th><th>cloak</th><th>applied</th>\n";
  foreach ($members as $m) {
      if ($m->cloak_applied) continue;
        $form_body .= "<tr><td>{$m->username}</td><td>{$m->freenode_nick}</td><td>{$m->freenode_cloak}</td><td><input type='checkbox' name='apply[]' value='{$m->guid}' /></tr>\n";
  }
  $form_body .= "</table>\n";
  $form_body .= elgg_view('input/submit', array('value' => elgg_echo('membersadmin:mark')));
  echo elgg_view('input/form', array('action' => "{$vars['url']}action/membersadmin/mark", "body" => $form_body));

  echo "<hr/>";

  echo "<pre>\n";
  echo "username;email_target;email_nick;email_full;freenode_nick;freenode_cloak;cloak_applied\n";
  foreach ($members as $m) {
      echo "{$m->username};{$m->email_target};{$m->email_nick};{$m->email_full};{$m->freenode_nick};{$m->freenode_cloak}";
      echo $m->cloak_applied ? "1\n" : "0\n";
  }
  echo "</pre>\n";
  echo "</div>\n";

?>
