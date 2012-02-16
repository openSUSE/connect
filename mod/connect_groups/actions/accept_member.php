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
    $user->set('freenode_nick', get_input('irc_nick'));
    $user->set('freenode_cloak', get_input('irc_cloak'));
    $user->save();

    if (!$group->isMember($user)) {
        // Remove relationships
        remove_entity_relationship($group->guid, 'invited', $user->guid);
        remove_entity_relationship($user->guid, 'membership_request', $group->guid);
        $group->join($user);
        // send welcome email
        $subject = "openSUSE membership application approved";
        $body = get_input('notification');
        notify_user($user->getGUID(), $group->owner_guid, $subject, $body, NULL);
        $annotations = $user->getAnnotations('join_vote_' . ($group->guid));
        $feedback = "";
        if ($annotations) {
            $feedback = "\n\nFeedback from Membership team: ";
            foreach ($annotations as $ann) {
                $feedback .= "\n" . get_entity($ann->owner_guid)->username . ": {$ann->value}";
            }
        }
        // Notify the membership team
        elgg_send_email("membership-officials@opensuse.org",
                "membership-officials@opensuse.org", $subject,
                $logged_in_user->name . " approved the membership request of " . $user->username . "." .
                "\nEmail alias: " . get_input('alias_nick') . " " . get_input('alias_full') . " -> " . get_input('target_email') .
                "\nName: " . $user->name .
		"\nConnect page: https://connect.opensuse.org/pg/profile/" . $user->username .
                $feedback .
                "\n\nText sent to user: \n\n" . $body);
        system_message(elgg_echo('groups:addedtogroup'));
    } else {
        register_error(elgg_echo("groups:cantjoin"));
    }
}

forward("/mod/groups/membershipreq.php?group_guid=" . $group_guid);
?>
