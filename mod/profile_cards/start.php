<?php

/**
 * Profile Cards generator (VCard/QR/Business cards)
 **/

function profile_cards_init() {
    global $CONFIG;
    $CONFIG->qr_url = "http://chart.apis.google.com/chart?cht=qr&chs=230x230&chl=";
    elgg_extend_view('css', 'profile_cards/css');
    elgg_extend_view('profile/userdetails', 'profile_cards/profile/userdetails');
}

register_elgg_event_handler('init','system','profile_cards_init');

?>
