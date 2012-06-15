loadCSS(ELGG_MAPS_WEBPATH + 'css/elgg-maps.css');

/**
 * @param {String} url the css to load
 */
function loadCSS(url)
{
	$("head").append($("<link rel='stylesheet' href='" + url + "' type='text/css' media='screen' />"));
}


/**
 *
 * Clase para todas las funciones de map/openlayers
 * Depende de:
 *	var ELGG_MAPS_WEBPATH: path al raiz del plugin/mod de elgg:
 *	OpenLayers
 *	jQuery
 *	
 *	Declara variable elggMap;
 * @class ElggMap 
 */
ElggMap = function (customOptions)
{
	/*
	 *PRIVATE VARS
	 */
	
	/**
	 * 
	 * A permanent reference to this object... For scope purposes.
	 * @static
	 * @type Object
	 */
	var me = this;
	
	/**
	 * Some default icon to use with markers/features
	 * @type OpenLayers.Icon
	 * @private
	 */
	var defaultMarkerIcon =  EM_DEFAULT_MARKER_ICON;

	
	var mapControls = EM_DEFAULT_MAP_CONTROLS;

	/*
	 * PRIVATE FUNCTIONS 
	 */
	 

	/**
	 * Sets default height and weight for the container element.
	 * It sets them to its parent container dimensions.
	 *
	 * @param {string} containerID The id of the map container HTML element	 
	 */
	function fitMapContainerToParent(containerId)
	{
		assertTypeOf(containerId, 'string');
		var mapParent = $('#' + containerId).parent();
		$('#' + containerId).css('height', mapParent.height()); 
		$('#' + containerId).css('width', mapParent.width());
	}
	/**
	 * Throws an Error exception with a description
	 *
	 * @param {string} error description
	 */
	this.error = function(reason)
	{
		throw new Error(reason);
	}	
	assertUndefined(OpenLayers);
	assertUndefined(jQuery);
	assertUndefined(ELGG_MAPS_WEBPATH);
	
	/* PUBLIC VARS */
		
	this.initialCenter = new OpenLayers.LonLat(-58.67090, -32.71387);
	
	this.initialExtent = null;
	
	this.drawTools = null;
	
	this.activeTool = null;
	
	this.activeLayer = null;
	
	this.layers = [];
	
	this.currentFeature = null;
	
	this.deleteQueue = [];
	
	/* la idea de esta var es que si la seteamos, eventos como 
	moveend y zoomend traten de setear el valor de inputs en el domId
	que especifiquemos aca
	*/
	this.populateForm = false;
	this.formSelectors = {
		formId: '#emMapSaveForm',
		formFields: {
			extentLeft: '#extentLeft',
			extentBottom: '#extentBottom',
			extentTop: '#extentTop',
			extentRight: '#extentRight'
		}
	};
	
	/*
	 * default options for a map, public
	 * This can be set in the constructor ELggMap(customOptions)
	 */
	this.mapSettings = {
		div: 'mapcontainer',
		controls: mapControls,
		//restrictedExtent: new OpenLayers.Bounds(-76, -66, -40.636, -15), 
		tileSize: new OpenLayers.Size(256, 256), 
		/**
		 * displayProjection is used by ArgParser, MousePosition, Permalink Controls...
		 */
		displayProjection: new OpenLayers.Projection('EPSG:4326'), 
		
		units: "degrees", 
		resolutions: [
			0.06288206988836649,
			0.025152827955346596,
			0.012576413977673298,
			0.0025152827955346596,
			0.0012576413977673298,
			6.288206988836649E-4,
			2.5152827955346593E-4
		],//, 1.2576413977673296E-4, 6.288206988836648E-5, 2.5152827955346596E-5]
		eventListeners: {
			'moveend': onPan,
			'zoomend': onZoom,
			'removelayer': onLayerRemove,
			'addlayer': onLayerAdded
		}
		//scales: [25000000, 10000000, 5000000, 1000000, 500000, 250000, 100000, 50000, 25000, 10000]
	};
	
	/**
	 * @type jQuery.layout
	 */
	this.myLayout = null;
	
	/* 
	 * After all properties are set,
	 * check for custom options and merge them
	 */
	$.extend(true, this, customOptions);
			
	/* map instance */
	this.map = null;
	
	/*
	 * PUBLIC METHODS
	 */
	
	/**
	 * Getter for defaultMarkerIcon property.
	 * It COULD be a simple public property, but then
	 * we should always call it with .clone()
	 */
	this.getDefaultIcon = function ()
	{
		return defaultMarkerIcon.clone();
	};
	
	/**
	 * Creates a new map.
	 * - It finds the default div id in the DOM and adjusts it to its parent 
	 * container dimensions.
	 * - Instantiantes OpenLayers.Map with default settings from this.mapSettings
	 * - Adds the base layer to the map.
	 * - Sets the initial extent to the one given by the backend in this.initalExtent
	 * - Prepares the map tools
	 *
	 * @todo Chequear que el id del div sea el de un div existente.
	 * @todo Chequear que this.map no exista o destruirlo antes de continuar.
	 */
	this.buildMap = function (buildOptions)
	{
		assertTypeOf(this.mapSettings.div, 'string');
		if (this.mapSettings.div === undefined || this.mapSettings.div === null || this.mapSettings.div === '')
			this.error('mapSettings.div needs to be set with DOM ID for map to render');
		
		$.extend(true, this, buildOptions);
		//fitMapContainerToParent(this.mapSettings.div);
		
		/*
		 * New map instantiated.
		 * Base layer added
		 */
		this.map = new OpenLayers.Map(this.mapSettings);
		var baseLayer = EM_LAYER_IGNTILES_4326;
		this.map.addLayer(baseLayer);
		
		//if initialExtent is set, try to get OL.Bounds from array
		// failsafe to initialCenter
		if (this.initialExtent !== null)
		{
			var extent = new OpenLayers.Bounds.fromArray(this.initialExtent);
			if (extent.CLASS_NAME !== undefined && extent.CLASS_NAME == 'OpenLayers.Bounds')
			{
				this.initialExtent = extent;
				this.map.zoomToExtent(this.initialExtent, true);
			}else{
				this.initialExtent = null;
				this.map.setCenter(this.initialCenter);
			}
		} else {
			this.map.setCenter(this.initialCenter);
		}

		if (this.mapGUID) {
			this.loadEmMap(this.mapGUID);
		} else {
			this.showVisibleMaps();
		}
		
		if (!this.myLayout) {
			//this.buildLayout();
		}
	};
	


	this.loadEmMap = function(mapGUID) 
	{
		response = this.api('emMap.getData', {guid:mapGUID});
		if (!response) {
			return;
		}
		if(response.layers) {
			elggMap.importLayers(response.layers);
		} else {
			elggMap.map.addLayer(new OpenLayers.Layer.emKML());
		}

		this.showMapMetadata(mapGUID);
	
		if (this.editable) {
			this.edit();
		}		
		
	};
	
	
	this.createDummyLayer = function()
	{
		if (this.activeLayer === null && this.layers.length == 0)		
		{		
			var newFeaturesLayer =  new OpenLayers.Layer.Vector('vectorLayer', {displayInLayerSwitcher: false	});
			newFeaturesLayer.events.on('featuremodified', onFeatureModify);
			this.setActiveLayer(newFeaturesLayer);
			this.map.addLayer(me.activeLayer);
		}
	};

	/**
	 * Adds the maps layers as KML layers over the map and sets
	 * the listeners for 'featuremodified' and 'loadend' events on the layers.
	 * - On 'loadend' it sets feature attribute saveThis to false and attribute lonlat
	 * to the feature centroid. Also it activates the select tool.
	 *
	 * @param {JSON Object} layersArray the json object passed from the backend that contains
	 * the GUID from the layers of this map
	 */
	this.importLayers = function(layersArray)
	{
		//en estos features voy a recibir un container_guid
		//tal vez podria iterar por esa prop para hacer nuevos layers?
		//por el momento es solo una, la saco de ahi y la seteo como layer.id
		//despues en el form tengo que agregar el campo layer.id o algo asi
		assertTypeOf(layersArray, 'object');
		$.each(layersArray,function(key,value){
			l = new OpenLayers.Layer.emKML(value.title, key);
			
			l.description = value.description;
			l.title = value.title;
			l.guid = key;
			
			me.map.addLayer(l);
			me.setActiveLayer(l);
		});
		
	}
	this.setActiveLayer = function(layer)
	{
		this.activeLayer = layer;
		if(this.drawTools !== null)
		{
			
		}
	}
	/**
	 * Triggers the 'moveend' event on the map by recentering
	 * it to the current center.
	 * This function was thought for forcing the populateForm
	 * 
	 * @todo remove this functions when onPan and onZoom are unified
	 */
	this.triggerPan = function()
	{
		if(this.map !== null) this.map.setCenter(this.map.center);
	}
	


	/**
	 * Handler for the 'moveend' event on the map.
	 * Currently it does the same that onZoom does.
	 * @todo Use the same handler for both events
	 *
	 * EVENT HANDLERS * PRIVATE??? 
	 * en los settings del map meto estas 2 funciones,
	 * si las meto como this. no funcionan, asi q por ahora van private
	 */
	function onPan (event)
	{
		if (me.map.popups.length > 0)
		{
			me.map.popups[0].updatePosition();
			me.map.popups[0].panIntoView();
		}
		if (me.populateForm === true)
		{
			var form = me.formSelectors;
			var bounds = me.map.getExtent().toArray();
			$(form.formId).find(form.formFields.extentLeft).val(bounds[0]);
			$(form.formId).find(form.formFields.extentBottom).val(bounds[1]);
			$(form.formId).find(form.formFields.extentRight).val(bounds[2]);
			$(form.formId).find(form.formFields.extentTop).val(bounds[3]);
		}

	}
	/**
	 * Handler for the 'zoomend' event on the map.
	 * Updates popup positions panning them into view.
	 * Updates the form fields used to store the current map extent.
	 * This form fields are hidden inputs that will be sent to
	 * server as part of the form in case the user saves the map afterwards.
	 *
	 * @params {EventObject} event The event object
	 */
	function onZoom (event)
	{
		if (me.map.popups.length > 0)
		{
			me.map.popups[0].updatePosition();
			me.map.popups[0].panIntoView();
		}
		if (me.populateForm === true)
		{
			var form = me.formSelectors;
			var bounds = me.map.getExtent().toArray();
			$(form.formId).find(form.formFields.extentLeft).val(bounds[0]);
			$(form.formId).find(form.formFields.extentBottom).val(bounds[1]);
			$(form.formId).find(form.formFields.extentRight).val(bounds[2]);
			$(form.formId).find(form.formFields.extentTop).val(bounds[3]);
		}
	}
	
	/**
	 * Handler for the 'removelayer' on the map. Removes
	 * from this.layers the the layer passed on e.layer
	 * 
	 * @param {EventObject} e the event object
	 * @todo simplify it
	 */
	function onLayerRemove (e)
	{
		assertInstanceOf(OpenLayers.Layer, e.layer);
		var layerIndex = null;
		for(var i = 0; i < me.layers.length; i++)
		{
			if (me.layers[i].id == e.layer.id) layerIndex = i;
		}
		me.layers.splice(layerIndex,1);
	}
	/**
	 * Handler for the 'addlayer' event on the map. If the
	 * recently added layer is not a base layer, saves a reference
	 * to it in this.layers.
	 *
	 * @param {EventObject} e the event object
	 */
	function onLayerAdded (e)
	{
		assertInstanceOf(OpenLayers.Layer, e.layer);
		if (e.layer.isBaseLayer !== true) me.layers.push(e.layer);
	}
};

var elggMap = new ElggMap();
