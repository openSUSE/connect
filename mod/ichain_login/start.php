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
    // Check for ichain header
    $_SERVER['HTTP_X_USERNAME'] = "digitaltom";
    $username = $_SERVER['HTTP_X_USERNAME'];
    if (isset($username) && !isloggedin()) {
        // load or create user
        $user = get_user_by_username($username);
        if (!$user) {
            error_log("Automatically creating new elgg user " . $username);
            // TODO: auto register new user
            //register_user($username, $password, $name, $email, $allow_multiple_emails = false, $friend_guid = 0, $invitecode = '');


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


