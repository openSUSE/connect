<?php

$icon = elgg_view(
	"graphics/icon", array(
		"entity" => $vars['entity'],
		'size' =>  'small'
	)
);


elgg_view_listing($icon);
?>