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

<script type="text/javascript" src="<?php echo $CONFIG->bento_path ?>/js/l10n/global-navigation-data-en_US.js"></script>
<script type="text/javascript" src="<?php echo $CONFIG->bento_path ?>/js/global-navigation.js"></script>

    <!-- Start: Header -->
    <div id="header">

        <div id="header-content" class="container_12">

            <a id="header-logo" href="http://www.opensuse.org"><img src="<?php echo $CONFIG->bento_path ?>/images/header-logo.png" width="46" height="26" alt="Header Logo" /></a>

            <ul id="global-navigation">
                <!-- change link to en.o.o after transition -->
                <li id="item-downloads"><a href="http://wiki.opensuse.org//openSUSE:Browse#Downloads">Downloads</a></li>
                <li id="item-support"><a href="http://wiki.opensuse.org//openSUSE:Browse#Support">Support</a></li>
                <li id="item-community"><a href="http://wiki.opensuse.org//openSUSE:Browse#Community">Community</a></li>
                <li id="item-development"><a href="http://wiki.opensuse.org//openSUSE:Browse#Development">Development</a></li>
            </ul>

            <!-- TODO: Fix search menu -->
            <form id="global-search-form" action="<?php echo $vars['url']; ?>pg/search/" method="get">
              <input type="text" size="21" name="q" value="Search" onclick="if (this.value=='Search') { this.value='' }" id="search" />
              <input type="submit" value="Go" class="hidden" />
            </form>

        </div>
    </div>

<!-- <div class="clearfloat"></div> -->

