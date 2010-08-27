<?php
    function connect_fields_setup($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        // add fields here
        $return_value["beer"]="profile_checkbox";
        $return_value["country"]="profile_dropdown";
        return $return_value;
    }
    register_plugin_hook('profile:fields', 'profile', 'connect_fields_setup');
?>
