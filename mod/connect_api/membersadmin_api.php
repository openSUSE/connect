<?php

function connect_membersadmin_maildump() {
    $key = get_key_description();
    if ($key != 'members_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for members administration!");
    }

    $membersgroup = new ElggGroup($CONFIG->MembersGroupID);
    $members = $membersgroup->getMembers(0);

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
}

// Expose our api methods
// expose_function ($method, $function, array $parameters=NULL,
//                  $description="", $call_method="GET", $require_api_auth=false,
//                  $require_user_auth=false)


expose_function("connect.membersadmin.maildump",
        "connect_membersadmin_maildump",
        array(),
        'Returns the members maildump data',
        'GET',
        $require_api_auth,
        false
);

?>
