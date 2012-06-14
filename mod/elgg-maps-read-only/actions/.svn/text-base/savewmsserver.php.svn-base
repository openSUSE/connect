<?php
  // only logged in users can add a server
  gatekeeper();
 
  // get the form input
  
  $title = get_input('title');
  $description = get_input('description');
  $access_id = (int) get_input('access_id', ACCESS_PRIVATE);
  
    // create a new map object
  $mapobject = new ElggObject();
  $mapobject->title = $title;
  $mapobject->description = $description;
  $mapobject->subtype = "wmsserver";
 
  // for now make all blog posts public
  $mapobject->access_id = $access_id;
 
  // owner is logged in user
  $mapobject->owner_guid = get_loggedin_userid();
 
  // save to database
  $mapobject->save();
 
  // forward user to a page that displays the post
  forward($mapobject->getURL());
?>
