<?php

if (empty($vars['entity'])) {
  $vars['entity'] = $vars['user'];
}
// Avoid recursing, since we use the user's view for the map html
if (!isset($vars['entity']->_gmap)) {
  if ($vars['entity'] instanceof ElggUser) {
    if (!empty($vars['entity']->location)) {
      $vars['entity']->_gmap = true;
      $html = elgg_view_entity($vars['entity']);
      unset($vars['entity']->_gmap);
      echo gmap_marker(implode(' ', $vars['entity']->location),
                       array('html'=>$html,
                             'origin'=>"div.usericon > a.icon[href$={$vars['entity']->name}]",
                             'type'=>'user'));
    }
  }
}
?>