<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 *
 */

// get the tools menu
//$menu = get_register('menu');

?>

<div class="clearfloat"></div>

<!-- <div class="clearfloat"></div> -->

<!-- </div> --><!-- /#page_wrapper -->
</div><!-- /#page_container -->
    
<!-- Start: Footer -->
    <div id="footer" class="container_12">

        <?php if (isloggedin()) { // Loggedin users only ?>
        <div class="box_content grid_3">
              <a href="<?php echo $_SESSION['user']->getURL(); ?>"><img class="user_mini_avatar" src="<?php echo $_SESSION['user']->getIcon('topbar'); ?>" alt="User avatar" /></a>
              <strong class="grey-medium spacer1"><a href="<?php echo $_SESSION['user']->getURL(); ?>"><?php echo $_SESSION['username']; ?></a></strong>
          <ul class="navlist">
            <li><a href="<?php echo $_SESSION['user']->getURL(); ?>">Profile</a></li>
            <?php if ($vars['user']->isAdmin()) { ?>
            <li> <a href="<?php echo $vars['url']; ?>pg/admin/" class="usersettings"><?php echo elgg_echo("admin"); ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>


      <div class="box_content grid_3">
        <strong class="grey-medium spacer1">Locations</strong>
        <ul>
          <li><a href="<?php echo $vars['url']; ?>pg/dashboard/"><?php echo elgg_echo('dashboard'); ?></a></li>
        </ul>
      </div>

      <div class="box_content grid_3">
        <strong class="grey-medium spacer1">Help</strong>
        <ul>
          <li><a href="http://en.opensuse.org/openSUSE:Connect">Connect Wiki page</a></li>
        </ul>
      </div>


      <div id="footer-legal" class="border-top grid_12">
        <p>
          &#169; 2010 Novell, Inc. All rights reserved. Novell is a registered trademark and
          openSUSE and SUSE are trademarks of Novell, Inc. in the United States and other countries.
        </p>
      </div>

    </div>
    <!-- End: Footer -->



</body>
</html>