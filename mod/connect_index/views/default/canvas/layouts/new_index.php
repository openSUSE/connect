<?php

	/**
	 * Elgg custom profile 
	 * You can edit the layout of this page with your own layout and style. Whatever you put in the file
	 * will replace the frontpage of your Elgg site.
	 * 
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.org/
	 */
	 
?>

    <!-- left column content -->
    <div class="grid_8 alpha">
        <!-- welcome message -->
        <div class="box box-shadow"> <!-- id="index_welcome" --> 
        	<?php
        		if (isloggedin()){
	        		echo "<h2 class=\"box-header\">" . elgg_echo("welcome") . "</h2>";
        			echo "<p>Hello " . $vars['user']->name . " how are you today?</p>";
    			}
        	?>
            <?php
            	//include a view that plugins can extend
            	echo elgg_view("index/lefthandside");
            ?>
	        <?php
	            //this displays some content when the user is logged out
			    if (!isloggedin()){
			    	echo "<h2 class=\"box-header\">" . elgg_echo("signup:header") . "</h2>";
				echo "<a href=\"https://" . $_SERVER['SERVER_NAME'] . "/ICSLogin/?%22https://" . $_SERVER['SERVER_NAME'] . "/" . $_SERVER['REQUEST_URI'] . "%22\">";
				echo "<img src=\"" . $vars['url'] ."mod/connect_index/graphics/signup.png\" border=\"0\" style=\"position:relative; left:-28px;\" alt=\"Sign Up\">";
				echo "</a>";
				echo "<p>" . elgg_echo("signup:footer");
				echo "<a href=\"" . $vars['url'] . "mod/connect_index/graphics/about_friends.png\" rel=\"prettyPhoto[pp_gal]\">Learn More...</a>";
				echo "<a href=\"" . $vars['url'] . "mod/connect_index/graphics/about_groups.png\" rel=\"prettyPhoto[pp_gal]\"></a>";
				echo "<a href=\"" . $vars['url'] . "mod/connect_index/graphics/about_connect.png\" rel=\"prettyPhoto[pp_gal]\"></a>";
				echo "</p>";
				if (!is_plugin_enabled('ichain_login')) {
				   if (!isloggedin()){
                                      echo $vars['area1'];
                                      echo "<div class=\"clearfloat\"></div>";
                                   }
                                }
		        }
	        ?>
        </div>
<?php
    if(is_plugin_enabled('riverdashboard')){
?> 
        <!-- display river -->
        <div class="box box-shadow">
          <h2 class="box-header"><?php echo elgg_echo("river:header"); ?></h2>
            <?php
                if (isset($vars['area2'])){
                    echo $vars['area2'];
                } else {
                    echo "<p>" . elgg_echo('river:noriver') . "</p>";
                }
            ?>
        </div>
<?php
        }
?>
    </div>
    
    <!-- right hand column -->
    <div class="grid_8 omega">
        <!-- more content -->
	    <?php
            //include a view that plugins can extend
            echo elgg_view("index/righthandside");
        ?>
        <!-- latest members -->
      <div class="box box-shadow">
            <h2 class="box-header"><?php echo elgg_echo("members:header"); ?></h2>
            <div class="contentWrapper members_online">
            <?php
                if(isset($vars['area3'])) {
                    //display member avatars
                    foreach($vars['area3'] as $members){
                        echo "<div class=\"index_members\">";
                        echo elgg_view("profile/icon",array('entity' => $members, 'size' => 'small'));
                        echo "</div>";
                    }
                }else{
		              echo "<p>" . elgg_echo('members:nousers') . "</p>";
		            }
            ?>
            <div class="clearfloat"><?php echo "<p><br/><em>" . elgg_echo("members:footer") . "</em></p>"?></div>
        </div>
      </div>

<?php
    if(is_plugin_enabled('groups')){
?>
        <!-- display latest groups -->
            <div class="box box-shadow">
            <h2 class="box-header"><?php echo elgg_echo("groups:header"); ?></h2>
        <?php
                if (!empty($vars['area4'])) {
                    echo $vars['area4'];//this will display groups
                }else{
                    echo "<p>". elgg_echo('groups:nogroups') . "</p>";
                }
            ?>
            <p><a href="<?php echo $vars['url']; ?>/pg/groups/world/?filter=pop">More groups</a></p>
        </div>
<?php
        }
?>
    </div>
    <div class="clearfloat"></div>
