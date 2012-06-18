jQuery.extend( ElggMap.prototype, {
		emMessage: function(message)
		{
			if ('emMap_unavailable' === message) {
				message = 'No puede acceder a este mapa';
			}
		
			if ($('#emMessageBox').length === 0) {
				$("body").append("<div id='emMessageBox'>"+message+"</div>");
			} else {
				$('#emMessageBox').html(message);
			}
			
			$('#emMessageBox').dialog({ title: false, modal: true });
		},
		
		
		showMapMetadata: function( mapGUID )
		{
			$('#ui-layout-west').load( ELGG_MAPS_WEBPATH+'json.php', {
				'what': 'dialog.mapMetadata',
				'guid': mapGUID
			}, jQuery.proxy( function() {
				$('#emMapEditButton').click( jQuery.proxy( this.edit, this ) );
			} , this) );
		},

		
		showVisibleMaps: function()
		{
			$('#ui-layout-west').load( ELGG_MAPS_WEBPATH+'json.php', {
				'what': 'dialog.visibleMaps'
			});
			
		},
		
		buildLayout: function()
		{
			this.myLayout = $('body').layout({
			//	enable showOverflow on west-pane so CSS popups will overlap north pane
				west__showOverflowOnHover: false
			//	reference only - these options are NOT required because 'true' is the default
			,	closable:				true	// pane can open & close
			,	resizable:				false	// when open, pane can be resized 
			,	slidable:				true	// when closed, pane can 'slide' open over other panes - closes on mouse-out



			//	some resizing/toggling settings
			,	north__size:			120
			,	north__resizable:		false	
			,	north__slidable:		false	// OVERRIDE the pane-default of 'slidable=true'
			,   north__closable: false
			,	north__spacing_closed:	20		// big resizer-bar when open (zero height)
			,	south__resizable:		false	// OVERRIDE the pane-default of 'resizable=true'
			,	south__spacing_open:	0		// no resizer-bar when open (zero height)
			,	south__spacing_closed:	20		// big resizer-bar when open (zero height)
			//	some pane-size settings
			,	west__minSize:			100
			,	east__size:				300
			,	east__minSize:			200
			,	east__maxSize:			Math.floor(screen.availWidth / 2) // 1/2 screen width
			,	center__minWidth:		100
			,	useStateCookie:			true
			});	
		},
		
		
		showLoginForm: function()
		{
			$('.ui-layout-north').load(ELGG_MAPS_WEBPATH+'json.php', {
				'what' : 'user.showLoginForm',
				'complete':  function() {
				$('#login-box > form').ajaxForm();}
			});
		},
		
	
		showEditForm: function()
		{
			$('#ui-layout-west').load(ELGG_MAPS_WEBPATH+'json.php', {
				'what' : 'dialog.map.edit',
				'guid' : this.mapGUID
			}, jQuery.proxy( function() {
				$('#emMapStopEditButton').click( jQuery.proxy( this.stopEdit, this ) );	
				$('#emMapCancelEditButton').click( function() { window.location=window.location} );				
			}, this) );
			//$('#mapSidebar > #formContainer').show();

			
		},

		hideEditForm: function()
		{
			$('#ui-layout-west').html('');
		}
});