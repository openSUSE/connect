<?php
  /*
   * add.php
  * Map add Page (For html frontend). Shows a form and submits to add action
   */
/* Include Elgg Engine */
include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

  /*
   * We require a logged in user for this form
   */
gatekeeper();
//set the page owner, you know, for the facha
set_page_owner(get_loggedin_userid());
  /*
   * The title for this page (shown in the body with title template and in the <title> label)
  */
$title = elgg_echo('maps:plugin_name');

$maincontent = elgg_view_title($entity->title).elgg_view('emMap/mapview',array('mapObject'=>$entity));
$maincontent .= elgg_view("emMap/edit_form",array('mapData'=>$entity));

$leftcontent = "";
$leftcontent .= elgg_view_title(elgg_echo('maps:edit_map').": ".$entity->title);
$leftcontent .= elgg_view('emMap/toolBar');

$body = elgg_view_layout('two_column_left_sidebar', $leftcontent,  $maincontent);

page_draw(elgg_echo('maps:edit'). ": $entity->title", $body);

?>


