<?php

   $non_public = true;

   // Tries to find your key in detebase and get description for it
   function get_key_description() {
      // Get the public key from the request
      if(!($pub_key = get_input('api_key')))
         return NULL;
      // Bypass acces controls to get all the keys
      $ia = elgg_set_ignore_access(TRUE);
      $keys = get_entities('object', 'api_key');
      elgg_set_ignore_access($ia);
      // Try to find a key
      foreach($keys as $key) {
         if($key->public == $pub_key)
       return $key->title;
      }
      // If not found, return NULL
      return NULL;
   }

   // Returns value of the attribute
   function connect_entity_get_attribute($guid,$attr) {
      // Get key description (we might be interested in who is asking)
      $key = get_key_description();

      // If there is no such entity, return NULL
      if (!($user = get_entity($guid)))
         return NULL;

      // Test whether it is attribute of the object itself
      if ($result = $user->$attr)
         return array($attr => $result);

      // Test whether it is among metadata
      // Bypass access controls if we are authenticated
      if($key)
         $ia = elgg_set_ignore_access(TRUE);
      $result = get_metadata_byname($user->guid, $attr);
      // Restore access controls
      if($key)
         elgg_set_ignore_access($ia);
      // If we found anything, return that
      if($result)
         return array($attr => $result->value);

      // We want all metadata?
      if ($attr == '*' ) {
         // Bypass access controls if we are authenticated
         if($key)
            $ia = elgg_set_ignore_access(TRUE);
         $md = get_metadata_for_entity($user->guid);
         // Restore access control
         if($key)
            elgg_set_ignore_access($ia);

         $result = array();
         foreach($md as $m) {
            if($m->owner_guid == $user->guid)
               $result = $result + array($m->name => $m->value);
         }
         return array($attr => $result);
      }

      return  array($attr => NULL);
   }

   // Wrapper to allow to get attributes for login
   function connect_user_get_attribute($login,$attr) {
      if (($user = get_user_by_username($login)) &&
            (!($user->isBanned()))) {
         return  connect_entity_get_attribute($user->guid,$attr);
      }
      return NULL;
   }

   // Returns list of users groups
   function connect_user_get_groups($login) {
   if (($user = get_user_by_username($login)) && (!($user->isBanned()))) {
         // Formulate what we want
         $options = array(
                  'relationship' => 'member',
                  'relationship_guid' => $user->guid,
                  'inverse_relationship' => FALSE,
                  'types' => 'group',
                  'subtypes' => '',
                  'owner_guid' => 0,
         );
         // Get all groups with desired properties
         $groups = elgg_get_entities_from_relationship($options);
         // Formulate the response
         $grp_data = array();
         foreach($groups as $group) {
            // Return owner of that group as well
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
      return NULL;
    }

    // Register our API

    expose_function("connect.user.get.groups",
                "connect_user_get_groups",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true)),
                 'Returns groups that user is a member of',
                 'GET',
                 $non_public,
                 false
                );

    expose_function("connect.user.get.attribute",
                "connect_user_get_attribute",
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
                "connect_entity_get_attribute",
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

    expose_function("connect.whoami",
                "get_key_description",
                 array(),
                 'Returns description of your key',
                 'GET',
                 true,
                 false
                );
?>
