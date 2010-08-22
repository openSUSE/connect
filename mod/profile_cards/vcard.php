<?php
  $name = $_GET['name'];
  $pos = $_GET['pos'];
  $email = $_GET['email'];
  $phone = $_GET['phone'];
  $web = $_GET['web'];
  $addr= $_GET['addr'];
  $timestamp = date('Ymd').'T'.date('His').'Z';
  header('Content-type: text/x-vcard');
  header('Content-Disposition: attachment; filename="vcard.vcf"');
  echo <<<EOT
BEGIN:VCARD
VERSION:2.1
N:$name
FN:$name
ORG:openSUSE
TITLE:$pos
TEL;HOME;VOICE:$phone
ADR;HOME:$addr
EMAIL;PREF;INTERNET:$email
REV:$timestamp
END:VCARD

EOT;

?>
