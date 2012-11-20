<?php

    /**
	 * Elgg comments add form
	 * 
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity']
	 */

	 global $tinymce_js_loaded;
	 
	 
	 if (isset($vars['entity']) && isloggedin()) {
    	//Icon Profile
    	$form_body .= "<div class=\"contentWrapper\">";
    	$form_body .= "<div class=\"comment_inline\">"; 
	 	$form_body .=  elgg_view("profile/icon",
    						array(
    							'entity' => $owner, 
    							'size' => 'small'));		 
	 	 
		 $form_body .= "<p class='longtext_editarea'><label>".elgg_echo("generic_comments:text")."<br />" . elgg_view('input/longtext',array('internalname' => 'generic_comment', 'value' => elgg_echo('comment_inline:writecomment'))) . "</label></p>";
    	 
		 if (!isset($tinymce_js_loaded)) $tinymce_js_loaded = false;
	 	 $no_mce = (!$tinymce_js_loaded) ? ' no_mce' : '';
		 
    	 $form_body .= "<p>" . elgg_view('input/hidden', array('internalname' => 'entity_guid', 'value' => $vars['entity']->getGUID()));
		 $form_body .= "<div class='clearfloat'></div>";
		 $form_body .= "<div class='$no_mce'>";
    	 $form_body .= elgg_view('input/submit', array('value' => elgg_echo("save"))) . "</p>";
    	 $form_body .= "</div></div>";
    	 
    	 $form_body .= "<div class='clearfloat'></div>";
    	 $form_body .= "</div>";

		 
		 
		 echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$vars['url']}action/comments/add"));

    }
    
?>