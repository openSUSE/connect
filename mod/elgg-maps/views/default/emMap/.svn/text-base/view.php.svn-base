<?php
/*
 * views/default/object/map.php
 * Vista predeterminada para un listado de objetos mapa
 */
/*
 * Preparo el ícono que va a acompañar a cada tílo del mapa
 * en el listado rendereando la view de icon
 */

$owner = $vars['entity']->getOwnerEntity();
$friendlytime = elgg_view_friendly_time($vars['entity']->time_updated);
$icon = elgg_view(
	"graphics/icon", array(
		"entity" => $vars['entity'],
		'size' =>  'medium'
	)
);

/*
 * El título con enlace al objeto mapa.
 * TODO: Podria ser algún recorte del mapa
 */
if ( $vars['entity']->canEdit() ) {
	$info = "<div style='text-align:right'><button id='emMapEditButton' class='ui-button'>Modificar el mapa</button></div>";
} else {
	$info = '';
}
$info .= "<h2 class='emMapTitle'><a href=\"" . ELGG_MAPS_WEBPATH . '?map=' . $vars['entity']->getGUID() . "\">". $vars['entity']->title . "</a></h2>";
$info .= "<p class='emMapDescription'>".$vars['entity']->description."</p>";
$info .= "<p class='emMapTags'>".elgg_view('output/tags', array('tags' => $vars['entity']->tags))."</p>";
$info .= "<p class='emCreatedBy'>Autor: <a href=\"{$owner->getURL()}\">{$owner->name}</a></p>";
$info .= "<p class='emCreatedOn'>Modificado {$friendlytime}</p>";
?>
<div class="mapExcerpt">
<?=$info?>
</div>