 //jQuery.getScript(ELGG_MAPS_WEBPATH + 'js/OpenLayers.ElggMapsExt.js');
//jQuery.getScript(ELGG_MAPS_WEBPATH + 'css/elgg-maps.css');
//jQuery.getScript("http://layout.jquery-dev.net/lib/js/jquery.layout-latest.js", initLayout);
/**
 * @class OpenLayers.Layer.emKML A layer type that loads KML from the elgg-maps backend and handles editing features.
 * @extends OpenLayers.Layer.Vector
 */
OpenLayers.Layer.emKML = OpenLayers.Class(OpenLayers.Layer.Vector, {

	/**
	 * Features' popup initial size.
	 * @type OpenLayers.Size
	 * @static
	 */
	popupInitialSize : new OpenLayers.Size(400,300),
	/**
	 * Features' popup minimum size.
	 * @type OpenLayers.Size
	 * @static
	 */	
	popupMinSize : new OpenLayers.Size(200,200),
	/**
	 * Features' popup  maximum size.
	 * @type OpenLayers.Size
	 * @static	 
	 */	
	popupMaxSize : new OpenLayers.Size(450,400),
	/**
	 * Placeholder for attributes specific to elggmaps usage
	 * @	 Object
	 * @static
	 */	
	elggmaps: {
		'guid': false,
		'selectControl': null,
		/**
		 * Array of controls used by this layer to handle
		 * features edition.
		 */
		'editControls' : [],
		/**
		 * Panel control used by this layer to handle
		 * user interaction.
		 */		
		'panel' : null
	},
	/**
	 * Sets layer strategies and protocols.<p>
	 * <p>Calls OpenLayers.Layer.Vector prototype initialize method.
	 * <p>Sets features to clean and udpates its geometry attributes when layer finishes loading.
	 * <p>Enables edition of the features if 'editable' is true in options argument.
	 * <p>Sets current selected feature (this.elggmaps.currentFeature) to null.
	 *
	 * <p><em> options may have an editable parameter as true or false for the layer to be editable.</em></p>
	 *
	 * <p><strong>options</strong> may have an editable parameter as true or false for the layer to be editable</p>
	 * <p>The parameters passed to the constructor are handled by the method initialize.
	 * @see OpenLayers.Layer.emKML#initialize</p>
	 *

	 * @param {String} name The name for the layer
	 * @param {Number} guid The Global Universal Identifier for the emLayer
	 * @param {Object} options Extra options to pass to OpenLayers.Layer.Vector construtor
	 */
	initialize: function(name, guid, options) {
		var newArguments = [] ;

        newArguments.push(name, options);
		this.strategies = [new OpenLayers.Strategy.Fixed()];
		
		if (!guid) {
			this.elggmaps.guid = 'new';
		} else {
			this.elggmaps.guid = guid;
		}
		this.protocol = new OpenLayers.Protocol.HTTP({
			url: ELGG_MAPS_URL + "viewlayer/" + this.elggmaps.guid,
			format: new OpenLayers.Format.KML({
				extractStyles: true, 
				extractAttributes: true,
				maxDepth: 2
			})
		});
		
		/*
		 * Call parent constructor
		 */
		OpenLayers.Layer.Vector.prototype.initialize.apply(this, newArguments);
		
		/*
		 * When the layers finsihes loading,
		 * - mark the feature as clean (no features need to be saved at this point)
		 * - Fill feature attributes from geometry property
		 *
		 */
		this.events.register('loadend', this, function() {
				var layer = this;
				$.each(this.features,function(key,f){
					f.dirty(false);
					f.updateGeometryAttributes();
					f.attributes.layerGUID = layer.elggmaps.guid;
				})

		});
		
		this.enableFeatureSelection();
		
		/*
		 * If option 'editable' was passed as true
		 * then enable edition on this layer
		 */
		if (options !== undefined && options.editable !== undefined) {
			this.enableEdition();
		}
		
		this.currentFeature(null);
	},
	
	
	/**
	 * Creates (or enables, if they already exist) controls for editing purposes and add them to the map either
	 * when layer finished loading (if this.map == null and editable:true was
	 * passed as argument to the constructor) or when called by its own (when
	 * this.map == true)
	 *
	 */
	enableEdition: function()
	{
		 /**
		  * If controls are already there, then enable them
		  * and return. Otherwise, create them.
		  */
		if (this.elggmaps.editControls.length ) {
			this.enableControls();
			return;
		}
		/*
		 * If this layer hasn't been added to a map yet
		 * Then attach control when layer fires  'loadend'
		 */
		 
		if (this.map === null) {
			this.events.register('loadend', this, this.attachEditControlsToMap);
		} else {
			this.attachEditControlsToMap(this.map);
		}
	},
	
	
	/**
	 *
	 */
	disableEdition: function()
	{
		
		this.disableControls();
	},
	
	
	/**
	 *
	 */
	enableControls: function()
	{
		
		this.elggmaps.panel.activate();
	},
	
	/**
	 *
	 */
	disableControls: function()
	{
		this.elggmaps.panel.deactivate();
	},

	
	enableFeatureSelection: function()
	{
		if (this.map === null) {
			this.events.register('loadend', this, this.enableFeatureSelection);
			return;
		}
		
		this.elggmaps.selectControl = new OpenLayers.Control.SelectFeature(this, {
			hover: false,
			clickout: true,
			onSelect: jQuery.proxy(this.onFeatureSelect,this),
			onUnselect: jQuery.proxy(this.onFeatureUnselect,this)
		});
		
		if (this.elggmaps.panel === null) {
			this.elggmaps.panel = new OpenLayers.Control.Panel({
						id: 'tota',
						defaultControl:this.elggmaps.selectControl
			});
			this.elggmaps.panel.addControls([this.elggmaps.selectControl]);
			this.map.addControl(this.elggmaps.panel);
		}
		
		
	},
	
	/**
	 *
	 */
	attachEditControlsToMap: function(map)
	{
		if (!(map instanceof OpenLayers.Map) )
			map = this.map;
		
		
		if (! this.elggmaps.editControls.length) {
			this.elggmaps.editControls.push(
				new OpenLayers.Control.DrawFeature(this,
					OpenLayers.Handler.Point, 
					{displayClass:'olControlDrawPoint', featureAdded: jQuery.proxy(this.onFeatureAdded,this)}
				),
				new OpenLayers.Control.DrawFeature(this,
					OpenLayers.Handler.Path,
					{displayClass:'olControlDrawPath', featureAdded: jQuery.proxy(this.onFeatureAdded,this)}
				),
				new OpenLayers.Control.DrawFeature(this,
					OpenLayers.Handler.Polygon,
					{displayClass:'olControlDrawPolygon', featureAdded: jQuery.proxy(this.onFeatureAdded,this)}
				)
			);
		}

		/**
		 * @todo sacar este kludge que es de transición
		 *
		 */
		$.each(this.elggmaps.editControls, jQuery.proxy(function (i,v) {
			v.events.register('activate', this, jQuery.proxy(function(event) {
				var thisControl = event.object;
				elggMap.activeTool = thisControl;
				if (this.currentFeature())
					this.currentFeature().hidePopup();
				return true;
			},this));
		},this));
		
		
		if ( this.elggmaps.panel === null ) {
			this.elggmaps.panel = new OpenLayers.Control.Panel({
				id: 'tota',
				defaultControl:this.elggmaps.selectControl
			});
			map.addControl(this.elggmaps.panel);
		}
		
		this.elggmaps.panel.addControls(this.elggmaps.editControls);
		

	},
	
	
	/**
	 *
	 */
	dettachEditControlsFromMap: function(map)
	{
	},
	
	/**
	 * Was meant to extend OpenLayers.Layer.Vector.setMap
	 * but currently its useless. Just calls it.
	 */
	setMap: function(map)
	{
		OpenLayers.Layer.Vector.prototype.setMap.apply(this, arguments);
	},
	/**
	 * Gets or sets current selected feature on layers
	 * @param {[OpenLayers.Feature.Vector]} feature
	 * @return {OpenLayers.Feature.Vector} current selected feature on this layer
	 */
	currentFeature: function(feature)
	{
		if (typeof feature != 'undefined') {
			this.elggmaps.currentFeature = feature;
			/**
			 * @todo sacar este kludge que es de transició
			 *
			 */
			elggMap.currentFeature = feature;
		}
		return this.elggmaps.currentFeature;
	},
	
	/**
	 * Returns features marked as dirty
	 * @param {Boolean} justTheAttributes True to return only the attributes property for each feature.
	 * @return  {Array} Array of dirty feature objects. Or array of each 'attributes' property for each dirty feature.
	 */
	getModifiedFeatures: function(justTheAttributes)
	{
		var modifiedFeatures = [];
		justTheAttributes =  (justTheAttributes != 'undefined')  ? true : false;

		$.each(this.features, function(i,feature) {
			if(feature.dirty()) {
				if (justTheAttributes) {
					modifiedFeatures.push(feature.attributes);
				} else {
					modifiedFeatures.push(feature);
				}
			}
		});
		
		return modifiedFeatures;
	},
	
	
	/**
	 * Unselects all features from this layer
	 *
	 */
	unselectAllFeatures: function()
	{
		this.elggmaps.selectControl.unselectAll();
		$.each(this.elggmaps.editControls, function(i,v) {
			if (typeof v.unselectAll == 'function') {
					/*
					 * This will trigger this layers's .onFeatureUnselect
					 */
				v.unselectAll();
			}
		});
	},
	
	/**
	 * Handles the 'onSelect' event on the OpenLayers.Control.Select control used as 'Select' tool.
	 *
	 * @param {OpenLayers.Feature} f The selected feature.
	 */	
	onFeatureSelect: function(f)
	{
		assertInstanceOf(OpenLayers.Feature.Vector, f);
		this.currentFeature(f);
		f.onSelect();
		return false;
	},

	/**
	 * Handles the 'onUnselect' event on the OpenLayers.Control.Select control used as 'Select' tool
	 * and the metadata edition tool.
	 *
	 * @param {OpenLayers.Feature} f  The recently unselected feature
	 */
	onFeatureUnselect : function(f)
	{
		//alert('pa');
		assertInstanceOf(OpenLayers.Feature.Vector, f);
		this.currentFeature(null);
		f.onUnselect();
	},
	
	/**
	 * Handles the 'featureAdded' event on the OpenLayers.Control.DrawFeature controls
	 * used as 'Point', 'Path' and 'Polygon' tools.
	 * It accepts geometries without metadata.
	 * 
	 *
	 * @param {OpenLayers.Feature} f The added feature.
	 */	
	 
	 
	onFeatureAdded: function(f)
	{
		assertInstanceOf(OpenLayers.Feature.Vector, f);
		this.currentFeature(f);
		/*
		 * This two lines for the Select Control to raise
		 * an unSelect event on the layer on clickout
		 */
		this.elggmaps.panel.activateControl(this.elggmaps.selectControl);
		this.elggmaps.selectControl.select(f);
		f.updateGeometryAttributes();
		f.attributes.layerGUID = this.elggmaps.guid;
		f.applyDefaultStyle();
		f.dirty(true);
		f.edit(jQuery.proxy(this.cancelAdd,this));
		//f.showAddMetadataForm();
		return false;
	},
	cancelAdd: function()
	{
		var f = this.currentFeature();
		f.cancelEdit();
			/**
			 * La feature había estado seteado como dirty...
			 * @todo tengo que sacar la feature de la capa o
			 * basta con destroy?
			 */
		f.dirty(false);
		f.destroy();
	},
	CLASS_NAME: "OpenLayers.Layer.emKML"
});



	/**
	 * Throw an exception if val is undefined
	 *
	 * @param {Mixed} val The variable you want to check
	 * @todo Might be more appropriate for debug mode only?
	 */
	function assertUndefined(val)
	{
		if (typeof val == 'undefined') {
			throw new TypeError("Param from " +
				arguments.caller + "is undefined");
		}
	}

	/**
	 * Throw an exception if val is a null object
	 *
	 * @param {Mixed} val The variable you want to check
	 * @todo Might be more appropriate for debug mode only?
	 */
	function assertNull(val)
	{
		assertTypeOf(val, 'object');
		if (val == null) {
			throw new TypeError("Param from " +
				arguments.caller + "is null");
		}
	}
	
	/**
	 * Throw an exception if the type doesn't match
	 *
	 * @param {Mixed} val The variable you want to check
	 * @param {String} The type to compare {val}'s type to.
	 * @todo Might be more appropriate for debug mode only?
	 */
	function assertTypeOf(val, type) {
		assertUndefined(val);
		if (typeof val !== type) {
			throw new TypeError("Expecting param of " +
				arguments.caller + "to be a(n) " + type + "." +
				"  Was actually a(n) " + typeof val + ".");
		}
	}

	/**
	 * Throw an exception if i is not an instance of c
	 *
	 * @param {Class} c The subclass to match to the object
	 * @param {Object} i The instance (object) to be checked
	 */
	function assertInstanceOf(c, i ) {
		assertNull(i);
		if (! (i instanceof c) ) {
			throw new TypeError("Expecting param of " +
				arguments.caller + "to be a(n) " + c.CLASS_NAME + "." +
				"  Was actually a(n) " + i.CLASS_NAME + ".");
		}
	};