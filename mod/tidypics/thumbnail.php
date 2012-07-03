<?php

	/**
	 * Tidypics Thumbnail
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	// Get file GUID
	$file_guid = (int) get_input('file_guid');
	
	// Get file thumbnail size
	$size = get_input('size');
	// only 3 possibilities
	if ($size != 'small' && $size != 'thumb') {
		$size = 'large';
	}
	
	$error_image = '';
	switch ($size) {
		case 'thumb':
			$error_image = "image_error_thumb.png";
			break;
		case 'small':
			$error_image = "image_error_small.png";
			break;
		case 'large':
			$error_image = "image_error_large.png";
			break;
	}
	
	// Get file entity
	$file = get_entity($file_guid);
	if (!$file)
		forward('mod/tidypics/graphics/' . $error_image);
	
	if ($file->getSubtype() != "image")
		forward('mod/tidypics/graphics/' . $error_image);
	
	// Get filename
	if ($size == "thumb") {
		$thumbfile = $file->thumbnail;
	} else if ($size == "small") {
		$thumbfile = $file->smallthumb;
	} else {
		$thumbfile = $file->largethumb;
	}
	
	if (!$thumbfile)
		forward('mod/tidypics/graphics/' . $error_image);
	
	// create Elgg File object
	$readfile = new ElggFile();
	$readfile->owner_guid = $file->owner_guid;
	$readfile->setFilename($thumbfile);
	$contents = $readfile->grabFile();

	// send error image if file could not be read
	if (!$contents) {
		forward('mod/tidypics/graphics/' . $error_image);
	}
	
	// expires every 14 days
	$expires = 14 * 60*60*24;

	// overwrite header caused by php session code so images can be cached
	$mime = $file->getMimeType();
	header("Content-Type: $mime");
	header("Content-Length: " . strlen($contents));
	header("Cache-Control: public", true);
	header("Pragma: public", true);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);
	
	// Return the thumbnail and exit
	echo $contents;
	exit;
?>
