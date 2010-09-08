<?php

function create_url($type, $value) {
   if(preg_match('@^(https://|http://|irc://)@',$value)) {
      return "<a href=\"{$value}\">" . $value . '</a>';
   }
   $data = array (
      ':obs'              => 'https://build.opensuse.org/project/show?project=%v',
      ':gpg'              => 'http://pgp.mit.edu:11371/pks/lookup?op=get&search=%v',
      'profile:facebook'  => 'http://www.facebook.com/%v',
      ':contactemail'     => 'mailto:%v',
      ':xmpp'             => 'xmpp:%v',
      ':sip'              => 'sip:%v',
      ':freenode_channel' => 'irc://irc.freenode.net/%v',
      ':linkedin'         => 'http://www.linkedin.com/in/%v',
      'profile:twitter'   => 'http://twitter.com/%v',
      'profile:identica'  => 'http://identi.ca/%v',
      'profile:gitorious' => 'http://gitorious.org/~%v',
      'profile:github'    => 'http://github.com/%v',
      'profile:ohloh'     => 'http://www.ohloh.net/accounts/%v',
      'groups:ohloh'      => 'http://www.ohloh.net/projects/%v',
   );
   $stype = strstr($type,':');
   if(($href = $data[$stype]) || ($href= $data[$type])) {
      $href = str_replace('%v', htmlentities($value, ENT_QUOTES, 'UTF-8'), $href);
      $href = str_replace('%/', '%', $href);
      return "<a href=\"{$href}\">" . htmlentities($value, ENT_QUOTES, 'UTF-8') . '</a>';
   }
   return $value;
}

?>
