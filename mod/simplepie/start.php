<?php

/**
* Simplepie Plugin
* 
* Loads the simplepie feed parser library and provides a widget
**/

function simplepie_init() {
	add_widget_type('feed_reader', elgg_echo('simplepie:widget'), elgg_echo('simplepie:description'));
	elgg_extend_view('css', 'feed_reader/css');
}

register_elgg_event_handler('plugins_boot', 'system', 'simplepie_init');

