<?php

global $CONFIG;
gatekeeper();
$logged_in_user = get_loggedin_user();

$group_guid = get_input('group_guid');
$group = get_entity($group_guid);
$user_guid = get_input('user_guid');
$user = get_entity($user_guid);

if ($group->canEdit()) {

    // If join request made
    if (check_entity_relationship($user->guid, 'membership_request', $group->guid)) {
        remove_entity_relationship($user->guid, 'membership_request', $group->guid);
        // send reject email
        $subject = "openSUSE membership application declined";
        $body = get_input('notification');
        notify_user($user->getGUID(), $group->owner_guid, $subject, $body, NULL);
        // Notify the membership team
        $annotations = $user->getAnnotations('join_vote_' . ($group->guid));
        $feedback = "";
        if ($annotations) {
            $feedback = "\n\nFeedback from Membership team: ";
            foreach ($annotations as $ann) {
                $feedback .= "\n" . get_entity($ann->owner_guid)->username . ": {$ann->value}";
            }
        }

        elgg_send_email("membership-officials@opensuse.org",
                "membership-officials@opensuse.org", $subject,
                $logged_in_user->name . " declined the membership request of " . $user->name . "." .
		$feedback .
                "\n\nText sent to user: \n\n" . $body);
        system_message(elgg_echo("groups:joinrequestkilled"));
    }
}

forward("/mod/groups/membershipreq.php?group_guid=" . $group_guid);
?>
