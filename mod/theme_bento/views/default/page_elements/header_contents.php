<?php
/**
 * Elgg header contents
 * This file holds the header output that a user will see
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 **/

?>

<div id="subheader" class="container_16">
    <div id="breadcrump" class="grid_11 alpha">
        <a href="/"><img src="<?php echo $vars['url']; ?>mod/theme_bento/graphics/home_grey.png" alt="Connect Home"/></a>
    </div>

    <div class="grid_5 omega">
      
      <?php if (isloggedin()) { // Loggedin users only ?>

        <!-- Link: User Image -->
        <!-- <a href="<?php echo $_SESSION['user']->getURL(); ?>"><img class="user_mini_avatar" src="<?php echo $_SESSION['user']->getIcon('topbar'); ?>" alt="User avatar" /></a> -->
      
        <!-- Link: Dashboard -->
        <a href="<?php echo $vars['url']; ?>pg/dashboard/" class="pagelinks"><?php echo elgg_echo('dashboard'); ?></a>
      
        <?php
          // Tools Dropdown-Menu
          echo elgg_view("navigation/topbar_tools");

          //allow people to extend this top menu
          echo elgg_view('elgg_topbar/extend', $vars);
        ?>
      
        <!-- Link: Settings -->
        <a href="<?php echo $vars['url']; ?>pg/settings/" class="usersettings"><?php echo elgg_echo('settings'); ?></a>
      
        <?php // Link: Administration
          if ($vars['user']->isAdmin()) { // The administration link is for admin or site admin users only
        ?>
          <a href="<?php echo $vars['url']; ?>pg/admin/" class="usersettings"><?php echo elgg_echo("admin"); ?></a>
        <?php
            }
        ?>
      
        <!-- Link: Logout -->
        <?php echo elgg_view('output/url', array('href' => "{$vars['url']}action/logout", 'text' => elgg_echo('logout'), 'is_action' => TRUE)); ?>

      <?php } ?> 
      
    </div>
</div>



<div id="page_container" class="container_16 content-wrapper" id="content">
    <!-- <div id="page_wrapper" class="box box-shadow grid_13 clearfix"> Temp. disabled -->
    <div id="page_wrapper" class="box box-shadow grid_16 alpha omega clearfix">



