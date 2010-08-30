<?php

/**
 * Elgg ichain plugin
 *
 * @author tom@opensuse.org
 */

global $CONFIG;


/**
 * Ichain client initialisation
 */

function ichain_client_init() {
    // use the following 3 lines to fake a login:
    //$_SERVER['HTTP_X_USERNAME'] = "digitaltom";
    //$_SERVER['HTTP_X_EMAIL'] = "tomm@opensuse.org";
    //logout();

    $username = $_SERVER['HTTP_X_USERNAME'];
    if (isset($username) && !isloggedin()) {
        // load or create user
        $user = get_user_by_username($username);
        if (!$user) {
            // TODO make sure we get valid mails here
            $email = $_SERVER['HTTP_X_EMAIL'];
            error_log("Automatically creating new elgg user " . $username . " with mail: " . $email);
            // auto register new user
            if (register_user($username, 'opensuse', $username, $email)) {
                error_log("New elgg user " . $username . " created.");
                $user = get_user_by_username($username);
            } else
                error_log("Could not create elgg user " . $username);
                return false;
        }
        error_log("Automatically logging in elgg user " . $username);
        login($user, true);
        return true;
    } elseif (!isset($username) && isloggedin()) {
        error_log("Automatically logging out elgg user " . $username);
        logout();
        return false;
    }
}


register_elgg_event_handler('init','system','ichain_client_init');


