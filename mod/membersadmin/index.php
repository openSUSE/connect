<?php
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

  admin_gatekeeper();
  set_context('admin');

  $limit = get_input('limit', 10);
  $offset = get_input('offset', 0);

  set_page_owner($_SESSION['guid']);

  $title = elgg_view_title(elgg_echo('membersadmin'));

  $body .= elgg_view('membersadmin/list');

  page_draw(elgg_echo('memberstest'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));
?>
