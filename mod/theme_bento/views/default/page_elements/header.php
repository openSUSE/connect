<?php
/**
 * Elgg pageshell
 * The standard HTML header that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 *
 * @uses $vars['config'] The site configuration settings, imported
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 */

// Set title
if (empty($vars['title'])) {
  $title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
  $title = $vars['title'];
} else {
  $title = $vars['config']->sitename . ": " . $vars['title'];
}


// we won't trust server configuration but specify utf-8
header('Content-type: text/html; charset=utf-8');

$version = get_version();
$release = get_version(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="ElggRelease" content="<?php echo $release; ?>" />
  <meta name="ElggVersion" content="<?php echo $version; ?>" />
  <title><?php echo $title; ?></title>

  <script type="text/javascript" src="<?php echo $CONFIG->bento_path ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery-ui-1.7.2.custom.min.js"></script>
  <script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery.form.js"></script>
  <script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;js=initialise_elgg&amp;viewtype=<?php echo $vars['view']; ?>"></script>
<?php
  global $pickerinuse;
  if (isset($pickerinuse) && $pickerinuse == true) {
?>
  <!-- only needed on pages where we have friends collections and/or the friends picker -->
  <script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery.easing.1.3.packed.js"></script>
  <script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;js=friendsPickerv1&amp;viewtype=<?php echo $vars['view']; ?>"></script>
<?php
  }
?>
  <!-- include the default css file -->
  <link rel="stylesheet" href="<?php echo $vars['url']; ?>_css/css.css?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;viewtype=<?php echo $vars['view']; ?>" type="text/css" />

  <!-- include Bento Theme -->
  <link rel="stylesheet" href="<?php echo $CONFIG->bento_path ?>/css/style.css?lastcache=<?php echo $vars['config']->lastcache; ?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo $vars['url']; ?>mod/theme_bento/css_local/css.css?lastcache=<?php echo $vars['config']->lastcache; ?>" type="text/css" />
  <script type="text/javascript" src="<?php echo $CONFIG->bento_path ?>/js/script.js"></script>
  <script src="<?php echo $vars['url']; ?>mod/theme_bento/js_local/script.js?lastcache=<?php echo $vars['config']->lastcache; ?>" type="text/javascript"></script>

  <?php
    echo $feedref;
    echo elgg_view('metatags',$vars);
  ?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
    });
  </script>

  <!-- Piwik -->
  <script type="text/javascript">
      var _paq = _paq || [];
      (function(){
          var u=(("https:" == document.location.protocol) ? "https://beans.opensuse.org/piwik/" : "http://beans.opensuse.org/piwik/");
          _paq.push(['setSiteId', 6]);
          _paq.push(['setTrackerUrl', u+'piwik.php']);
          _paq.push(['trackPageView']);
          _paq.push([ 'setDomains', ["*.opensuse.org"]]);
          var d=document,
          g=d.createElement('script'),
          s=d.getElementsByTagName('script')[0];
          g.type='text/javascript';
          g.defer=true;
          g.async=true;
          g.src=u+'piwik.js';
          s.parentNode.insertBefore(g,s);
      })();
  </script>
  <!-- End Piwik Code -->

</head>

<body>
