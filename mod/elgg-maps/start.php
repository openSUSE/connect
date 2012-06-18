<?php

function maps_init()
{
	global $CONFIG;
	
	//if (isset($CONFIG->views->extensions['emMap/metatags'])) die('not');
	
	//definicion del path para no tener que depender del nombre del folder
	//pinga loca y a partir de ahora a usar estas constants
	$elggMapsFolder = basename(dirname(__FILE__));
	define('ELGG_MAPS_WEBPATH',$CONFIG->url."mod/".$elggMapsFolder."/");
	define('ELGG_MAPS_SYSTEMPATH',$CONFIG->pluginspath.$elggMapsFolder."/");
	define('ELGG_MAPS_URL',$CONFIG->url."pg/".$elggMapsFolder."/");
	
	//no anda
	elgg_extend_view('css','emMap/css');

	register_entity_type('object','emMap');
	//register_entity_type('object','emLayer');
	
	register_page_handler('elgg-maps','maps_page_handler');
	register_entity_url_handler('maps_url', 'object', 'emMap');
	register_entity_url_handler('layers_url', 'object', 'emLayer');

	register_action("elggmaps/map/save", false, ELGG_MAPS_SYSTEMPATH . "actions/savemap.php");
	register_action("elggmaps/map/edit", false, ELGG_MAPS_SYSTEMPATH . "actions/editmap.php");
	register_action("elggmaps/map/delete", false, ELGG_MAPS_SYSTEMPATH .  "actions/deletemap.php");
	//not yet
	//register_action("elggmaps/layer/save", false, ELGG_MAPS_SYSTEMPATH .  "actions/savelayer.php");
	//register_action("elggmaps/layer/delete", false, ELGG_MAPS_SYSTEMPATH .  "actions/deletelayer.php");
	//register_action("elggmaps/feature/save", false, ELGG_MAPS_SYSTEMPATH .  "actions/savefeature.php");
	//register_action("elggmaps/feature/delete", false, ELGG_MAPS_SYSTEMPATH .  "actions/deletefeature.php");
	//register_action("maps/wmsserver/delete", false, $CONFIG->pluginspath .  "maps/actions/deletewmsserver.php");
	//register_action("elggmaps/wmsserver/save", false, ELGG_MAPS_SYSTEMPATH .  "actions/savewmsserver.php");
	//add_widget_type('maps', elgg_echo('maps:widget_name'), 'El widget de mapas');
	
	if ('yes' == get_plugin_setting('usemapfrontpage', 'elgg-maps') && isloggedin()) {
		register_plugin_hook('index','system','new_index');
		//die('hola');
	}
}

function maps_pagesetup()
{
	global $CONFIG;
	
	//register_entity_type('object','map');
	
	//if (isadminloggedin()) {
		add_menu(elgg_echo('maps:plugin_name'), ELGG_MAPS_URL.'all');
	//}

	$context = get_context();
	/*
	 * Show the submenu link to all the visible maps in the site
	 */
	if ('elgg-maps' == $context) {
		if (isloggedin()) {
			add_submenu_item(elgg_echo('maps:new_map'), ELGG_MAPS_URL.'add','mapactions');
			add_submenu_item(elgg_echo('maps:your_maps'), ELGG_MAPS_URL.'owned', 'maplinks');
		}
		add_submenu_item(elgg_echo('maps:all_wmsservers'), ELGG_MAPS_URL.'wmsserver/all', 'wmsserverlinks');
		add_submenu_item(elgg_echo('maps:all_site_maps'), ELGG_MAPS_URL.'all','maplinks');
	}
}


function maps_page_handler($page)
{
	global $CONFIG;
	if (!isset($page[0])) {
		$page[0] =  'index';
	}
	switch($page[0]) {
		case "index":
			//include(ELGG_MAPS_SYSTEMPATH."pages/index.php");
			break;
		case "all":
			include(ELGG_MAPS_SYSTEMPATH."pages/all.php");
			break;
		case "owned":
			include(ELGG_MAPS_SYSTEMPATH."pages/owned.php");
			break;
		case "add":
			//no anda el remove, esto es cada vez mas choto
			//remove_submenu_item(elgg_echo('maps:add'),'mapactions');
			include(ELGG_MAPS_SYSTEMPATH."pages/add.php");
			break;
		case "view":
			$entity = get_entity($page[1]);
			if($entity->subtype != get_subtype_id('object','emMap'))
			{
				system_message('Could not locate specified map');
				forward($CONFIG->url);
			}
			//echo "<pre>".print_r($entity->subtype, true)."</pre>";
			if ( $entity && $entity->canEdit() ) {
				add_submenu_item(elgg_echo('maps:edit_map'), ELGG_MAPS_URL . "edit/{$page[1]}", 'mapactions');
				$link = $CONFIG->url . "action/elggmaps/map/delete/?mapGUID={$page[1]}";
				$actionLink = elgg_add_action_tokens_to_url($link);
				add_submenu_item(elgg_echo('maps:delete_map'),
					$actionLink,
					'mapactions',
					addslashes(elgg_echo('question:areyousure'))
				);
			}
			include(ELGG_MAPS_SYSTEMPATH . "pages/view.php");
			break;
		case "edit":
			$entity = get_entity($page[1]);
			if($entity->subtype != get_subtype_id('object','emMap'))
			{
				system_message('Could not locate specified map');
				forward($CONFIG->url);
			}
			add_submenu_item(elgg_echo('cancel'), ELGG_MAPS_URL . "view/{$page[1]}", 'mapactions');
			include(ELGG_MAPS_SYSTEMPATH . "pages/edit.php");
			break;
		case "wmsserver":
			if (!isset($page[1])) {
				$page[1] = 'all';
			}
			switch ($page[1]) {
				case "all" :
					include(ELGG_MAPS_SYSTEMPATH."pages/wmsserverall.php");
					break;
				case "add":
					include(ELGG_MAPS_SYSTEMPATH."pages/addwmsserver.php");
					break;
			}
			break;
		case "viewlayer":
			$entity = get_entity($page[1]);
			//aca faltaria un check para el subtype!!!!!!!!!!!!!
			include(ELGG_MAPS_SYSTEMPATH . "pages/viewlayer.php");
			break;			
		default:
			return false;
	}
}

function maps_url($entity) {
	global $CONFIG;
	$title = elgg_get_friendly_title($entity->title);
	return ELGG_MAPS_URL . "view/{$entity->guid}/$title";
}

function layers_url($entity) {
	global $CONFIG;
	$title = elgg_get_friendly_title($entity->title);
	return ELGG_MAPS_URL . "viewlayer/{$entity->guid}";
}

function new_index() {
    if (!include_once(ELGG_MAPS_SYSTEMPATH . "pages/index.php"))
        return false;

    return true;
}

//////////////////////////////////////////////////
//check obsolescence
/*
wrapper para meter una var en un key de session
para mantener ordenado siempre van dentro de
SESSION['elggMapsVars']
ergo storeVars('miVar',$varValue)
termina en SESSION['elggMapsVars']['miVar']
*/
function storeVars($sessionKey,$varArray = array())
{
	$_SESSION['elggMapsVars'][$sessionKey] = $varArray;
}
/*
getter de la anterior
*/
function restoreVars($sessionKey)
{
	$v = $_SESSION['elggMapsVars'][$sessionKey];
	unset($_SESSION['elggMapsVars'][$sessionKey]);
	return $v;
}
////////////////////////////////////////////////////

function elgg_maps_load_scripts() {
  global $CONFIG;
  if (!(isset($CONFIG->views) && isset($CONFIG->views->extensions)
        && isset($CONFIG->views->extensions['emMap/metatags']))) {
    elgg_extend_view('metatags', 'emMap/metatags');
  } else echo "Hola";
}

function elggmaps_page_draw($title, $body, $sidebar = "", $helpbar = "", $extraVars = array())
{
	global $entity;
	// get messages - try for errors first
	$sysmessages = system_messages(null, "errors");
	if (count($sysmessages["errors"]) == 0) {
		// no errors so grab rest of messages
		$sysmessages = system_messages(null, "");
	} else {
		// we have errors - clear out remaining messages
		system_messages(null, "");
	}
	
	$pageVars = array(
		'title' => $title,
		'body' => $body,
		'sidebar' => $sidebar,
		'helpbar' => $helpbar,
		'sysmessages' => $sysmessages
	);
	
	if(is_array($extraVars)) $pageVars = array_merge($pageVars,$extraVars);
	// Draw the page
	$output = elgg_view('emMap/layoutMax/pageshell', $pageVars);
	
	$split_output = str_split($output, 1024);

	foreach($split_output as $chunk) {
		echo $chunk;
	}
}


register_elgg_event_handler('init' ,'system', 'maps_init');
register_elgg_event_handler('pagesetup' ,'system', 'maps_pagesetup');


?>
