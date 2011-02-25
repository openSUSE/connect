<div class="contentWrapper">

  <?php
    $username = get_loggedin_user();
    if ($username) {
       elgg_log("Hermes: User logged in : " + $username, 'NOTICE' ); 
    }
  ?>

<script type="text/javascript">

  function hermesCallback(list_of_subscriptions) {
    document.getElementById('hermes_status').innerHTML="Rendering...";
    var statusHTML = [];
    for (var i=0; i < list_of_subscriptions[0].subs.length; i++){
      var msgType = list_of_subscriptions[0].subs[i].msgtype;
      if( list_of_subscriptions[0].subs[i].description )
        msgType = list_of_subscriptions[0].subs[i].description;

      var idSnippet = list_of_subscriptions[0].subs[i].id;

      var buttonId = 'button_' + idSnippet;

      var detailsButton = '<div id="' + buttonId + '"><a href="#">details</a></div>';
      // var editlink = '<a href="https://hermes.opensuse.org/subscriptions/' + list_of_subscriptions[0].subs[i].id +'/edit"><img src="<?php echo $vars['url']; ?>/mod/hermes/graphics/edit.png" alt="Edit" title="Edit the subscription"/></a>';
      var details = '<ul id="hermes_detail_list">';
      details += '<li>Delivery: ' + list_of_subscriptions[0].subs[i].delivery + '</li>';
      details += '<li>Delay: ' + list_of_subscriptions[0].subs[i].delay + '</li>';
      // details += '<li>Private: ' + list_of_subscriptions[0].subs[i].private + '</li>';
      details += '</ul>';

      var detailLnk = '<a href="https://hermes.opensuse.org/subscriptions/' + list_of_subscriptions[0].subs[i].id +'/edit" alt="Edit" title="Edit the subscription">[edit]</a>';
      details += '<span style="text-align: right;">' + detailLnk + '</span>';

       $("#hermes_update_list").append( '<li><div id="'+ buttonId+'"><a href="#">'+msgType+'</a></div><div id="msgTypeDetails" style="display:none;">'+ details +'</div></li>' );
       $('#'+buttonId ).toggle( function() {
             $(this).css('background-color', '#dddddd'); 
             $(this).next().show();
	 }, function() {
	     $(this).css('background-color', '#ffffff');
	     $(this).next().hide();
         }
       );
    }
    document.getElementById('hermes_status').innerHTML='Your <a href="http://hermes.opensuse.org">Hermes Subscriptions</a>:';
  }

</script>

<div id="hermes_widget">
  <p id="hermes_status" style="padding-bottom:8px;vertical-align:bottom;padding-left: 50px; height:32px;background-image:url(<?php echo $vars['url']; ?>/mod/hermes/graphics/hermes.png); background-repeat:no-repeat;">
        Calling Hermes API...</p>
        <ul id="hermes_update_list"></ul>
        <script type="text/javascript" src="http://<?php echo $username;?>:<?php echo $passwd;?>@notify.opensuse.org/index.cgi?rm=subscriptions&person=<?php echo $username; ?>&callback=hermesCallback&contenttype=text/json"></script>
</div>
<?php
}
?>
</div>

