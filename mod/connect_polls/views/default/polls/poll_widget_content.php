<!-- display the actual poll post -->
<?php

if($vars['msg']) {
	echo '<p>'.$vars['msg'].'</p>';
}

$user_guid = get_loggedin_userid();
$isPollOwner = ($vars['entity']->getOwnerEntity()->guid == $user_guid);
$priorVote = polls_check_for_previous_vote($vars['entity'], $user_guid);

//if user has voted, show the results
if ($priorVote) {
	$results_display = "block";
	$poll_display = "none";
	$show_text = elgg_echo('polls:show_poll');
} else {
	$results_display = "none";
	$poll_display = "block";
	$show_text = elgg_echo('polls:show_results');
}
?>
<h2><?php echo $vars['entity']->question; ?></h2><br />
<div id="resultsDiv" class="poll_post_body" style="display:<?php echo $results_display ?>;">
<?php if ($priorVote) {echo '<p>'.elgg_echo("polls:voted").'</p>';}?>
<?php echo elgg_view('polls/results_for_widget', array('entity' => $vars['entity'])); ?>
</div>
<?php echo elgg_view('polls/forms/vote', array('entity' => $vars['entity'],'callback'=>1,'form_display'=>$poll_display));
	
if (!$priorVote) {			
?>
	<!-- show display toggle -->
	<p align="center"><a id="poll_show_link" onclick="javascript:toggleResults();" style="cursor:hand;"><?php echo $show_text; ?></a></p>
<?php } ?>