<p>
En fin...
<?php
echo elgg_view('input/text', array('internalname'=>'params[message]',
	'value'=> $vars['entity']->message,
	'class'=> 'hello-input-text' ) );
?>
</p>
