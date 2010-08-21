<?php

// Load polls model
require_once(dirname(__FILE__)."/models/model.php");

function polls_init() {
	
	// Load system configuration
		global $CONFIG;
		
	// Set up menu for logged in users
		if (isloggedin()) {    		
			add_menu(elgg_echo('polls'), $CONFIG->wwwroot . "pg/polls/list/" . get_loggedin_user()->username);
			
	// And for logged out users
		} else {
			add_menu(elgg_echo('poll'), $CONFIG->wwwroot . "pg/polls/all");
		}
		
	// Extend system CSS with our own styles, which are defined in the polls/css view
		extend_view('css','polls/css');
		
	// Extend hover-over menu	
		extend_view('profile/menu/links','polls/menu');
		
	// Register a page handler, so we can have nice URLs
		register_page_handler('polls','polls_page_handler');
		
	// Register a URL handler for poll posts
		register_entity_url_handler('polls_url','object','poll');
						
	// Register entity type
		register_entity_type('object','poll');
		
	// add group widget
	//add to group profile page
	// TODO: create these settings
		$group_polls = get_plugin_setting('group_polls', 'polls');
		if (!$group_polls || $group_polls != 'no') {
			$group_profile_display = get_plugin_setting('group_profile_display', 'polls');
			if (!$group_profile_display || $group_profile_display == 'right') {
				extend_view('groups/right_column', 'groups/grouppolls',1);
			} else if ($group_profile_display == 'left') {
				extend_view('groups/left_column', 'groups/grouppolls',1);
			}
		}
	
		if (!$group_polls || ($group_polls == 'yes_default')) {
			add_group_tool_option('polls',elgg_echo('polls:enable_polls'),true);
		} else if ($group_polls == 'yes_not_default') {
			add_group_tool_option('polls',elgg_echo('polls:enable_polls'),false);
		}
		
	//add widget
		add_widget_type('poll',elgg_echo('polls:my_widget_title'),elgg_echo('polls:my_widget_description'));
		add_widget_type('latestPolls',elgg_echo('polls:latest_widget_title'),elgg_echo('polls:latest_widget_description'));
		add_widget_type('poll_individual',elgg_echo('polls:individual'),elgg_echo('poll_individual_group:widget:description'));

}

function polls_pagesetup() {
	
	global $CONFIG;
	
	$page_owner = page_owner_entity();

	//add submenu options
		if (get_context() == "polls") {
			if ((page_owner() == $_SESSION['guid'] || !page_owner()) && isloggedin()) {
				add_submenu_item(elgg_echo('polls:your'),$CONFIG->wwwroot."pg/polls/list/" . $page_owner->username);
				add_submenu_item(elgg_echo('polls:friends'),$CONFIG->wwwroot."pg/polls/friends/" . $page_owner->username);
				add_submenu_item(elgg_echo('polls:everyone'),$CONFIG->wwwroot."pg/polls/all");
				add_submenu_item(elgg_echo('polls:addpost'),$CONFIG->wwwroot."pg/polls/add/" . $page_owner->username);
			} else if (page_owner()) {
				if ($page_owner instanceof ElggUser) { // Sorry groups, this isn't for you.
					add_submenu_item(sprintf(elgg_echo('polls:user'),$page_owner->name),$CONFIG->wwwroot."pg/polls/" . $page_owner->username);
					add_submenu_item(sprintf(elgg_echo('polls:user:friends'),$page_owner->name),$CONFIG->wwwroot."pg/polls/" . $page_owner->username . "/friends/");
				} else if ($page_owner instanceof ElggGroup) {
					if (polls_can_add_to_group($page_owner)) {
						add_submenu_item(elgg_echo('polls:addpost'),$CONFIG->wwwroot."pg/polls/add/" . $page_owner->username);
					}
					add_submenu_item(elgg_echo('polls:group_polls'), $CONFIG->wwwroot . "pg/polls/list/" . $page_owner->username);
				}
				add_submenu_item(elgg_echo('polls:everyone'),$CONFIG->wwwroot."pg/polls/all");
			} else {
				add_submenu_item(elgg_echo('polls:everyone'),$CONFIG->wwwroot."pg/polls/all");
			}
		}
	// Group submenu option	
	$page_owner = page_owner_entity();
	if ($page_owner instanceof ElggGroup 
		&& polls_activated_for_group($page_owner) 
		&& (get_context() == 'groups')) {
		add_submenu_item(elgg_echo('polls:group_polls'), $CONFIG->wwwroot . "pg/polls/list/" . $page_owner->username);
	}
	
}

/**
 * poll page handler; allows the use of fancy URLs
 *
 * @param array $page From the page_handler function
 * @return true|false Depending on success
 */
function polls_page_handler($page) {
	if (isset($page[0])) {
		switch($page[0]) {
			case "read":		set_input('pollpost',$page[2]);
								@include(dirname(__FILE__) . "/pages/read.php");
								break;
			case "all":			@include(dirname(__FILE__) . "/pages/everyone.php");
								break;
			case "add":			if (isset($page[1])) {
									set_input('username',$page[1]);
								}
								@include(dirname(__FILE__) . "/pages/add.php");
								break;
			case "edit":		set_input('pollpost',$page[1]);
								@include(dirname(__FILE__) . "/pages/edit.php");
								break;
			case "friends":		if (isset($page[1])) {
									set_input('username',$page[1]);
								}
								@include(dirname(__FILE__) . "/pages/friends.php");
								break;
			case "list":		set_input('username',$page[1]);
								@include(dirname(__FILE__) . "/pages/index.php");
		}
		return TRUE;
				
	} else {
		@include(dirname(__FILE__) . "/pages/index.php");
		return TRUE;
	}
	
	return FALSE;
	
}

/**
 * Populates the ->getUrl() method for poll objects
 *
 * @param ElggEntity $pollpost poll post entity
 * @return string poll post URL
 */
function polls_url($pollpost) {
	
	global $CONFIG;
	$title = $pollpost->title;
	$title = friendly_title($title);
	return $CONFIG->url . "pg/polls/read/" . $pollpost->getOwnerEntity()->username . "/" . $pollpost->getGUID() . "/" . $title;
	
}
	
// Make sure the poll initialisation function is called on initialisation
register_elgg_event_handler('init','system','polls_init');
register_elgg_event_handler('pagesetup','system','polls_pagesetup');

// Register actions
global $CONFIG;
register_action("polls/add",false,$CONFIG->pluginspath . "polls/actions/add.php");
register_action("polls/edit",false,$CONFIG->pluginspath . "polls/actions/edit.php");
register_action("polls/delete",false,$CONFIG->pluginspath . "polls/actions/delete.php");
register_action("polls/vote",false,$CONFIG->pluginspath . "polls/actions/vote.php");
		
?>