<?php
/**
 * An Elgg 1.x compatible store implementation 
 */
 
 /**
 * Require base class for creating a new interface.
 */
 
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
 
require_once 'Auth/OpenID.php';
require_once 'Auth/OpenID/Interface.php';
require_once 'Auth/OpenID/Consumer.php';
try {
                include_once "Auth/OpenID/HMACSHA1.php";
} catch(Exception $e) {
		// new way :P
                require_once "Auth/OpenID/HMAC.php";
}
require_once 'Auth/OpenID/Nonce.php';
require_once 'Auth/OpenID/SReg.php';

define('header_connection_close', 'Connection: close');

function openid_server_delete_entity($entity)
{
    global $CONFIG;

    $entity->clearMetadata();
    $entity->clearAnnotations();
    $guid = $entity->getGUID();
        delete_data("DELETE from {$CONFIG->dbprefix}entities where guid={$guid}");
}



function openid_server_delete_entities($type = "", $subtype = "", $owner_guid = 0)
        {
                $entities = get_entities($type, $subtype, $owner_guid, "time_created desc", 0);

                foreach ($entities as $entity) {
                        openid_server_delete_entity($entity);
                }

                return true;
        }



class OpenIDServer_ElggStore extends Auth_OpenID_OpenIDStore {

    function resetAssociations () {
        openid_server_delete_entities('object', 'openid_client::association');
    }
    function resetNonces () {
        openid_server_delete_entities('object', 'openid_client::nonce');
    }
    function getAssociation ($server_url, $handle = null) {
        if (isset($handle)) {
            $meta_array = array(
                        'server_url'    => $server_url,
                        'handle'        => $handle
            );
            $assocs = get_entities_from_metadata_multi($meta_array, 'object', 'openid_client::association');
        } else {
            $assocs = get_entities_from_metadata('server_url', $server_url, 'object','openid_client::association');
        }
        
        if (!$assocs || (count($assocs) == 0)) {
            error_log("in getAssociations - cannot get associations for server url: $server_url, handle: $handle");
            return null;
        } else {
            $associations = array();

            foreach ($assocs as $assoc_row) {
                $assoc = new Auth_OpenID_Association($assoc_row->handle,
                                                     base64_decode($assoc_row->secret),
                                                     $assoc_row->issued,
                                                     $assoc_row->lifetime,
                                                     $assoc_row->assoc_type);

                if ($assoc->getExpiresIn() == 0) {
                    OpenIDServer_ElggStore::removeAssociation($server_url, $assoc->handle);
                } else {
                    $associations[] = array($assoc->issued, $assoc);
                }
            }

            if ($associations) {
                $issued = array();
                $assocs = array();
                foreach ($associations as $key => $assoc) {
                    $issued[$key] = $assoc[0];
                    $assocs[$key] = $assoc[1];
                }

                array_multisort($issued, SORT_DESC, $assocs, SORT_DESC,
                                $associations);

                // return the most recently issued one.
                list($issued, $assoc) = $associations[0];
                return $assoc;
            } else {
                return null;
            }
        }
    }
    
    function removeAssociation ($server_url, $handle) {
        if (isset($handle)) {
            $meta_array = array(
                        'server_url'    => $server_url,
                        'handle'        => $handle
            );
            $entities = get_entities_from_metadata_multi($meta_array, 'object', 'openid_client::association');
        } else {
            $entities = get_entities_from_metadata('server_url', $server_url, 'object','openid_client::association');
        }
        if ($entities) {
            foreach ($entities as $entity) {
    			openid_server_delete_entity($entity);
    		}
		}
	}
    function reset () {
        OpenIDServer_ElggStore::resetAssociations ();
        OpenIDServer_ElggStore::resetNonces ();
    }
        
    function storeAssociation ($server_url, $association) {
        
        // Initialise a new ElggObject
		$association_obj = new ElggObject();
		
		$association_obj->subtype = 'openid_client::association';
		$association_obj->owner_guid = 0;
		$association_obj->access_id = 2;
		$association_obj->title = 'association';
		
		error_log("in storeAssociation, attempting to save association with new handle: ".$association->handle);
		
		if ($association_obj->save()) {		
    		$association_obj->server_url = $server_url;
    		$association_obj->handle = $association->handle;
            $association_obj->secret = base64_encode($association->secret);
            $association_obj->issued = $association->issued;
            $association_obj->lifetime = $association->lifetime;
            $association_obj->assoc_type = $association->assoc_type;
            error_log("in storeAssociation, saved association with new handle: ".$association->handle);
    		return true;
		} else {
    		return false;
		}
	}
		
    function useNonce ( $server_url,  $timestamp,  $salt) {
        global $Auth_OpenID_SKEW;

        if ( abs($timestamp - time()) > $Auth_OpenID_SKEW ) {
            return false;
        }
        
        // check to see if the nonce already exists
        
        $meta_array = array(
                        'server_url'    => $server_url,
                        'timestamp'     => $timestamp,
                        'salt'          => $salt
        );
        
        $entities = get_entities_from_metadata_multi($meta_array, 'object', 'openid_client::nonce');
        
        if ($entities) {
            // bad - this nonce is already in use
            return false;
        } else {        
            // Initialise a new ElggObject
    		$nonce_obj = new ElggObject();
    		
    		$nonce_obj->subtype = 'openid_client::nonce';
    		$nonce_obj->owner_guid = 0;
    		$nonce_obj->title = 'nonce';
    		
    		if ($nonce_obj->save()) {
        		$nonce_obj->server_url = $server_url;
        		$nonce_obj->timestamp = $timestamp;
        		$nonce_obj->salt = $salt;
        		return true;
    		} else {
        		return false;
    		}
		}
	}
	
	function getTrustedSites() {
    	
		error_log("GET TRUSTED");
    	$results = get_entities_from_metadata('openid_url', getLoggedInUser(), 'object','openid_server::trust_root');
	   	
		$sites = array();
		if ($results) {
    		foreach ($results as $site) {
    			$sites[] = $site->trust_root;
		error_log("GET TRUST".$site->trust_root);
    		}
		}
		return $sites;
	}
	
/**
 * Returns the autologin URLs for every trusted site
 */ 	
	
	function getAutoLoginSites() {
	   	
   		$default_trusted_sites = get_entities_from_metadata('openid_url', '', 'object','openid_server::trust_root');
   		
		$sites = array();
		if ($default_trusted_sites) {
			foreach ($default_trusted_sites as $site) {
    			if ($site->auto_login_url) {
				    $sites[] = $site;
			    }
			}
		}
		return $sites;
	}

/**
 * Returns the autologout URLs for every trusted site
 */ 	
	
	function getAutoLogoutSites() {
	   	
   		$default_trusted_sites = get_entities_from_metadata('openid_url', '', 'object','openid_server::trust_root');
   		
		$sites = array();
		if ($default_trusted_sites) {
			foreach ($default_trusted_sites as $site) {
    			if ($site->auto_logout_url) {
				    $sites[] = $site;
			    }
			}
		}
		return $sites;
	}
	
	
	function setTrustedSite($trust_root) {
   		$openid_url = getLoggedInUser();
   		$site = new ElggObject();
		error_log("SET TRUST-"."X".$trust_root->site_name."X".$trust_root->trust_root.":-:".$openid_url);
		$site->subtype = 'openid_server::trust_root';
		$site->owner_guid = 0;
		$site->title = 'association';
		$site->access_id = 2;
		
		if ($site->save()) {
    		$site->openid_url = $openid_url;
    		$site->trust_root = $trust_root->trust_root;
    		$site->site_name = $trust_root->site_name;
    		$site->autologin = $trust_root->autologin;
    		$site->autologout = $trust_root->autologout;
    		$site->width = $trust_root->width;
    		$site->height = $trust_root->height;
    		return true;
		} else {
    		return false;
		} 	
	}
	
	function removeAllTrustedSites() {
		
		$openid_url = getLoggedInUser();
		
		if ($openid_url != null) {
    		$results = get_entities_from_metadata('openid_url', $openid_url, 'object','openid_server::trust_root');
	   	
   			if ($results) {
       			foreach($results as $trust_root) {
           			$trust_root->delete();
       			}
   			}
		}
		return true;
	}
	
	function removeTrustedSite($trust_root) {
		
		$openid_url = getLoggedInUser();
		
		if ($openid_url != null) {
    		$meta_array = array(
                        'openid_url'    => $openid_url,
                        'trust_root'    => $trust_root
            );
        
            $results = get_entities_from_metadata_multi($meta_array, 'object', 'openid_server::trust_root');
	   	
   			if ($results) {
       			foreach($results as $trust_root) {
           			$trust_root->delete();
       			}
   			}
		}
		return true;
	}
}

function getOpenIDServerStore() {
    return new OpenIDServer_ElggStore();
}


if (!function_exists('fnmatch')) {
function fnmatch($pattern, $string) {
   for ($op = 0, $npattern = '', $n = 0, $l = strlen($pattern); $n < $l; $n++) {
       switch ($c = $pattern[$n]) {
           case '\\':
               $npattern .= '\\' . @$pattern[++$n];
           break;
           case '.': case '+': case '^': case '$': case '(': case ')': case '{': case '}': case '=': case '!': case '<': case '>': case '|':
               $npattern .= '\\' . $c;
           break;
           case '?': case '*':
               $npattern .= '.' . $c;
           break;
           case '[': case ']': default:
               $npattern .= $c;
               if ($c == '[') {
                   $op++;
               } else if ($c == ']') {
                   if ($op == 0) return false;
                   $op--;
               }
           break;
       }
   }

   if ($op != 0) return false;

   return preg_match('/' . $npattern . '/i', $string);
}
}

?>
