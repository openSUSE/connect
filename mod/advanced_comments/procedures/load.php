<?php 

	$guid = (int) get_input("guid");
	$comments_limit = (int) max(get_input("comments_limit", 10), 0);
	$comments_offset = (int) max(get_input("comments_offset", 0), 0);
	$order = get_input("comments_order", "desc");
	$auto_load = get_input("auto_load");
	$save_settings = get_input("save_settings");

	if(!in_array($order, array("asc", "desc"))){
		$order = "desc";
	}
	
	if(!in_array($auto_load, array("yes", "no"))){
		$auto_load = "no";
	}

	if($entity = get_entity($guid)){
		if($save_settings == "yes"){
			$setting_name = "comment_settings:" . $entity->getType() . ":" . $entity->getSubtype();
			$setting = $order . "|" . $comments_limit . "|" . $auto_load;
			
			if(!isset($_SESSION["advanced_comments"])){
				$_SESSION["advanced_comments"] = array();
			}
			
			$_SESSION["advanced_comments"][$setting_name] = $setting;
			
			if($user_guid = elgg_get_logged_in_user_guid()){
				elgg_set_plugin_user_setting($setting_name, $setting, $user_guid, "advanced_comments");
			}
		}
		
		$options = array(
			'guid' => $guid,
			'annotation_name' => 'generic_comment',
			'pagination' => false,
			'offset' => $comments_offset,
			'limit' => $comments_limit,
			'count' => true
		);
		if($save_settings !== "yes"){
			$options["list_class"] = 'advanced-comments-more-list';
		}
		
		$max_comments = elgg_get_annotations($options);
		$options["count"] = false;
				
		if($order == "desc"){
			$options["reverse_order_by"] = true;
		}
		
		echo elgg_list_annotations($options);
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
	}
