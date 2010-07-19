<?php
	/**
	 * Simple gravatar integration for Elgg.
	 * Scratching an itch! (+ a good example of icon overloading)
	 * 
	 * TODO: 
	 * 1) Fallback to elgg default icons instead of gravatar one for missing images
	 * 2) Have sizes better handle changes in defaults for theming
	 * 
	 * @package ElggGravatar
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	/**
	 * Init.
	 *
	 */
	function gravatar_init()
	{
		// Now override icons. Note priority: This sits somewhere between the profile user icons and default icons - 
			// so if you specify an icon for a user it will use that, else it will try a gravatar icon.
		register_plugin_hook('entity:icon:url', 'user', 'gravatar_usericon_hook', 900); 
	}
	
	/**
	 * This hooks into the getIcon API and returns a gravatar icon where possible
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $entity_type
	 * @param unknown_type $returnvalue
	 * @param unknown_type $params
	 * @return unknown
	 */
	function gravatar_usericon_hook($hook, $entity_type, $returnvalue, $params)
	{
		global $CONFIG;
		
		// Size lookup. TODO: Do this better to allow for changed themes.
		$size_lookup = array(
			'master' => '200',
			'large' => '200',
			'topbar' => '16',
			'tiny' => '25',
			'small' => '40',
			'medium' => '100'
		);
		
		if ((!$returnvalue) && ($hook == 'entity:icon:url') && ($params['entity'] instanceof ElggUser))
		{
			$size = 40;
			if (isset($size_lookup[$params['size']]))
				$size = $size_lookup[$params['size']];
				
			return "http://www.gravatar.com/avatar/".md5($params['entity']->email) . ".jpg?s=$size";
			
		}
	}
	
	
	// Initialise plugin
	register_elgg_event_handler('init','system','gravatar_init');
?>