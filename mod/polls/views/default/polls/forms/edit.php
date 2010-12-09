<div class="contentWrapper">
<?php

/**
 * Elgg Poll plugin
 * 
 * @package Elggpoll
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg
 * @copyright John Mellberg 2009
 */
 
// Set title, form destination
if (isset($vars['entity'])) {
	$action = "polls/edit";
	$question = $vars['entity']->question;
	$description = $vars['entity']->description;
	$maxanswers = $vars['entity']->maxanswers;
	$tags = $vars['entity']->tags;
	$access_id = $vars['entity']->access_id;
} else  {
	$action = "polls/add";
	$question = "";
	$description = "";
	$maxanswers = 1;
	$tags = "";
	if (defined('ACCESS_DEFAULT')){
		$access_id = ACCESS_DEFAULT;
	}else{
		$access_id = ACCESS_PRIVATE;
	}
}

// Just in case we have some cached details
if (isset($vars['question'])) {
	$question = $vars['question'];
	$description = $vars['description'];
	$tags = $vars['polltags'];
	$maxanswers = $vars['maxanswers'];
}
?>

<?php
        $question_label = elgg_echo('polls:question');
        $question_textbox = elgg_view('input/text', array('internalname' => 'question', 'value' => $question));

        $description_label = elgg_echo('polls:description');
        $description_textbox = elgg_view('input/longtext', array('internalname' => 'description', 'value' => $description));

        $maxanswers_label = elgg_echo('polls:maxanswers'); 
        $maxanswers_textbox = elgg_view('input/pulldown', array('internalname' => 'maxanswers',
                'options_values' => array('1' => elgg_echo('polls:type:1'), '0' => elgg_echo('polls:type:0') ,'2' => elgg_echo('polls:type:2'), '3' => elgg_echo('polls:type:3'), '4' => elgg_echo('polls:type:4'), '5' => elgg_echo('polls:type:5') ),
                'value' => $maxanswers));

        $responses_label = elgg_echo('polls:responses');
        //$responses_textbox = elgg_view('input/text', array('internalname' => 'responses', 'value' => $responsestring));
        $responses_control = elgg_view('polls/input/choices',array('poll'=>$vars['entity']));

        $types_label = elgg_echo('polls:types');
        $types_control = elgg_view('polls/input/choices',array('poll'=>$vars['entity']));

        $tag_label = elgg_echo('tags');
        $tag_input = elgg_view('input/tags', array('internalname' => 'polltags', 'value' => $tags));
                
        $access_label = elgg_echo('access');
        $access_input = elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
                
        $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));
        $submit_input .= ' '.elgg_view('input/button', array('internalname' => 'cancel', 'internalid' => 'polls_edit_cancel', 'type'=> 'button', 'value' => elgg_echo('cancel')));

        if (isset($vars['entity'])) {
        	$entity_hidden = elgg_view('input/hidden', array('internalname' => 'pollpost', 'value' => $vars['entity']->getGUID()));
        } else {
        	$entity_hidden = '';
        }
        
        $entity_hidden .= elgg_view('input/hidden', array('internalname' => 'container_guid', 'value' => page_owner()));

        $form_body = <<<EOT
		<p>
			<label>$question_label</label><br />
                        $question_textbox
		</p>
		<p>
			<label>$description_label</label><br />
                        $description_textbox
		</p>
		<p>
			<label>$maxanswers_label</label><br />
			$maxanswers_textbox
		<p>
			<label>$responses_label</label><br />
                        $responses_control
		</p>
		<p>
			<label>$tag_label</label><br />
                        $tag_input
		</p>
		<p>
			<label>$access_label</label><br />
                        $access_input
		</p>
		<p>
			$entity_hidden
			$submit_input
		</p>
EOT;
      echo elgg_view('input/form', array('action' => "{$vars['url']}action/$action", 'body' => $form_body));
?>
</div>
<script type="text/javascript">
$('#polls_edit_cancel').click(
	function() {
		window.location.href="<?php echo $vars['url'].'pg/polls/list/'.(page_owner_entity()->username); ?>";
	}
);
</script>
