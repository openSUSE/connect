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

    // uncomment to change the user
    //logout();
    // use the following 2 lines to fake a login:
    //$_SERVER['HTTP_X_USERNAME'] = "rio";
    //$_SERVER['HTTP_X_EMAIL'] = "rio@scherben.de";

    $username = $_SERVER['HTTP_X_USERNAME'];
    if (isset($username) && !isloggedin()) {
        // load or create user
        $user = get_user_by_username($username);
        if (!$user) {
            // TODO make sure we get valid mails here
            $email = $_SERVER['HTTP_X_EMAIL'];
            error_log("Automatically creating new elgg user " . $username . " with mail: " . $email);
            // auto register new user
            // FIXME Fullname not included in headers
            if (register_user($username, 'opensuse', $username, $email)) {
                error_log("New elgg user " . $username . " created.");
                $user = get_user_by_username($username);
            } else
                error_log("Could not create elgg user " . $username);
        }
        error_log("Logging in elgg user " . $username);
        login($user, true);
        // Automatically update elgg email to ichain email
        if ($user->email != $_SERVER['HTTP_X_EMAIL']){
            $user->email = $_SERVER['HTTP_X_EMAIL'];
            $user->save();
            error_log("Updated users " . $username. " email to: " . $user->email);
        }
        return true;
    } elseif (!isset($username) && isloggedin()) {
        $user = get_loggedin_user();
        error_log("Logging out elgg user " . $user->username);
        logout();
    }
}

register_elgg_event_handler('init','system','ichain_client_init');
