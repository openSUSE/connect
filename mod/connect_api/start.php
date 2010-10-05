<?php

   $non_public = true;

   function my_get_user_attr($login,$attr) {
      if (($user = get_user_by_username($login)) &&
            (!($user->isBanned()))) {
         return array($attr => $user->$attr);
      }
      return false;
   }

   function my_get_ent_attr($guid,$attr) {
      if ($group = get_entity($guid)) {
         return array($attr => $group->$attr);
      }
      return false;
   }

   function my_get_user_groups($login) {
   if (($user = get_user_by_username($login)) && (!($user->isBanned()))) {
         $options = array(
                  'relationship' => 'member',
                  'relationship_guid' => $user->guid, 
                  'inverse_relationship' => FALSE, 
                  'types' => 'group', 
                  'subtypes' => '', 
                  'owner_guid' => 0, 
         );
         $groups = elgg_get_entities_from_relationship($options);
         $grp_data = array();
         foreach($groups as $group) {
            if($owner = get_user($group->owner_guid)) {
               $owner = $owner->username;
            } else {
               $owner = $group->owner_guid;
            }
            $grp_data = $grp_data + array("group-" . $group->guid => array(
                                             "guid" => $group->guid,
                                             "name" => $group->name,
                                             "owner" => $owner,
                                             "public" => 
                                                ($group->membership == ACCESS_PUBLIC)
                                             ));
         }
         return array( "login" => $login,
                       "groups" => $grp_data
                     );
      }
      return false;
    }

    expose_function("connect.user.get.groups", 
                "my_get_user_groups", 
                 array("login" => array(
                           'type' => 'string',
                           'required' => true)),
                 'Returns groups that user is a member of',
                 'GET',
                 $non_public,
                 false
                );

    expose_function("connect.user.get.attribute", 
                "my_get_user_attr", 
                 array("login" => array(
                           'type' => 'string',
                           'required' => true),
                       "attribute" => array(
                           'type' => 'string',
                           'required' => true),
                       ),
                 'Returns user attribute',
                 'GET',
                 $non_public,
                 false
                );

    expose_function("connect.entity.get.attribute", 
                "my_get_ent_attr", 
                 array("guid" => array(
                           'type' => 'int',
                           'required' => true),
                       "attribute" => array(
                           'type' => 'string',
                           'required' => true),
                       ),
                 'Returns attribute of any entity',
                 'GET',
                 $non_public,
                 false
                );

?>
