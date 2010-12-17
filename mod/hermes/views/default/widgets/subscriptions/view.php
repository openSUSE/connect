<div class="contentWrapper">

  <?php
    $username = get_loggedin_user();
    $username = 'kfreitag';
    $passwd = 'secret';
    if ($username) {
  ?>

<script type="text/javascript">
  function hermesCallback(list_of_subscriptions) {
    document.getElementById('hermes_status').innerHTML="Hallo " + list_of_subscriptions[0].name;
    var statusHTML = [];
    for (var i=0; i < list_of_subscriptions[0].subs.length; i++){
      var status = list_of_subscriptions[0].subs[i].description;
      statusHTML.push('<li><span>'+status+'</span></li>');
    }
    document.getElementById('hermes_update_list').innerHTML=statusHTML.join('');

  }
</script>

<div id="hermes_widget">
        <p id="hermes_status">status</p>
        <ul id="hermes_update_list"></ul>
        <p class="visit_hermes"><a href="http://hermes.opensuse.org">Hermes</a></p>
        <script type="text/javascript" src="http://<?php echo $username;?>:<?php echo $passwd;?>@notify.opensuse.org/index.cgi?rm=subscriptions&person=<?php echo $username; ?>&callback=hermesCallback&contenttype=text/json"></script>
</div>
   <?php

}
?>
</div>

