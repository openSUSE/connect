<?php
   function export_profile($event, $object_type, $user) {
      if (is_callable('object_notifications'))
      if ($user instanceof ElggUser) {

         // Default values (UI to set them not yet ready)
         $ldaphost = "127.0.0.1";
         $ldapport = NULL;
         $ldaprdn  = "cn=root,dc=obs,dc=opensuse.org";
         $ldappass = "password";
         $ldaproot = "ou=users,dc=obs,dc=opensuse.org";

         require(dirname(__FILE__) . "/config.php");

         // Connect to the ldap
         if ($ldapconn = ldap_connect($ldaphost, $ldapport)) {
         ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
         if (ldap_bind($ldapconn, $ldaprdn, $ldappass)) {

         // Create user object
         $user_info = array();
         $user_info["cn"]          = $user->name;
         if($user_info["cn"] == "")  $user_info["cn"] = $user->username;
         if(strrpos($user->name," ") != FALSE)
            $user_info["sn"]       = substr($user->name,strrpos($user->name," "));
         else $user_info["sn"]     = $user_info["cn"];
         $user_info["mail"]        = $user->email;
         $user_info["description"] = $user->description;
         $user_info["objectclass"] = "inetOrgPerson";

         // Delete user and add it again with new attributes
         ldap_delete($ldapconn, "uid=" . $user->username . ", " . $ldaproot);
         ldap_add(   $ldapconn, "uid=" . $user->username . ", " . $ldaproot,
                     $user_info);

         }
         ldap_close($ldapconn);
         }
      }
   }

   global $CONFIG;

   register_elgg_event_handler('profileupdate', 'all', 'export_profile', 1000);
?>
