<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);

$id = '';
if (isset($vars['id'])) {
	$id = "id =\"{$vars['id']}\"";
}

$class = 'elgg-comments';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

$comments_offset = (int) max(get_input('annoff', 0), 0);

// set options for advanced comments
$comments_order = "desc";
$comments_limit = 10;
$auto_load = "no";

if(isset($_SESSION["advanced_comments"]) && isset($_SESSION["advanced_comments"][$setting_name])){
	list($comments_order, $comments_limit, $auto_load) = explode("|", $_SESSION["advanced_comments"][$setting_name]);
} elseif($user_guid = elgg_get_logged_in_user_guid()){
	// save settings per type / subtype
	$setting_name = "comment_settings:" . $vars["entity"]->getType() . ":" . $vars["entity"]->getSubtype();

	if($setting = elgg_get_plugin_user_setting($setting_name, $user_guid, "advanced_comments")){
		list($comments_order, $comments_limit, $auto_load) = explode("|", $setting);

		// following is for use in load action
		if(!isset($_SESSION["advanced_comments"])){
			$_SESSION["advanced_comments"] = array();
		}

		$_SESSION["advanced_comments"][$setting_name] = $setting;
	}
}

$vars["advanced_comments_order"] = $comments_order;
$vars["advanced_comments_limit"] = $comments_limit;
$vars["advanced_comments_auto_load"] = $auto_load;

// work around for deprecation code in elgg_view()
unset($vars['internalid']);

echo "<div $id class=\"$class\">";

if ($show_add_form) {
	$form_vars = array('name' => 'elgg_add_comment');
	echo elgg_view_form('comments/add', $form_vars, $vars);
}

$options = array(
	'guid' => $vars['entity']->getGUID(),
	'annotation_name' => 'generic_comment',
	'pagination' => false,
	'count' => true
);

$max_comments = elgg_get_annotations($options);

$options["count"] = false;

if(!empty($comments_limit)){
	$options["limit"] = $comments_limit;
}

if($comments_order == "desc"){
	$options["reverse_order_by"] = true;
}

$html = elgg_list_annotations($options);
if ($html) {
	echo '<h3>' . elgg_echo('comments') . '</h3>';
	echo elgg_view("advanced_comments/header", $vars);
	echo "<div id='advanced-comments-container'>";
	echo $html;
	
	if(($comments_offset + $comments_limit) < $max_comments){
		?>
		
		<div title="<?php echo $max_comments - $comments_offset - $comments_limit . " " . elgg_echo("more"); ?>" id="advanced-comments-more">
			<span><?php echo elgg_echo("more"); ?> ...</span>
			<?php echo elgg_view("graphics/ajax_loader", array("hidden" => true)); ?>
			<input type="hidden" id="comments_offset" value="<?php echo $comments_offset + $comments_limit; ?>" />
			<script type="text/javascript">
				<?php 
					if($auto_load == "yes"){
						echo "advanced_comments_bind_auto_load();";
					} else {
						echo "advanced_comments_unbind_auto_load();";
					}
				?>
			</script>
		</div>
		<?php 
	}
	echo "</div>";
}

echo '</div>';
