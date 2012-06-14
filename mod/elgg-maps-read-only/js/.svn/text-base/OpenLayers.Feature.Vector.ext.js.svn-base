/**
 * @name OpenLayers.Feature.Vector
 * @class OpenLayers.Feature.Vector
 *
 * Extensions to OpenLayers.Feature.Vector for it to be able
 * to handle 'add', 'modify' and 'delete' actions on
 * its geometry or its attributes.
 * <p>elgg-maps uses features with attributes that are stored as
 * elgg objects with the 'emFeature' subtype. They arrive to
 * OpenLayers as <b>placeMarks</b> tags in a KML layer rendered by elgg-maps backend on the server.</p>
 *
 */
 OpenLayers.Feature.Vector.prototype = jQuery.extend(OpenLayers.Feature.Vector.prototype, {
	/**
	 * @type Boolean flag used by edit() and cancelEdit() to check if 
	 * the feature is currently being edited.
	 */
	editing: false,

	
	/**
	 * With parmeters, flags a feature as dirty (or not dirty) meaning it will be saved
	 * when the map is saved.
	 * Called without parameters, it returns the current state of the feature
	 *
	 * @param {Boolean} [markAsDirty] True for marking the feature as dirty.
	 * @returns {Boolean} True if the feature is marked as dirty. False otherwise.
	 */
	dirty : function(markAsDirty)
	{
		if (typeof markAsDirty != 'undefined' ) {
			this.attributes.saveThis = (markAsDirty) ? true :false;
		} 
		return this.attributes.saveThis;
	},


	/**
	 * Updates a feature attributes (.attributes.wkt and .lonlat)
	 * from its .geometry
	 *
	 */
	updateGeometryAttributes : function()	 
	{
		this.attributes.wkt = this.geometry.toString();
		this.lonlat = this.geometry.getBounds().getCenterLonLat();		
	},



	/**
	 * Applies a default style to the feature.
	 * Currently it extracts
	 * the default styled used in the KML that represents this feature's
	 * layer.
	 * This method is used when a new feature is drawn by the user.
	 */
	applyDefaultStyle : function()
	{
		this.style = this.layer.protocol.format.styles['#pal1'];
		this.layer.redraw();
	},


	/**
	 * Shows a FramedCloud Popup with the feature's metadata.
	 * The popup shows two links to edit and delete
	 * actions on this feature for modifying it, if it's allowed.
	 *
	 */
	showMetadata : function()	
	{
		var content = "<h2>" + this.attributes.title + "</h2>";
		content += "<hr />";
		content += "<div style=\"text-align:right;font-size:10px;\"><a id=\"editFeatureMetadataLink\" href=\"#\">Modificar este objeto</a></div>";
		content += "<p>" + this.attributes.description + "</p>";
		
		this.popup = new OpenLayers.Popup.FramedCloud(
			this.id,
			this.geometry.getBounds().getCenterLonLat(),
			this.layer.popupInitialSize,
			content,
			null,
			true,
			jQuery.proxy(function (e) {this.layer.unselectAllFeatures();}, this)
		);
		this.popup.autoSize = true;
		this.popup.minSize = this.layer.popupMinSize;
		this.popup.maxSize = this.layer.popupMaxSize;
		//f.popup.hide();
		this.layer.map.addPopup(this.popup, true);
		
			/*
			 * No sé por qué llamar a esta función así nomás me saca de scope
			 */
		jQuery.proxy(attachHandlers,this)();
		
		function attachHandlers() {
			
			$('#editFeatureMetadataLink').click(jQuery.proxy(function(){
				this.hidePopup();
				this.edit(jQuery.proxy(this.cancelEdit,this));
				return false;
			},this));
			
		}
	},

	
	/**
	 * Activates a 'standalone' modifyfeaturecontrol for this feature (also creates it if it
	 * doesn't exist), selects this feature and shows 
	 * the edit form for this feature's attributes.
	 * It also handles new attributes for a new feature...
	 * <p>Being that
	 * a new feature is added to the layer prior to showing the form for
	 * the attributes, then, it actually is an edit operation on the emFeature
	 * as a whole... So. when edit is called, the feature can be moved,
	 * modified, as well as have its attributes modified by the user.</p>
	 * @see {OpenLayers.Control.ModifyFeature} OpenLayers.Control.ModifyFeature 'standalone' property.
	 * @param {Function} onCancelCallback a callback for doing cancel operations when the edition is canceled.
	 */
	edit : function(onCancelCallback)
	{
		this.editing = true;
		this.modifyControl =  this.modifyControl || new OpenLayers.Control.ModifyFeature(this.layer, {
			standalone:true
		});

		this.layer.events.register('featuremodified',this, this.onGeometryModified);
		this.layer.map.addControl(this.modifyControl);
		//this.modifyControl.activate();
		this.modifyControl.selectFeature(this);
		//this.layer.elggmaps.controls[1].activate();
		//this.layer.elggmaps.controls[1].selectFeature(this);
		this.showEditForm(onCancelCallback);
	},

	/**
	 *
	 *
	 */
	saveFromForm : function()
	{
		
		//console.log(e.currentTarget.activeElement.value);return false;
		var title = $(this.popup.contentDiv).find('input#featureName').val();
		var desc = $(this.popup.contentDiv).find('textarea#featureDescription').val();
		
		this.attributes.title = title;
		this.attributes.description = desc;
		this.dirty(true);
		this.cancelEdit();
		return false;

	},
	
	
	/**
	 *
	 *
	 */
	 
	remove: function()
	{
		if(this.guid !== '') {
			elggMap.deleteQueue.push(this.attributes.guid);
		}
		this.cancelEdit();
		this.destroy();
		return false;
	},
	
	/**
	 * Shows a FramedCLoud Popup with a form 
	 * for modyfing the feature's metadata
	 * @ignore
	 * @param {OpenLayers.Feature.Vector} f the feature
	 */	
	showEditForm : function(onCloseCallback)	
	{
		var title = this.attributes.title || '';
		var description = this.attributes.description || '';
		this.attributes.guid = this.attributes.guid || '';
		var content = "<form id='featureAddForm' style='display:inline'>";
		content += "<p style='margin:0 0 3px 0;'>Title<br /><input class='input-text' id='featureName' value='" + title + "' /></p>";
		content += "<p style='margin:0 0 3px 0;'>Description<br /><textarea style='height:98px' class='input-textarea' id='featureDescription'>" + description + "</textarea></p>";
		content += "<input class='submit_button' type='submit' value='OK' id='featureSubmit' />";
		content += "</form>";
		content += "<form id='featureDeleteForm' style='display:inline'>&nbsp;<input class='submit_button' type='submit' value='Delete' id='featureDelete' /></form>";
		
		this.popup = new OpenLayers.Popup.FramedCloud(
			this.id,
			this.geometry.getBounds().getCenterLonLat(),
			this.layer.popupInitialSize,
			content,
			null,
			true,
			onCloseCallback
		);
		this.popup.autoSize = true;
		this.popup.minSize = this.layer.popupMinSize;
		this.popup.maxSize = this.layer.popupMaxSize;
		
		this.layer.map.addPopup(this.popup, true);
		$('#featureAddForm').submit(jQuery.proxy(this.saveFromForm,this));
		$('#featureDeleteForm').submit(jQuery.proxy(this.remove,this));	
	},
	
	
	/**
	 * Closes the editing form popup, deselects the feature,
	 * and deactivates the ModifyFeatureControl 
	 * for this feature.
	 */
	cancelEdit : function()
	{
		this.editing = false;
		this.hidePopup();
		this.layer.currentFeature(null);
		this.modifyControl.unselectFeature();
		this.modifyControl.deactivate();
		//this.layer.elggmaps.controls[1].activate()
		//this.layer.elggmaps.controls[1].unselectFeature();
		this.layer.unselectAllFeatures();
		
	},
	

	/**
	 * Tries to destroy the feature's popup if it's visible
	 * and if it hasn't already being destroy()ed.
	 *
	 */
	hidePopup : function()	
	{
		/*
		 * Kludge: If the popup is already destroyed popup.visible() and popup.destroy()
		 * throw errors. Fixed with a check for popup.id. 
		 * popup.id is set to null by OpenLayers.Popup.prototype.destroy()
		 * 
		 */
		if (typeof this.popup !== 'undefined'
			&& this.popup != null && this.popup.id) {
				this.popup.destroy();
		}
		
	},


	/**
	 * Handler for responding to a selection by a 
	 * control. The layer calls this method.
	 * Shows the feature's attributes.
	 * @event onSelect
	 */
	onSelect : function()
	{
		this.showMetadata();
	},
	
	
	/**
	 * Handler for responding to an unselection by a control.
	 * <p>The layer calls this method when the user unselects
	 * a feature by closing a feature popup or clicking out
	 * of the feature</p>
	 * @event
	 */
	onUnselect : function()
	{
		this.hidePopup();
		if (this.editing)
			this.cancelEdit();
	},


	/**
	 * Handles the aftermodified event from this feature's
	 * ModifyControl.
	 * Updates the feature's geometry attributes from it's geometry 
	 * and marks the feature as dirty for the layer to save its new data.
	 * @event
	 */
	onGeometryModified : function()	
	{
		this.updateGeometryAttributes();
		this.dirty(true);
	}

});