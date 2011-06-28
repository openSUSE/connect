<?php

require_once(dirname(dirname(__FILE__)) . '/membersadmin/maildump_func.php');


function connect_membersadmin_maildump() {
    $key = get_key_description();
    if ($key != 'members_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for members administration!");
    }

    header('Content-type: text/plain; charset=utf-8');
    connect_maildump_func();
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
