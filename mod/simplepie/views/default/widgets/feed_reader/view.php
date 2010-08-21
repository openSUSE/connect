<div class="contentWrapper">
<?php
global $CONFIG;

if (!class_exists('SimplePie')) {
	require_once $CONFIG->pluginspath . '/simplepie/simplepie.inc';
}

$allow_tags = '<a><p><br><b><i><em><del><pre><strong><ul><ol><li>';
$feed_url = $vars['entity']->feed_url;
if ($feed_url) {

	// get widget settings
	$excerpt   = $vars['entity']->excerpt;
	$num_items = $vars['entity']->num_items;
	$post_date = $vars['entity']->post_date;
	
	$cache_location = $CONFIG->dataroot . '/simplepie_cache/';
	if (!file_exists($cache_location)) {
		mkdir($cache_location, 0777);
	}
	
	$feed = new SimplePie($feed_url, $cache_location);
	
	// doubles timeout if going through a proxy
	//$feed->set_timeout(20);
	
	$num_posts_in_feed = $feed->get_item_quantity();
	
	// only display errors to profile owner
	if (get_loggedin_userid() == page_owner()) {
		if (!$num_posts_in_feed) {
			echo '<p>' . elgg_echo('simplepie:notfind') . '</p>';
		}
	}
?>
<div class="simplepie_blog_title">
	<h2><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a></h2>
</div>
<?php
	// don't display more feed items than user requested
	if ($num_items > $num_posts_in_feed) {
		$num_items = $num_posts_in_feed;
	}

	foreach ($feed->get_items(0, $num_items) as $item):
?>
	<div class="simplepie_item">
		<div class="simplepie_title">
			<h4><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h4>
		</div>
<?php 
		if ($excerpt) {
?>
			<div class="simplepie_excerpt">
				<?php echo strip_tags($item->get_description(true), $allow_tags); ?>
			</div>
<?php
		}

		if ($post_date) {
?>
		<div class="simplepie_date">
			<?php echo elgg_echo('simplepie:postedon'); ?> 
			<?php echo $item->get_date('j F Y | g:i a'); ?>
		</div>
<?php 
		} 
?>
	</div>

	<?php endforeach; ?>

<?php 
} else {
	// display message only to owner
	if (get_loggedin_userid() == page_owner()) {        
		echo '<p>' . elgg_echo('simplepie:notset') . '</p>';
	}
}
?>
</div>
