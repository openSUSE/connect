<?php
/**
         * Elgg group operators
         * 
         * @package
         * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
         * @author lorea
         * @copyright lorea
         * @link http://lorea.cc
         */

        function group_operators_page_handler($page){
                global $CONFIG;
                switch($page[0]) {
                        case 'add':
                                set_input('group_guid', $page[1]);
                                include($CONFIG->pluginspath . "group_operators/add.php");
                                break;
                }
        }
        function group_operators_pagesetup() {
                global $CONFIG;
                $page_owner = page_owner_entity();
                if ($page_owner instanceof ElggGroup && get_context() == "groups" && $page_owner->canEdit()) {
                        add_submenu_item(elgg_echo("group_operators:addoperators"),
                                        $CONFIG->wwwroot . "pg/group_operators/add/".$page_owner->getGUID());
                }
        }


	function group_operators_permissions_hook($hook, $entity_type, $returnvalue, $params) {
		return group_operators_container_permissions_hook($hook, $entity_type, $returnvalue, array('container'=>$params['entity'], 'user'=>$params['user']));
	}
	function group_operators_container_permissions_hook($hook, $entity_type, $returnvalue, $params) {
		if ($params['user'] && $params['container']) {
			$container_guid = $params['container']->getGUID();
			$user_guid = $params['user']->getGUID();
			if (check_entity_relationship($user_guid, 'operator', $container_guid))
				return true;
		}
		return $returnvalue;
	}

 	function group_operators_init(){
			global $CONFIG;
			register_plugin_hook('permissions_check', 'group', 'group_operators_permissions_hook');
			register_plugin_hook('container_permissions_check', 'group', 'group_operators_container_permissions_hook');
			register_action("group_operators/add",false, $CONFIG->pluginspath . "group_operators/actions/add.php");
                        register_action("group_operators/remove",false, $CONFIG->pluginspath . "group_operators/actions/remove.php");

			register_page_handler('group_operators','group_operators_page_handler');
			register_elgg_event_handler('pagesetup','system','group_operators_pagesetup');

	}

register_elgg_event_handler('init','system','group_operators_init');

?>
