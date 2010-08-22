<?php
    function profilefields_setup($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        // add fields here
        $return_value["favoritecolor"]="text";
        return $return_value;
    }
    register_plugin_hook('profile:fields', 'profile', 'profilefields_setup');
?>
