jQuery.extend( ElggMap.prototype, {
	api: function(what, data, async)
	{
		async = ( async === undefined ) ? false : true;

		if ( !async ) {
			$.ajaxSetup({ async:false });
		}
		data = $.extend( data, { what: what } );
		
		var response = jQuery.post( ELGG_MAPS_WEBPATH + 'json.php', data );

		if ( !async ) {
			$.ajaxSetup({ async:true});
		}
		if ( response.statusText ==  'error' ) {
			this.error( 'Error del servidor' );
			return false;
		}
		
		var ret = $.parseJSON( response.responseText );
		if ( !ret ) {
			return false;
		}
		
		if ( ret.emError === undefined ) {
			return ret;
		} else {
			this.emMessage( ret.emError );
		}
	}
});