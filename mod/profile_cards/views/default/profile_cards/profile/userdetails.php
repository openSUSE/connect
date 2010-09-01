<?php
  $user  = $vars['entity'];
  $name  = $user->name;
  $pos   = $user->briefdescription;
  $email = $user->contactemail;
  $phone = $user->mobile ? $user->mobile : $user->phone;
  $web   = $user->website;
  $addr  = $user->location;

  $qr_url = $CONFIG->qr_url . 'MECARD%3AN%3A' . urlencode($name) . '%3BTEL%3A' . urlencode($phone) . '%3BURL%3A' . urlencode($web) . '%3BEMAIL%3A' . urlencode($email) . '%3BADR%3A' . urlencode($addr) . '%3BNOTE%3A' . urlencode($pos) . '%3B%3B';
  $common = 'name=' . urlencode($name) . '&pos=' . urlencode($pos) . '&email=' . urlencode($email) . '&phone=' . urlencode($phone) . '&web=' . urlencode($web) . '&addr=' . urlencode($addr);
  $vc_url = '../../mod/profile_cards/vcard.php?' . $common;
  $bc_url = '../../mod/profile_cards/bcard.php?' . $common;
?>
<div class="collapsable_box">
	<div class="collapsable_box_header">
	<a href="javascript:void(0);" class="toggle_box_edit_panel"><?=elgg_echo('user_details:show')?></a><h1><?=elgg_echo('user_details:caption')?></h1>
	</div>
   <div class="collapsable_box_editpanel" id="profile_info">
      <div style="display: table;">
      <div style="display: table-cell; padding: 10px;">
      <p><a href="<?php echo $vc_url; ?>"><?=elgg_echo('user_details:get_vcard')?></a></p>
      <p><b><?=elgg_echo('user_details:qr')?></b></p>
      <img alt="qr" src="<?php echo $qr_url; ?>" />
      </div>
      <div style="display: table-cell; padding: 10px;">
      <p><a href="<?php echo $bc_url; ?>"><?=elgg_echo('user_details:get_bcard')?></a></p>
      <p><b><?=elgg_echo('user_details:bc_pre')?></b></p>
      <img alt="<?=elgg_echo('user_details:get_bcard')?>" src=<?=$bc_url . "&preview=true"?> />
      </div>
      </div>
   </div>
</div>
