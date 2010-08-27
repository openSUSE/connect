<?php
    function connect_fields_profile_setup($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        $return_value["blog"] = "url";
        $return_value["country"] = "profile_dropdown";
        $return_value["xmpp"] = "text";
        $return_value["freenode_nick"] = "text";
        $return_value["freenode_cloak"] = "text";
        $return_value["email_alias"] = "text";
        $return_value["openid"] = "text";
        $return_value["gpg"] = "text";
        $return_value["ssh"] = "longtext";
        $return_value["twitter"] = "url";
        $return_value["identica"] = "url";
        $return_value["skype"] = "text";
        $return_value["faceboook"] = "url";
        $return_value["ohloh"] = "url";
        $return_value["gitorious"] = "url";
        $return_value["github"] = "url";
        $return_value["linkedin"] = "url";
        $return_value["xing"] = "url";
        unset($return_value["skills"]);
        unset($return_value["interests"]);
        return $return_value;
    }

    function connect_fields_group_setup($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        $return_value["blog"] = "url";
        $return_value["irc"] = "text";
        $return_value["twitter"] = "url";
        $return_value["identica"] = "url";
        $return_value["faceboook"] = "url";
        $return_value["obs"] = "text";
        $return_value["ohloh"] = "url";
        $return_value["bugtracker"] = "url";
        return $return_value;
    }

    register_plugin_hook('profile:fields', 'profile', 'connect_fields_profile_setup');
    register_plugin_hook('profile:fields', 'group',   'connect_fields_group_setup');
?>
