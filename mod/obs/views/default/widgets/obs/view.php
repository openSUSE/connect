<div class="contentWrapper">
<div id="obs_projects_list">
<style>
<!--
.obs_project_name {
   font-size: 12px;
   font-weight: bold;
}

.obs_package_status {
   font-size: 11px;
   font-style: italic;
}

.obs_package_name {
   font-style: normal;
}

-->
</style>
<?php

global $obs_host;

$owner = get_user($vars['entity']->owner_guid);

$norepo = true;

$projects = $owner->get("obs");

if((!is_array($projects)) && ($projects != "")) {
   $projects = array( $projects, "");
}

if (is_array($projects) && sizeof($projects) > 0) {
   foreach($projects as $project) {
      if($project != "") {
         $norepo = false;
         echo "<div class=\"obs_project\" >";
         echo "<div class=\"obs_project_name\" ><a href=\"$obs_host/project/show?project=" . $project . "\">" . $project . "</a></div>";
         $url = "$obs_host/project/status?limit_to_fails=false&project=" . $project;
         $body = http_get($url);
         if($body == false) {
            echo "<p>Connection failed!!!</p>";
         } else {
         $body = http_parse_message($body)->body;
         $body = implode(explode("\n", $body), " ");
         echo preg_replace(array("|.*<tbody>|","|/tbody>.*|",
                                 "|href=\"/|",
                                 "|tr>|", "|<td|", "|/td>|", "|nowrap|",
                                 "|<span class=\"hidden\">[^<]*</span>|"),
                           array("<div class=\"obs_package_status\">","/div>",
                                 "href=\"$obs_host/",
                                 "div>", "<p", "/p>", "obs_package_name", ""),
                           $body);
         }
         echo "</div>";
      }
   }
}
if($norepo) { ?>
   <p><?php echo elgg_echo('obs:status_widget_no_repo'); ?></p>
<?php
}

?>
</div>
</div>
