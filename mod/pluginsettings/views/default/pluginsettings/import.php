<div id="content_area_user_title">
	<h2><?php echo elgg_echo( 'pluginsettings:title:import' ); ?></h2>
</div>
<div class="contentWrapper">
	<p><?php echo elgg_echo( 'pluginsettings:import:warning' ); ?></p>
	<form id="changeusernameform" action="<?php echo $CONFIG->wwwroot; ?>action/pluginsettings/import" enctype="multipart/form-data" method="post">
	<?php 	
		$radio_gaga = array();
		$radio_gaga['options'] = array(elgg_echo( 'pluginsettings:label:fullimport' ) => 'full', elgg_echo( 'pluginsettings:label:core' ) => 'core', elgg_echo( 'pluginsettings:label:plugins' ) => 'plugins');
		$radio_gaga['internalname'] = 'type';
		$radio_gaga['value'] = 'plugins';
		$ts = time ();
		$token = generate_action_token ( $ts );
		echo elgg_view('input/hidden',array('internalname' => '__elgg_token', 'value' => $token));
		echo elgg_view('input/hidden',array('internalname' => '__elgg_ts', 'value' => $ts));
		echo elgg_view("input/radio", $radio_gaga);
		echo elgg_echo( 'pluginsettings:label:import' ); 
		echo elgg_view("input/file",array('internalname' => 'upload'));
		
	?>
	<input type='submit' value='Import' class='submit' />
	</form>
</div>