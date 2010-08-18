<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 *
 */

// get the tools menu
//$menu = get_register('menu');

?>

<div class="clearfloat"></div>


    
<!-- Start: Footer -->
    <div id="footer" class="container_12">

        <div class="box_content grid_3">
          <strong class="grey-medium spacer1">User: username</strong>
          <ul class="navlist">
            <li>1</li>
            <li>2</li>
            <li>3</li>
          </ul>
        </div>

      <div class="box_content grid_3">
        <strong class="grey-medium spacer1">Locations</strong>
        <ul>
          <li>1</li>
          <li>2</li>
          <li>3</li>
        </ul>
      </div>

      <div class="box_content grid_3">
        <strong class="grey-medium spacer1">Help</strong>
        <ul>
          <li>1</li>
        </ul>
      </div>


      <div id="footer-legal" class="border-top grid_12">
        <p>
          &#169; 2010 Novell, Inc. All rights reserved. Novell is a registered trademark and
          openSUSE and SUSE are trademarks of Novell, Inc. in the United States and other countries.
        </p>
      </div>

    </div>
    <!-- End: Footer -->



<div class="clearfloat"></div>

</div><!-- /#page_wrapper -->
</div><!-- /#page_container -->
<!-- insert an analytics view to be extended -->
<?php
	echo elgg_view('footer/analytics');
?>
</body>
</html>