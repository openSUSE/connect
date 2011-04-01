<!--
/**
 * Elgg openid_server: autologin form view
 * 
 * @package ElggOpenID
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */
-->
<html>
<head>
<title>
<?php echo elgg_echo('openid_server:autologin_title'); ?>
</title>
<meta http-equiv="refresh" content="3;<?php echo $vars['return_url']; ?>"/>
</head>
<body>
<?php echo elgg_echo('openid_server:autologin_body')."<br /><br />\n".$vars['iframes'] ?>
</body>
</html>