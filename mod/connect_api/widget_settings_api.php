<?php

function connect_dashboardwidgets_get($login) {
    $key = get_key_description();
    if ($key != 'widget_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for widget administration!");
    }

    if ($user = get_user_by_username($login)) {
        $result = get_widgets($user->getGUID(), 'dashboard', 1);
        if ($result && count($result) > 0) {

            //TODO
            return "widgets";

        } else {
            return new ErrorResult("Widgets not found for user $login");
        }
    } else {
        return new ErrorResult("User $login not found!");
    }
}

// Expose our api methods
// expose_function ($method, $function, array $parameters=NULL,
//                  $description="", $call_method="GET", $require_api_auth=false,
//                  $require_user_auth=false)


expose_function("connect.dashboardwidgets.get",
        "connect_dashboardwidgets_get",
        array("login" => array(
                'type' => 'string',
                'required' => true),
        ),
        'Returns the users dashboard widgets',
        'GET',
        $require_api_auth,
        false
);
?>