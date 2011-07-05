<?php
        /**
         * Accept a group join request.
         *
         * @package ElggGroups
         */

        require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
        gatekeeper();

        $group_guid = (int) get_input('group_guid');
        $user_guid = (int) get_input('user_guid');
        $group = get_entity($group_guid);
        $user = get_entity($user_guid);
        set_page_owner($group_guid);

        $template_file = dirname(dirname(dirname(__FILE__))) . "/mod/connect_groups/templates/accept_member";
        $fh = fopen($template_file, 'r');
        $templatedata = fread($fh, filesize($template_file));
        fclose($fh);

        $title = "Accept membership request";

        $area2 = elgg_view_title($title);

        if (($group) && ($group->canEdit()))
        {
                $area2 .= elgg_view('groups/accept_member',array('user' => $user, 'entity' => $group, 'template' => $templatedata));

        } else {
                $area2 .= elgg_echo("groups:noaccess");
        }

        $body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);

        page_draw($title, $body);
?>
