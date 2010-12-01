<?php

	/**
	 * Elgg default object view
	 * 
	 * @package Elgg
	 * @subpackage Core

	 * @author Curverider Ltd

	 * @link http://elgg.org/
	 */
?>
BEGIN:VEVENT
DTSTAMP:<?php echo date("Ymd\THis\Z", $vars['entity']->getTimeCreated());  ?>

DTSTART:<?php echo date("Ymd\THis\Z", $vars['entity']->start_date ); ?>

DTEND:<?php echo date("Ymd\THis\Z", $vars['entity']->end_date );  ?>

SUMMARY:<?php echo $vars['entity']->title; ?>

DESCRIPTION:<?php echo $vars['entity']->description; ?>

LAST-MODIFIED:<?php echo date("Ymd\THis\Z", $vars['entity']->getTimeUpdated());  ?>

CLASS:PUBLIC
END:VEVENT
