<?php

global $CONFIG;
gatekeeper();
$logged_in_user = get_loggedin_user();

$group_guid = get_input('group_guid');
$group = get_entity($group_guid);
$user_guid = get_input('user_guid');
$user = get_entity($user_guid);

if ($group->canEdit()) {

    // set email fields
    // ignore access controls
    $ia = elgg_set_ignore_access(TRUE);
    $user->set('email_nick', get_input('alias_nick'));
    $user->set('email_full', get_input('alias_full'));
    $user->set('email_target', get_input('target_email'));
    $user->save();

    // If join request made
    if (check_entity_relationship($user->guid, 'membership_request', $group->guid)) {
        remove_entity_relationship($user->guid, 'membership_request', $group->guid);
        system_message(elgg_echo("groups:joinrequestkilled"));
    }
}

forward("/mod/groups/membershipreq.php?group_guid=" . $group_guid);
?>
