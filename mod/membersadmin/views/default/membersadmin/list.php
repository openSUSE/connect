<?php

  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);

  $members = $membersgroup->getMembers(0);

  echo "<div><a href=\"{$vars['url']}pg/membersadmin/csv/\">download full CSV</a> | <a href=\"{$vars['url']}pg/membersadmin/txt/\">download just cloaks TXT</a></div>\n";

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

?>
