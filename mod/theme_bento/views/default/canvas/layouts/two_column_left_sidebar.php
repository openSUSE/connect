<?php
/**
 * Elgg 2 column left sidebar canvas layout
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */
?>
<!-- left sidebar -->
<div class="column grid_3 alpha">

	<?php

		echo elgg_view('page_elements/owner_block',array('content' => $vars['area1']));

	?>

	<?php if (isset($vars['area3'])) echo $vars['area3']; ?>

</div><!-- /two_column_left_sidebar -->

<!-- main content -->
<div id="two_column_left_sidebar_maincontent" class="box box-shadow grid_13 clearfix">

<?php if (isset($vars['area2'])) echo $vars['area2']; ?>

</div><!-- /two_column_left_sidebar_maincontent -->

