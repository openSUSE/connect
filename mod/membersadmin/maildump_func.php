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
    $membersgroup = new ElggGroup($CONFIG->MembersGroupID);
    $members = $membersgroup->getMembers(0);
    $members = array_unique($members, SORT_REGULAR);
    $members = subval_sort($members,'username');

    foreach ($members as $m) {
        if (!$m->email_target) continue;
        if ($full) {
            if ($m->email_nick) {
                printf("%-40s %s\n", $m->email_nick, $m->email_target);
            }
            if ($m->email_full) {
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
    }
}

?>
