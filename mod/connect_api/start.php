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
   function connect_entity_attribute_get($guid,$attr) {
      // Get key description (we might be interested in who is asking)
      $key = get_key_description();

      // Defaults for the attribute
      if ($attr == "")
         $attr = "*";

      // If there is no such entity, return error
      if (!($user = get_entity($guid)))
         return new ErrorResult("There is no such entity.");

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

         $result = array( "guid" => $user->guid, 
                          "type" => $user->type
                        );
         if($user->name)
            $result = $result + array ( "name" => $user->name );
         if($user->email)
            $result = $result + array ( "email" => $user->email );
         foreach($md as $m) {
            if($m->owner_guid == $user->guid)
               $result = $result + array($m->name => $m->value);
         }
         return array("all" => $result);
      }
      return new ErrorResult("There is no such attribute.");
   }

   // Sets value of the attribute
   function connect_entity_set_attribute($guid,$attr,$value) {
      // Get key description (we might be interested in who is asking)
      $key = get_key_description();
      if(!$key)
         return new ErrorResult("Insuficient rights.");
      // If there is no such entity, return NULL
      if (!($user = get_entity($guid)))
         return new ErrorResult("There is no such entity.");

      // Bypass access controls if we are authenticated
      if($key)
         $ia = elgg_set_ignore_access(TRUE);

      // Test whether it is attribute of the object itself
      if(property_exists($user,$attr) || isset($user->$attr)) {
          $old = $user->$attr;
          $user->$attr = $value;
          $user->save();
          elgg_set_ignore_access($ia);
          return array($attr => array( "old" => $old, "new" => $value) );
      }

      // All we have left are metadata
      $old = get_metadata_byname($user->guid, $attr);
      $user->set($attr,$value);
      elgg_set_ignore_access($ia);
      return array($attr => array( "old" => $old->value, "new" => $value));
   }


   // Wrapper to allow to get attributes for login
   function connect_user_attribute_get($login,$attr) {
      if (($user = get_user_by_username($login)) &&
            (!($user->isBanned()))) {
         return connect_entity_attribute_get($user->guid,$attr);
      }
      return new ErrorResult("There is no such user.");
   }

   // Wrapper to allow to set attributes for login
   function connect_user_attribute_set($login,$attr,$value) {
      if (($user = get_user_by_username($login)) &&
            (!($user->isBanned()))) {
         return connect_entity_attribute_set($user->guid,$attr,$value);
      }
      return new ErrorResult("There is no such user.");
   }


   // Returns list of users groups
   function connect_user_groups_get($login) {
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
      return new ErrorResult("There is no such user.");
    }

    function connect_user_create($login, $email, $password, $name = "", $validate = TRUE) {
      $ia = elgg_set_ignore_access(TRUE);
      try {
         if($name == "") $name = $login;
         $guid = register_user($login, $password, $name, $email, false, 0, "");
         $new_user = get_entity($guid);
         if($validate) {
            request_user_validation($guid);
            $new_user->disable('new_user', false);
         } else {
            $new_user->enable();
            set_user_validation_status($guid, true, 'email');
         }
         elgg_set_ignore_access($ia);
         return array(
                  'login' => $new_user->username,
                  'name' => $new_user->name,
                  'email' => $new_user->email,
                  );
      } catch (RegistrationException $r) {
         elgg_set_ignore_access($ia);
         return new ErrorResult($r->getMessage());
      }
    }

    function connect_user_groups_add($login, $group_guid) {
      if (($user = get_user_by_username($login)) &&
            (!($user->isBanned()))) {
         $group = get_entity($group_guid);
         if(!$group)
            return new ErrorResult("Group not found!");
            $ia = elgg_set_ignore_access(TRUE);
            if (($group instanceof ElggGroup) && ($group->join($user)))
            {
                // Remove any invite or join request flags
                remove_entity_relationship($group->guid, 'invited', $user->guid);
                remove_entity_relationship($user->guid, 'membership_request', $group->guid);

                // add to river
                add_to_river('river/group/create','join',$user->guid,$group->guid);

                elgg_set_ignore_access($ia);
                return connect_user_groups_get($login);
            }
         elgg_set_ignore_access($ia);
         return new ErrorResult("Can't join the group.");
      }
      return new ErrorResult("There is no such user.");
    }

    function connect_user_groups_requestjoin($login, $group_guid) {
      if (($user = get_user_by_username($login)) &&
            (!($user->isBanned()))) {
         $group = get_entity($group_guid);
         if(!$group)
            return new ErrorResult("Group not found!");
            $ia = elgg_set_ignore_access(TRUE);
            if (($group instanceof ElggGroup))
            {
                add_entity_relationship($user->guid, 'membership_request', $group->guid);
                elgg_set_ignore_access($ia);
                return connect_user_groups_get($login);
            }
         elgg_set_ignore_access($ia);
         return new ErrorResult("Can't create join request to the group.");
      }
      return new ErrorResult("There is no such user.");
    }


    // Register our API

    expose_function("connect.user.groups.get",
                    "connect_user_groups_get",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true)),
                 'Returns groups that user is a member of',
                 'GET',
                 $non_public,
                 false
                );

    expose_function("connect.user.groups.add",
                    "connect_user_groups_add",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true),
                       "group_guid" => array(
                           'type' => 'int',
                           'required' => true)),
                 'Add user to the group',
                 'POST',
                 $non_public,
                 false
                );

    expose_function("connect.user.groups.requestjoin",
                    "connect_user_groups_requestjoin",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true),
                       "group_guid" => array(
                           'type' => 'int',
                           'required' => true)),
                 'Add join request user to the group',
                 'POST',
                 $non_public,
                 false
                );

    expose_function("connect.user.attribute.get",
                    "connect_user_attribute_get",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true),
                       "attribute" => array(
                           'type' => 'string',
                           'required' => false),
                       ),
                 'Returns user attribute',
                 'GET',
                 $non_public,
                 false
                );

    expose_function("connect.entity.attribute.get",
                    "connect_entity_attribute_get",
                 array("guid" => array(
                           'type' => 'int',
                           'required' => true),
                       "attribute" => array(
                           'type' => 'string',
                           'required' => false),
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

    expose_function("connect.user.create",
                    "connect_user_create",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true),
                       "email" => array(
                           'type' => 'string',
                           'required' => true),
                       "password" => array(
                           'type' => 'string',
                           'required' => true),
                       "name" => array(
                           'type' => 'string',
                           'required' => false),
                       "validate" => array(
                           'type' => 'boolean',
                           'required' => false),
                       ),
                 'Returns attribute of any entity',
                 'POST',
                 $non_public,
                 false
                );

    expose_function("connect.user.attribute.set",
                    "connect_user_attribute_set",
                 array("login" => array(
                           'type' => 'string',
                           'required' => true),
                       "attribute" => array(
                           'type' => 'string',
                           'required' => true),
                       "value" => array(
                           'type' => 'string',
                           'required' => true),
                       ),
                 'Sets user attribute',
                 'POST',
                 $non_public,
                 false
                );

    expose_function("connect.entity.attribute.set",
                    "connect_entity_attribute_set",
                 array("guid" => array(
                           'type' => 'int',
                           'required' => true),
                       "attribute" => array(
                           'type' => 'string',
                           'required' => true),
                       "value" => array(
                           'type' => 'string',
                           'required' => true),
                       ),
                 'Sets attribute of any entity',
                 'POST',
                 $non_public,
                 false
                );

?>
