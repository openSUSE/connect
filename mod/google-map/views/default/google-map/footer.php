<?php /* Google Maps plugin for the Elgg social network engine. */ ?>
<?php
  // Post a system message if the plugin is enabled but there is no API key 
$settings = find_plugin_settings('google-map');
if (!$settings->api_key) {
  if ($_SESSION['user']->admin || $_SESSION['user']->siteadmin) {
    system_message(sprintf(elgg_echo("gmap:nokey"), $CONFIG->url));
  }
}
?>