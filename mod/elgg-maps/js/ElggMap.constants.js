	/* some default icon to use with markers/features */
var EM_DEFAULT_MARKER_ICON = new OpenLayers.Icon(ELGG_MAPS_WEBPATH + "graphics/PinDown1.png", new OpenLayers.Size(32, 39), new OpenLayers.Pixel(-7, -35));
	/* Default OpenLayers.Controls */
var EM_DEFAULT_MAP_CONTROLS = [
		new OpenLayers.Control.PanZoomBar({position: new OpenLayers.Pixel(0, 50)}),
		new OpenLayers.Control.MousePosition(),
		new OpenLayers.Control.LayerSwitcher({}),
		new OpenLayers.Control.Scale(),
		new OpenLayers.Control.Navigation({
			//zooMboxzoomBoxEnabled: true,
			zoomWheelEnabled: true,
			title: '',
			handleRightClicks: true,
				//esto no funciona... deberia, tambien quisiera definir el rightClick aca
			defaultClick: function (evt)  { alert('c'); }, defaultDblRightClick: function (evt)  {	alert('Not yet');},  dragPan: true })
	];

	var EM_PROJECTION_900913 = new OpenLayers.Projection('EPSG:900913');
	var EM_LAYER_IGNTILES_4326 = new OpenLayers.Layer.WMS("Base IGN", "http://wms.ign.gob.ar/geoserver/gwc/service/wms",	{  layers: ['SIGN'],format: "image/png8" } );
	var EM_LAYER_IGNTILES_900913 = new OpenLayers.Layer.WMS("Base IGN mercator", "http://wms.ign.gob.ar/geoserver/gwc/service/wms",	{  layers: ['SIGN'],format: "image/png"}, {projection:'EPSG:900913'}  );	