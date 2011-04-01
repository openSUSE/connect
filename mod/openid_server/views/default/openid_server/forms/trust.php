<?php

/**
 * Elgg openid_server trust page
 * 
 * @package openid_server
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardiner <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 * 
 * @uses the following values in $vars:
 *
 * 'openid'               the user's OpenID
 * 'trust_root'           the trust root for the OpenID client requesting authentication
 */
?>

<div class="layout_canvas">
<div class="one_column">
<div class="contentWrapper">
<div class="form">
  <p><?php echo sprintf(elgg_echo('openid_server:trust_question'),$vars['openid_url'],$vars['openid_trust_root']) ?></p>
  <form method="post" action="<?php echo $vars['url'] ?>mod/openid_server/actions/trust.php">
    <input type="checkbox" name="remember" value="on" id="remember" /><label
        for="remember"><?php echo elgg_echo('openid_server:remember_trust') ?></label> 
    <br />
    <input type="hidden" name="trust_root" value="<?php echo $vars['openid_trust_root']; ?>" />
    <input type="submit" name="trust" value="<?php echo elgg_echo('openid_server:confirm_trust') ?>" />
    <input type="submit" name = "reject" value="<?php echo elgg_echo('openid_server:reject_trust') ?>" />
  </form>
</div>
</div>
</div>
</div>
