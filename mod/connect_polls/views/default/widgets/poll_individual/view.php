<?php
/**
 * Individual poll view
 *
 * @package Elggpoll_extended
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg <big_lizard_clyde@hotmail.com>
 * @copyright John Mellberg - 2009
 *
 */

$polls = get_entities('object','poll',0,'',1,0,false,0,page_owner());

if(!empty($polls)){
  $body = elgg_view('polls/poll_widget',array('entity'=>$polls[0]));
}
else{
  $body = sprintf(elgg_echo('polls:widget:no_polls'),page_owner_entity()->name);
}

echo '<div class="contentWrapper">'.$body.'</div>';

?>
