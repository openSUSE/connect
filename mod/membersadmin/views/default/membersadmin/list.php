<?php

  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);

  $members = $membersgroup->getMembers(0);

  echo "<p>";
  echo "<a href=\"{$vars['url']}pg/membersadmin/csv/\">download full CSV</a> | ";
  echo "<a href=\"{$vars['url']}pg/membersadmin/txt/\">download just cloaks TXT</a> | ";
  echo "<a href=\"{$vars['url']}pg/membersadmin/maildump/\">download maildump</a>";
  echo "</p>\n";

  echo "<div>\n";
  $form_body  = "<table>\n";
  $form_body .= "<tr><th>username</th><th>nick</th><th>cloak</th><th>applied</th>\n";
  foreach ($members as $m) {
      if ($m->cloak_applied) continue;
        $form_body .= "<tr><td>{$m->username}</td><td>{$m->freenode_nick}</td><td>{$m->freenode_cloak}</td><td><input type='checkbox' name='apply[]' value='{$m->guid}' /></tr>\n";
  }
  $form_body .= '<tr><td colspan="4">' . elgg_view('input/longtext', array('internalname' => 'applylist', 'value' => '')) . '</td></tr>';
  $form_body .= "</table>\n";
  $form_body .= elgg_view('input/submit', array('value' => elgg_echo('membersadmin:mark')));
  echo elgg_view('input/form', array('action' => "{$vars['url']}action/membersadmin/mark", "body" => $form_body));

?>
