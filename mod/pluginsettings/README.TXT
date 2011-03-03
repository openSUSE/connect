Plugin Settings Module
======================

Summary
-------
This module is designed to export your plugin settings i.e. the order
of your plugins and any settings saved using standard plugin settings
methods i.e. get_plugin_setting(), set_plugin_setting().

Any module that uses a custom method of saving plugin settings will 
not have there settings exported!

http://docs.elgg.org/wiki/Pluginsettings

No user configuration is exported!
No core settings are currented imported!

Requirements
------------
You need XMLReader and XMLWriter compiled with your PHP instance. 
XMLWriter is usually included with PHP by default. XMLReader may
not be!




