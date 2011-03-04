<?php

function connect_dashboardwidgets_get($login) {
    $key = get_key_description();
    if ($key != 'widget_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for widget administration!");
    }
    if ($user = get_user_by_username($login)) {
        $widgets1 = get_widgets($user->getGUID(), 'dashboard', 1);
        $widgets2 = get_widgets($user->getGUID(), 'dashboard', 2);
        $widgets3 = get_widgets($user->getGUID(), 'dashboard', 3);
        $widgets = array_merge($widgets1, $widgets2, $widgets3);
        if ($widgets && count($widgets) > 0) {
            $result = array();
            foreach ($widgets as $widget) {
                array_push($result, $widget->handler);
            }
            return $result;
        } else {
            return new ErrorResult("Widgets not found for user $login");
        }
    } else {
        return new ErrorResult("User $login not found!");
    }
}

function connect_dashboardwidgets_add($login, $widget_handler, $column=1, $order=10) {
    $key = get_key_description();
    if ($key != 'widget_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for widget administration!");
    }
    if ($user = get_user_by_username($login)) {
        return add_widget($user->getGUID(), $widget_handler, 'dashboard', $order, $column);
    } else {
        return new ErrorResult("User $login not found!");
    }
}

function connect_dashboardwidgets_remove($login) {
    $key = get_key_description();
    if ($key != 'widget_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for widget administration!");
    }
    if ($user = get_user_by_username($login)) {
        $widgets1 = get_widgets($user->getGUID(), 'dashboard', 1);
        $widgets2 = get_widgets($user->getGUID(), 'dashboard', 2);
        $widgets3 = get_widgets($user->getGUID(), 'dashboard', 3);
        $widgets = array_merge($widgets1, $widgets2, $widgets3);
        if ($widgets && count($widgets) > 0) {
            foreach ($widgets as $widget) {
                delete_entity($widget->guid, $recursive = true);
            }
        }
        return "Widgets of $login removed";
    } else {
        return new ErrorResult("User $login not found!");
    }
}

function connect_dashboardwidgets_reset($login) {
    $key = get_key_description();
    if ($key != 'widget_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for widget administration!");
    }
    if ($user = get_user_by_username($login)) {
        $guid = $user->getGUID();
        // taken from mod/defaultwidgets/start.php
        $entities = elgg_get_entities(array('type' => 'object', 'subtype' => 'moddefaultwidgets', 'limit' => 9999));
        // check if the entity exists
        if (isset($entities [0])) {
            connect_dashboardwidgets_remove($login);
            // get the widgets for the context
            $entity = $entities [0];
            $context = 'dashboard';
            $widget_access = ACCESS_PUBLIC;
            $current_widgets = $entity->$context;
            list ( $left, $middle, $right ) = split('%%', $current_widgets);
            // split columns into seperate widgets
            $area1widgets = split('::', $left);
            $area2widgets = split('::', $middle);
            $area3widgets = split('::', $right);
            // clear out variables if no widgets are available
            if ($area1widgets [0] == "")
                $area1widgets = false;
            if ($area2widgets [0] == "")
                $area2widgets = false;
            if ($area3widgets [0] == "")
                $area3widgets = false;

            // generate left column widgets for a new user
            if ($area1widgets) {
                foreach ($area1widgets as $i => $widget) {
                    add_widget($guid, $widget, $context, ($i + 1), 1, $widget_access);
                }
            }

            // generate middle column widgets for a new user
            if ($area2widgets) {
                foreach ($area2widgets as $i => $widget) {
                    add_widget($guid, $widget, $context, ($i + 1), 2, $widget_access);
                }
            }

            // generate right column widgets for a new user
            if ($area3widgets) {
                foreach ($area3widgets as $i => $widget) {
                    add_widget($guid, $widget, $context, ($i + 1), 3, $widget_access);
                }
            }
            return "Widgets of $login reset to defaults";
        } else {
            return new ErrorResult("No default widgets found!");
        }
    } else {
        return new ErrorResult("User $login not found!");
    }
}

function connect_dashboardwidgets_reset_all() {
    $key = get_key_description();
    if ($key != 'widget_admin') {
        return new ErrorResult("Your used key doesn't have sufficient permissions for widget administration!");
    }
    $options = array('types' => 'user');
    $users = elgg_get_entities($options);
    $result = array();
    foreach ($users as $user) {
        connect_dashboardwidgets_reset($user->username);
        array_push($result, $user->username);
    }
    return $result;
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

expose_function("connect.dashboardwidgets.add",
        "connect_dashboardwidgets_add",
        array("login" => array(
                'type' => 'string',
                'required' => true),
            "widget_handler" => array(
                'type' => 'string',
                'required' => true),
            "column" => array(
                'type' => 'int',
                'required' => false),
            "order" => array(
                'type' => 'int',
                'required' => false)
        ),
        'Adds a widget to the users dashboard',
        'POST',
        $require_api_auth,
        false
);

expose_function("connect.dashboardwidgets.remove",
        "connect_dashboardwidgets_remove",
        array("login" => array(
                'type' => 'string',
                'required' => true),
        ),
        'Removes all users dashboard widgets',
        'POST',
        $require_api_auth,
        false
);

expose_function("connect.dashboardwidgets.reset",
        "connect_dashboardwidgets_reset",
        array("login" => array(
                'type' => 'string',
                'required' => true),
        ),
        'Resets the users dashboard widgets',
        'POST',
        $require_api_auth,
        false
);

expose_function("connect.dashboardwidgets.reset.all",
        "connect_dashboardwidgets_reset_all",
        array(),
        'Resets _all_ users dashboard widgets',
        'POST',
        $require_api_auth,
        false
);
?>