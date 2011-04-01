<?php

/**
 * Elgg openid_server: autologout form
 * 
 * @package ElggOpenID
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */
 
require_once(dirname(dirname(__FILE__)).'/openid_server_include.php');

require_once ('lib/common.php');
require_once ('lib/session.php');
 
$iframe_template = <<<END
<iframe
width="%s"
height="%s"
src="%s"
>
</iframe>');
END;

$store = getOpenIDServerStore();
 
$openid_url = getLoggedinUser();
$sites = $store->getAutoLogoutSites();

// TODO: get this to work with posts
$iframes = '';
foreach ($sites as $site) {
    $iframes .= sprintf($iframe_template,$site->width,$site->height,sprintf($site->auto_logout,$openid_url));
}
$body = elgg_view("openid_server/forms/autologout", 
    array(
        'iframes'               => $iframes,

    ));
    
$CONFIG->events['logout'] = array();
    
logout();
header("Content-type:text/html");
print $body;
?>
