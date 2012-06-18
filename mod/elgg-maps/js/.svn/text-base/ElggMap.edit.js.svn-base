jQuery.extend( ElggMap.prototype, {
	/**
	 * Sets the map in edit mode if the user can  edit it.
	 * - Shows Edit form (the form for the map attributs).
	 * - Enables edition on the layers.
	 */
	edit : function()
	{
		if (this.requireEditAccess(this.mapGUID) ) {
			this.showEditForm();
			$.each(this.layers, function(i, layer) {
				layer.enableEdition();
			});
		}
		
	},

	requireEditAccess: function(mapGUID)
	{
		response = this.api('map.canEdit', {guid: mapGUID});
		if (response.response) {
			return response.response;
		} else if ( mapGUID) {
			this.emMessage('No puede editar este mapa');
		} else {
			this.emMessage('Necesita iniciar sesión para poder crear un nuevo mapa');
		}
		return false;
		
	},	
	
	stopEdit: function()
	{
		this.saveFromForm();
		this.hideEditForm();
		this.showMapMetadata(this.mapGUID);
		this.layers[0].disableEdition();
	},

	getModifiedFeatures: function(justTheAttributes)
	{
		justTheAttributes =  (justTheAttributes != 'undefined')  ? true : false;
		
		var modifiedFeatures = [];
		$.each(this.layers, function(i, layer) {
			layerModifiedFeatures = layer.getModifiedFeatures(justTheAttributes);
			$.each(layerModifiedFeatures, function( j, feature )  {
				modifiedFeatures.push(feature);
			});
		});
		return modifiedFeatures;
	},
	
	
	getDeletedFeatures: function(justTheAttributes)
	{
		justTheAttributes = (justTheAttributes != 'undefined') ? true : false;
		var deletedFeatures = [];
		deletedFeatures = this.deleteQueue;
		// $.each(this.layers, function(i, layer) {
			// deletedFeatures.push(layer.getDeletedFeatures(justTheAttributes) );
		// });
		return deletedFeatures;
	},
	
	newMap: function()
	{
		this.mapGUID = false;
		this.edit();
	},
	
	saveFromForm: function()
	{
		if ( this.requireEditAccess( this.mapGUID ) ) {
			var metadata = $('#emMapSaveForm').formToArray();
		
			var modifiedFeatures = this.getModifiedFeatures();
			
			var toBeDeletedFeatures = this.getDeletedFeatures();
			this.save(metadata, modifiedFeatures,toBeDeletedFeatures);
			return true;
		}
		return false;
	},
	
	save: function(metadatax, modifiedFeatures, toBeDeletedFeatures)
	{	
		if ( this.requireEditAccess(this.mapGUID) ) {	
			data = {
				metadata: metadatax,
				features : modifiedFeatures,
				deleteFeatures : toBeDeletedFeatures
			};
			this.api('map.save', data);
		}

	}	
	
	
	
});