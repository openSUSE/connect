<?php

gatekeeper();
// Get the current page's owner
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
    $page_owner = $_SESSION['user'];
    set_page_owner($_SESSION['guid']);
}

//set the title
$area2 = elgg_view_title(elgg_echo('Membership'));

// Get the form
$area2 .= elgg_view("membership/index");

// Display page
page_draw(elgg_echo('Membership'), elgg_view_layout("two_column_left_sidebar", $area1, $area2));
?>