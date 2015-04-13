<?php

function subval_sort($a,$subkey) {
        foreach($a as $k=>$v) {
                $b[$k] = strtolower($v[$subkey]);
        }
        asort($b);
        foreach($b as $key=>$val) {
                $c[] = $a[$key];
        }
        return $c;
}

// separate method, used in connect_api module as well
function connect_maildump_func($full = true) {
    global $CONFIG;
    $membersgroup = new ElggGroup($CONFIG->MembersGroupID);
    $members = $membersgroup->getMembers(0);
    $members = subval_sort($members,'username');

    foreach ($members as $m) {
        if (!$m->email_target) continue;
        if ($full) {
            if ($m->email_nick) {
                printf("%-40s %s\n", $m->email_nick, $m->email_target);
            }
            if ($m->email_full && $m->email_full != $m->email_nick) {
                printf("%-40s %s\n", $m->email_full, $m->email_target);
            }
        } else {
            if ($m->email_nick) {
                printf("%s\n", $m->email_nick);
            }
        }
    }
    if ($full) {
        printf("%-40s %s\n", 'gnokii@opensuse.org', 'board@opensuse.org');
	printf("%-40s %s\n", 'security@opensuse.org', 'security@suse.de');
    }
}

/**
 * @desc:   Dump Members FullName and email
 * @param:  integer method
 *           1 = name, email_nick (or email_full)
 *           2 = name, email_target
 *           3 = name, email, email_nick, email_full, email_target
 * @return: csv like records   
 */
function connect_membersdump_func( $method = 0) {
  global $CONFIG;
  $method = (int) $method;
  $membersgroup = new ElggGroup($CONFIG->MembersGroupID);
  $members = $membersgroup->getMembers(0);
  $members = subval_sort($members,'name');

  foreach ($members as $m) {
    if (!$m->email_target) continue;

    switch ($method){

      case 1:
        // Useful for mailing to opensuse.org only
        $e = ($m->email_full && $m->email_full != $m->email_nick) ? $m->email_full : $m->email_nick;
        $ret = sprintf("%s,%s", $m->name, $e);
        break;

      case 2:
          // Useful for mailing directly final address
          $ret = sprintf("%s,%s", $m->name, $m->email_target);
      break;

      case 3:
        // control our database
        $ret = sprintf("%s,%s,%s,%s,%s", $m->name, $m->email, $m->email_nick, $m->email_full, $m->email_target);
        break;

      default:
        $ret = sprintf("%s", "Unknown method");
    }

    echo $ret.PHP_EOL;
  }
}
