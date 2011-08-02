<?php
  $user = get_loggedin_user();
  $group = get_entity($CONFIG->MembersGroupID);
  if (check_entity_relationship($user->guid, 'membership_request', $CONFIG->MembersGroupID)) {
?>
<p>Membership request already sent. Please wait for the result.</p>
<?php
  } else
  if (!$group->isMember($user)) {
?>

<p>If you feel you are contributing substiantionally to openSUSE you might want to apply for openSUSE membership.</p>
<p>At first, make sure you agreed with the <a href="http://en.opensuse.org/openSUSE:Guiding_principles">Guiding Principles</a>
by joining <a href="<?php echo $vars['url']; ?>pg/groups/112/geekos/">Geekos</a> group. Requests from users that haven't agreed with
the principles will be discarded.</p>
<p>
<p>If you do want to become a member, please tell us in detail what your contributions are in the following form. Once submitted,
a request is created and you'll be notified of the result soon. Also, please use English language to describe your contributions.</p>
</p>
<p>If you want to receive a Freenode cloak please provide your IRC nickname in the description.</p>
<?php
    $form_body  = '<div>';
    $form_body  = elgg_view('input/longtext', array('internalname' => 'contributions'));
    $form_body .= '<br/>';
    $form_body .= elgg_view('input/submit', array('value' => elgg_echo('membership:request')));
    $form_body .= '</div>';
    echo elgg_view('input/form', array('action' => "{$vars['url']}action/membership/request", "body" => $form_body));
  } else {
?>
<p>Congratulations! You are already an openSUSE Member.</p>
<?php
  }
?>
