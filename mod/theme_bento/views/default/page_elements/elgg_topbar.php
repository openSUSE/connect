<?php
/**
 * Elgg top toolbar
 * The standard elgg top toolbar
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 *
 */
?>

<div id="elgg_topbar">

    <script type="text/javascript" src="https://static.opensuse.org/themes/bento/js/l10n/global-navigation-data-en_US.js"></script>
    <script type="text/javascript" src="https://static.opensuse.org/themes/bento/js/global-navigation.js"></script>

    <!-- Start: Header -->
    <div id="header">

        <div id="header-content" class="container_12">

            <a id="header-logo" href="http://www.opensuse.org"><img src="https://static.opensuse.org/themes/bento/images/header-logo.png" width="46" height="26" alt="Header Logo" /></a>

            <ul id="global-navigation">
                <!-- change link to en.o.o after transition -->
                <li id="item-downloads"><a href="http://wiki.opensuse.org//openSUSE:Browse#Downloads">Downloads</a></li>
                <li id="item-support"><a href="http://wiki.opensuse.org//openSUSE:Browse#Support">Support</a></li>
                <li id="item-community"><a href="http://wiki.opensuse.org//openSUSE:Browse#Community">Community</a></li>
                <li id="item-development"><a href="http://wiki.opensuse.org//openSUSE:Browse#Development">Development</a></li>
            </ul>

            <?php if (isloggedin()) { ?>

            <a href="<?php echo $_SESSION['user']->getURL(); ?>"><img class="user_mini_avatar" src="<?php echo $_SESSION['user']->getIcon('topbar'); ?>" alt="User avatar" /></a>

            <a href="<?php echo $vars['url']; ?>pg/dashboard/"><?php echo elgg_echo('dashboard'); ?></a>

                <?php echo elgg_view("navigation/topbar_tools"); ?>

            <?php echo elgg_view('elgg_topbar/extend', $vars); ?>

                <a href="<?php echo $vars['url']; ?>pg/settings/" class="usersettings"><?php echo elgg_echo('settings'); ?></a>

                    <?php if ($vars['user']->isAdmin()) { ?>

                        <a href="<?php echo $vars['url']; ?>pg/admin/" class="usersettings"><?php echo elgg_echo("admin"); ?></a>

                    <?php } ?>

                <?php echo elgg_view('page_elements/searchbox'); ?>

                <?php } ?>

        </div>


    </div>



</div><!-- /#elgg_topbar -->

<div class="clearfloat"></div>

