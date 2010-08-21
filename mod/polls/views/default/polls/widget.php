<?php
	/**
	 * Elgg Poll plugin
	 * @package Elggpoll
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @Original author John Mellberg
	 * website http://www.syslogicinc.com
	 * @Modified By Team Webgalli to work with ElggV1.5
	 * www.webgalli.com or www.m4medicine.com
	 */
	 
	
		$owner = $vars['entity']->getOwnerEntity();
		$friendlytime = friendly_time($vars['entity']->time_created);
		$responses = $vars['entity']->countAnnotations('vote');
		//
		$icon = elgg_view(
						"profile/icon", array(
										'entity' => $owner,
										'size' => 'medium',
									  		)
						);
		$info = "<a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->question}</a><br>";
		$info .= "{$responses} responses<br>";
		$info .= "<p class=\"owner_timestamp\"><a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}</p>";
		echo elgg_view_listing($icon,$info);//elgg_view_listing($icon,$info); elgg_echo($info);
?>