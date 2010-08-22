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
<div id="profile_info">
<p><a href="<?php echo $vc_url; ?>">Download vCard</a></p>
<p><a href="<?php echo $bc_url; ?>">Business cards for printing (SVG)</a></p>
<p><b>QR code:</b></p>
<img alt="qr" src="<?php echo $qr_url; ?>" />
</div>
