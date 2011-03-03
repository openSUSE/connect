<div id="content_area_user_title">
	<h2><?php echo elgg_echo( 'pluginsettings:title:export' ); ?></h2>
</div>
<div class="contentWrapper">
	<form id="changeusernameform" action="<?php echo $CONFIG->wwwroot; ?>action/pluginsettings/export" method="post">
	
	<?php 
		echo elgg_echo( 'pluginsettings:label:export' ); 
		$ts = time ();
		$token = generate_action_token ( $ts );
		echo elgg_view('input/hidden',array('internalname' => '__elgg_token', 'value' => $token));
		echo elgg_view('input/hidden',array('internalname' => '__elgg_ts', 'value' => $ts));
	?>
	<input type='submit' value='Export' class='submit' />
	
	</form>
</div>