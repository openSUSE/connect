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

    <?php if (isloggedin ()) { // Loggedin users only
?>
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
<?php if (isloggedin ()) { // Loggedin users only   ?>
            <li><a href="<?php echo $vars['url']; ?>pg/dashboard/"><?php echo elgg_echo('dashboard'); ?></a></li>
            <li><a href="<?php echo $vars['url']; ?>pg/governance/"><?php echo elgg_echo('Governance'); ?></a></li>
            <li><a href="<?php echo $vars['url']; ?>pg/membership/"><?php echo elgg_echo('Membership'); ?></a></li>
<?php } ?>
            <li><a href="<?php echo $vars['url']; ?>/pg/groups"><?php echo elgg_echo('Groups'); ?></a></li>
            <li><a href="<?php echo $vars['url']; ?>/pg/polls/all"><?php echo elgg_echo('Polls'); ?></a></li>
            <li><a href="<?php echo $vars['url']; ?>/pg/event_calendar/"><?php echo elgg_echo('Event Calendar'); ?></a></li>
            <li><a href="<?php echo $vars['url']; ?>/pg/members/all/"><?php echo elgg_echo('Users'); ?></a></li>
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
            &#169; 2011 Novell, Inc. and others.
            All content is made available under the terms of the GNU Free Documentation License version 1.2 ("GFDL")
            unless expressly indicated otherwise.
        </p>
    </div>

</div>
<!-- End: Footer -->



</body>
</html>