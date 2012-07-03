<?php

	/**
	 * Tidypics image view
	 * 
	 * Display a view of a single image
	 */

	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";

	// if this page belongs to a closed group, prevent anyone outside group from seeing
	if (is_callable('group_gatekeeper')) group_gatekeeper();

	// get the album entity
	$photo_guid = (int) get_input('guid');
	$photo = get_entity($photo_guid);

	// panic if we can't get it
	if (!$photo) forward();

	// set page owner based on owner of photo album
	set_page_owner($photo->owner_guid);
	$album = get_entity($photo->container_guid);
	if ($album) {
		$owner_guid = $album->container_guid;
		if ($owner_guid)
			set_page_owner($owner_guid);
	}

	
	$page_owner = page_owner_entity();
	if ($page_owner instanceof ElggGroup) {
		add_submenu_item(	sprintf(elgg_echo('album:group'),$page_owner->name), 
							$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username);
	}

	if (can_write_to_container(0, $album->container_guid)) {
		add_submenu_item(	elgg_echo('image:edit'),
							$CONFIG->wwwroot . 'pg/photos/edit/' . $photo_guid,
							'photos');
		$ts = time();
		$token = generate_action_token($ts);
		add_submenu_item(	elgg_echo('image:delete'),
							$CONFIG->wwwroot . 'action/tidypics/delete?guid=' . $photo_guid . '&amp;__elgg_token=' . $token . '&amp;__elgg_ts=' . $ts,
							'photos',
							true);
	}

	
	$title = $photo->title;
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity($photo, true);

	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	page_draw($title, $body);
?>