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

<div id="custom_index">

    <!-- left column content -->
    <div id="index_left">
        <!-- welcome message -->
        <div id="index_welcome"> 
        	<?php
        		if (isloggedin()){
	        		echo "<h2>" . elgg_echo("welcome") . " ";
        			echo $vars['user']->name;
        			echo "</h2>";
    			}
        	?>
            <?php
            	//include a view that plugins can extend
            	echo elgg_view("index/lefthandside");
            ?>
	        <?php
	            //this displays some content when the user is logged out
			    if (!isloggedin()){
	            	//display the login form
			    	echo $vars['area1'];
				echo "<p><b>Want to try out connect?</b><br />Use the user geeko with password opensuse</p>";
			    	echo "<div class=\"clearfloat\"></div>";
		        }
	        ?>
        </div>
<?php
    if(is_plugin_enabled('file')){
?> 	
        <!-- display latest files -->
        <div class="index_box">
            <h2><?php echo elgg_echo("custom:files"); ?></h2>
            <?php 
                if (!empty($vars['area5'])) {
                    echo $vars['area5'];//this will display files
                }else{
                    echo "<p>" . elgg_echo('custom:nofiles') . "</p>";
                }
            ?>
        </div>
<?php
	}
	
    if(is_plugin_enabled('groups')){
?> 
        <!-- display latest groups -->
	    <div class="index_box">
            <h2><?php echo elgg_echo("custom:groups"); ?></h2>
        <?php 
                if (!empty($vars['area6'])) {
                    echo $vars['area6'];//this will display groups
                }else{
                    echo "<p>". elgg_echo('custom:nogroups') . "</p>";
                }
            ?>
    	</div>
<?php
        }

    if(is_plugin_enabled('polls')){
?>
        <!-- display latest groups -->
            <div class="index_box">
            <h2><?php echo elgg_echo("custom:polls"); ?></h2>
        <?php
                if (!empty($vars['area7'])) {
                    echo $vars['area7'];//this will display groups
                }else{
                    echo "<p>" . elgg_echo('custom:nopolls') . "</p>";
                }
            ?>
        </div>
<?php
        }
?>
    </div>
    
    <!-- right hand column -->
    <div id="index_right">
        <!-- more content -->
	    <?php
            //include a view that plugins can extend
            echo elgg_view("index/righthandside");
        ?>
        <!-- latest members -->
	<div class="index_box">
            <h2><?php echo elgg_echo("custom:members"); ?></h2>
            <div class="contentWrapper">
            <?php
                if(isset($vars['area2'])) {
                    //display member avatars
                    foreach($vars['area2'] as $members){
                        echo "<div class=\"index_members\">";
                        echo elgg_view("profile/icon",array('entity' => $members, 'size' => 'small'));
                        echo "</div>";
                    }
                }else{
		    echo "<p>" . elgg_echo('custom:nousers') . "</p>";
		}
            ?>
                <div class="clearfloat"></div>
                </div>
        </div>
<?php
    if(is_plugin_enabled('blog')){
?> 
        <!-- latest blogs -->
        <div class="index_box">
            <h2><?php echo elgg_echo("custom:blogs"); ?></h2>
            <?php 
                if (isset($vars['area3'])) 
                    echo $vars['area3']; //display blog posts
            ?>
        </div>
<?php
	}

    if(is_plugin_enabled('bookmarks')){
?>
        <!-- display latest bookmarks -->
    	<div class="index_box">
            <h2><?php echo elgg_echo("custom:bookmarks"); ?></h2>
            <?php 
                if (isset($vars['area4'])) 
                    echo $vars['area4']; //display bookmarks
            ?>
        </div>
<?php
	}
    if(is_plugin_enabled('event_calendar')){
?>
        <!-- display latest bookmarks -->
        <div class="index_box">
            <h2><?php echo elgg_echo("custom:events"); ?></h2>
            <?php
                if (isset($vars['area8'])){
                    echo $vars['area8']; //display bookmarks
		}else{
                    echo "<p>" . elgg_echo('custom:noevents') . "</p>";
                }
            ?>
        </div>
<?php
        }
?>
    </div>
    <div class="clearfloat"></div>
</div>
