LDAP export plugin
==================

To use this plugin you need to configure it editing 'config.php' file in its
directory. You also need working LDAP (including some structure). You can be
inspired by 'structure.ldif' file on how to create it. Once plugin is enabled
(and configured), user data will get exported to the LDAP every time user
changes something.

Currently exported data are 'uid', 'cn', 'sn', 'mail' and 'description'.
Everything is stored in inetOrgPerson as this is quite common class for
storing user data. If no name is present, username is used and if surname
can't be guessed from common name, whole common name is used as surname. uid
is set to connect login.
