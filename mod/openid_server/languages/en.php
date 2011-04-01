<?php

	$english = array(	
		'item:user:openid'				=> "OpenID users",
		'openid_server:trust_title'                     => "Trust",	
		'openid_server:trust_question'                  => "Do you wish to confirm your OpenID (<code>%s</code>) with <code>%s</code>?",
		'openid_server:remember_trust'                  => "Remember this decision",
		'openid_server:confirm_trust'                   => "Yes",
		'openid_server:reject_trust'                    => "No",
		'openid_server:not_logged_in'                   => "You must be logged-in to approve this request. Please login now.",
		'openid_server:loggedin_as_wrong_user'          => "You must be logged-in as %s to approve this request."
		    ." You are currently logged-in as %s instead.",
		'openid_server:trust_root'                      => "Trust root",
		'openid_server:trust_site'                      => "Trust site",
		'openid_server:autologin_url'                   => "Auto-login URL:",
		'openid_server:autologout_url'                  => "Auto-logout URL:",
		'openid_server:iframe_width'                    => "Iframe width (in pixels)",
		'openid_server:iframe_height'                   => "Iframe height (in pixels)",
		'openid_server:change_button'                   => "Change",
		'openid_server:add_button'                      => "Add",
		'openid_server:admin_explanation'               => "You can use this page to set default trust roots for your OpenID server."
		    ." These are OpenID client applications that are automatically trusted by people using OpenIDs provided by your server and are"
		    ." useful only if you are using OpenID to integrate a federation of trusted applications. (You need do nothing here if you have no"
		    ." trusted applications.) You can also set autologin and autologout URLs for some or all of your trusted applications if you"
		    ." want your users to be automatically logged in or logged out of these applications when they login and logout of your"
		    ." OpenID server. Normally the autologin and autologout takes place in invisible iframes. If you are debugging this and want"
		    ." the iframes to be visible, you can set the width and height below.",
		'openid_server:trust_root_updated'              => "Trust root updated",
		'openid_server:trust_root_added'                => "Trust root added",
		'openid_server:trust_root_deleted'              => "Trust root deleted",
		'openid_server:edit_trust_root_title'           => "Edit trust record",
		'openid_server:manage_trust_root_title'         => "Manage default trust roots",
		'openid_server:trust_root_title'                => "Default trust roots",
		'openid_server:edit_option'                     => "Edit",
		'openid_server:delete_option'                   => "Delete",
		'openid_server:add_trust_root_title'            => "Add default trust root",
		'openid_server:autologin_title'                 => "Logging in",
		'openid_server:autologin_body'                  => "Logging in ... please wait",
		'openid_server:autologout_title'                => "Logging out",
		'openid_server:autologout_body'                 => "Logging out ... please wait",
		'item:object:openid_server::trusted_root'	=> "Openid trusted sites",
	    
	);
					
	add_translation("en",$english);

?>
