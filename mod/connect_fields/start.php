<?php
    function connect_fields_profile_setup($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        $return_value["blog"] = "url";
        $return_value["country"] = "profile_dropdown";
        $return_value["xmpp"] = "connect_url";
        $return_value["contactemail"] = "connect_multitext";
        $return_value["freenode_nick"] = "text";
        $return_value["freenode_cloak"] = "text";
        $return_value["email_alias"] = "text";
        $return_value["openid"] = "url";
        $return_value["gpg"] = "connect_url";
        $return_value["ssh"] = "longtext";
        $return_value["twitter"] = "connect_url";
        $return_value["identica"] = "connect_url";
        $return_value["sip"] = "connect_url";
        $return_value["skype"] = "text";
        $return_value["facebook"] = "connect_url";
        $return_value["ohloh"] = "connect_url";
        $return_value["gitorious"] = "connect_url";
        $return_value["github"] = "connect_url";
        $return_value["linkedin"] = "connect_url";
        $return_value["xing"] = "url";
        $return_value["obs"] = "connect_multitext";
        unset($return_value["skills"]);
        unset($return_value["interests"]);
        return $return_value;
    }

    function connect_fields_group_setup($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        $return_value["blog"] = "url";
        $return_value["freenode_channel"] = "connect_url";
        $return_value["twitter"] = "url";
        $return_value["identica"] = "url";
        $return_value["facebook"] = "url";
        $return_value["obs"] = "connect_multitext";
        $return_value["ohloh"] = "connect_url";
        $return_value["bugtracker"] = "url";
        return $return_value;
    }

    register_plugin_hook('profile:fields', 'profile', 'connect_fields_profile_setup');
    register_plugin_hook('profile:fields', 'group',   'connect_fields_group_setup');
?>
