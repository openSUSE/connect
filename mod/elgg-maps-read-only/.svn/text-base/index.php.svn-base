<?
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php"); 
include_once("lib.php"); 
?>
<?
$mapgGUID = '';
if ($_GET['map']) {
	$mapGUID = $_GET['map'];
}
?>
<html>
<head>


<!--<link tyle='text/css' href='http://layout.jquery-dev.net/lib/css/layout-default-latest.css' rel='stylesheet'>-->
<link type='text/css' href='http://wfs.ign.gob.ar/red/mod/elgg-maps/css/cupertino/jquery-ui-1.8.11.custom.css' rel='stylesheet'>
<link type='text/css' href='http://fonts.googleapis.com/css?family=Cabin+Sketch:bold' rel='stylesheet'>
<link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
<script type='text/javascript'>
var ELGG_MAPS_MAPGUID = '<?=$mapGUID?>';
var ELGG_MAPS_WEBPATH = 'http://wfs.ign.gob.ar/red/mod/elgg-maps/';
var ELGG_MAPS_URL = 'http://wfs.ign.gob.ar/red/pg/elgg-maps/';
    $(document).ready(function () {
	//$('#Header').height(80);
	$('#ui-layout-west').css('height','100%');
	$('#ui-layout-center').css('height','100%');
	var resetLayout = function()
	{
	    //dejo un spare de 5, por las dudas
	    var usableHeight = $(window).height() - $('#Header').outerHeight() - 5;
	    $('#Main').outerHeight( usableHeight );
	}
	resetLayout();
	$(window).resize(resetLayout);
	elggMap.buildMap({mapGUID: ELGG_MAPS_MAPGUID});
    });
</script>
</head>
<body style="height:100%">


<div class="ui-layout-north" id="Header">
	 <a href="http://wfs.ign.gob.ar/red/mod/elgg-maps/" target="_self"><div class="logo"> </div></a>
    		<div id="login">
        		<div class="user_img">
        			<div class="login_bg">
        				<div class="name">Diego Rosón</div>
        				<div class="prof">Administrador </div>
        			</div>
        		</div>
    		</div>
</div>

<div id="Main">
<div class="ui-layout-west Sidebar" id="ui-layout-west">
			 	  
				  </div>


<div class="ui-layout-center"><div id="mapcontainer"></div></div>
</div>
</body>
<script type="text/javascript" src="http://wfs.ign.gob.ar/red/mod/elgg-maps/vendors/jquery/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="http://wfs.ign.gob.ar/red/mod/elgg-maps/vendors/jquery/jquery.form.js"></script>
<script type="text/javascript" src="http://layout.jquery-dev.net/lib/js/jquery.layout-latest.js"></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/lib/OpenLayers-2.9/OpenLayers.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/lib/OpenLayers-2.9/lib/OpenLayers/Lang/es.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/OpenLayers.Feature.Vector.ext.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/OpenLayers.Layer.Vector.emKML.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/ElggMap.constants.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/ElggMap.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/ElggMap.ui.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/ElggMap.edit.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/ElggMap.session.js'></script>
<script src='http://wfs.ign.gob.ar/red/mod/elgg-maps/js/ElggMap.remote.js'></script>
</html>
