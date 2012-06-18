<?php
	//script para activar marcadores, popup.js needs rename
?>
<script language='javascript' type='text/javascript'>
var addViewVars = <?php echo json_encode($vars['varsForAddView']);?>;
var currentPopup;
var currentMarker;
var addPointFormHTML;
//var userLayer;
var markersLayer;
var savedMarkersLayer;

var stablePoints = {};

function activateMarkers()
{
	map.events.register('click',map,markAndPop);
}
function deactivateMarkers()
{
	markersLayer.clearMarkers();
	if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
	if(currentMarker != null) {markersLayer.clearMarkers();currentMarker = null;}
	map.events.unregister('click',map,markAndPop);
}
function deleteMarkerByMid(mid)
{
	$.each(savedMarkersLayer, function(index, value){
		if(value.mid == mid) savedMarkersLayer.removeMarker(savedMarkersLayer.markers[index]);
	});
	if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
}
function markAndPop(e)
{
	OpenLayers.Event.stop(e);
	emAddMarker(map.getLonLatFromPixel(e.xy));
}

function emAddMarker(ll)
{
	markersLayer.clearMarkers();
	if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
	//if(currentMarker != null) {currentMarker.destroy();currentMarker = null;}
	
	var marker = new OpenLayers.Marker(ll,defaultIcon.clone());
	var addPointFormHTML = "<form id='pointForm'>";
	addPointFormHTML += "<p style='margin:0 0 3px 0;'>Title<br /><input class='input-text' id='pointName' /></p>";
	addPointFormHTML += "<p style='margin:0 0 3px 0;'>Description<br /><textarea style='height:98px' class='input-textarea' id='pointDescription'></textarea></p>";
	addPointFormHTML += "<p style='margin:0 0 3px 0;'><input class='submit_button' type='submit' value='Save' id='pointSubmit' /></p>";
	addPointFormHTML += "<input type='hidden' id='mid' value='"+Math.floor(Math.random()*10000000)+"' />";
	addPointFormHTML += "</form>";
	var anchor = {'size':new OpenLayers.Size(0,0),'offset':new OpenLayers.Pixel(0,0)};
	
	var popup = new OpenLayers.Popup.FramedCloud(
		"popup",
		ll,
		new OpenLayers.Size(450, 300),
		addPointFormHTML,
		anchor,
		true
	);
	popup.autoSize = true;
	popup.maxSize = new OpenLayers.Size(450,300);
	popup.minSize = new OpenLayers.Size(350,300);
	
	
	map.addPopup(popup);
	currentMarker = marker;
	currentPopup = popup;
	markersLayer.addMarker(marker);
}
function emFixateMarker(ll,title,description,mid)
{
	markersLayer.clearMarkers();
	if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
	
	var marker = new OpenLayers.Marker(ll,defaultIcon.clone());
	marker.title = title;
	marker.description = description;
	marker.mid = mid;
	savedMarkersLayer.addMarker(marker);
	
	marker.events.register('click',marker,function(e){
		markersLayer.clearMarkers();
		if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
		
		var content = "<form id='pointForm'>";
		content += "<p style='margin:0 0 3px 0;'>Title<br /><input class='input-text' id='pointName' value='"+this.title+"' /></p>";
		content += "<p style='margin:0 0 3px 0;'>Description<br /><textarea style='height:98px' class='input-textarea' id='pointDescription'>"+this.description+"</textarea></p>";
		content += "<p style='margin:0 0 3px 0;'><input class='submit_button' type='submit' value='Update' id='pointSubmit' />";
		content += "&nbsp;<input class='submit_button' type='button' value='Delete' id='pointDelete' /></p>";
		content += "<input type='hidden' id='mid' value='"+this.mid+"' />";
		content += "</form>";
		
		var anchor = {'size':new OpenLayers.Size(0,0),'offset':new OpenLayers.Pixel(0,0)};
		
		var popup = new OpenLayers.Popup.FramedCloud(
			"popup",
			this.lonlat,
			new OpenLayers.Size(450, 300),
			content,
			anchor,
			true
		);
		popup.autoSize = true;
		popup.maxSize = new OpenLayers.Size(450,300);
		popup.minSize = new OpenLayers.Size(350,300);
		map.addPopup(popup);
		currentPopup = popup;
		currentMarker = this;
	});
}
/*
// habria que usar FEATURES
*/
var styleMap = new OpenLayers.StyleMap({
	externalGraphic:ELGG_MAPS_WEBPATH + "graphics/PinDown1.png",
	graphicWidth:32,
	graphicHeight:39,
	graphicXOffset:-7,
	graphicYOffset:-35
});
var vectorLayer = new OpenLayers.Layer.Vector('Vector Layer',{styleMap:styleMap});
var vectorHandler;

function addVector(lon, lat, featuretype, label, clearFeatures, zoomToFeature, selectFeature) {
    // remove old features of same type if clearOthers is true
    if (clearFeatures) {
        feats = markerLayer.features;
        for(i = 0; i < feats.length; i++) {
            if (feats[i].attributes.type == featuretype) markerLayer.removeFeatures(feature);
        }
    }
 
    // Add new feature
    //point = new OpenLayers.Geometry.Point(lon, lat);
    //OpenLayers.Projection.transform(point, map.displayProjection, map.getProjectionObject());
    label = '<div>' + label + "</div>";
    //label += '<br /><div><a href="#" onclick="zoomTo(' + point.x + ', ' + point.y + ', 8); return false">Zoom to Feature</a></div>';
    feature = new OpenLayers.Feature(new OpenLayers.LonLat(lon,lat));
	//feature.events.register('click',userLayer,function(e){OpenLayers.Event.stop(e);});
 
    userLayer.addFeatures(feature);
 
    // zoom to feature if zoomToFeature is true
    //if (zoomToFeature) {
    //    if (!feature.onScreen() || map.getZoom() < <img src="http://fuzzytolerance.info/wp-includes/images/smilies/icon_cool.gif" alt="8)" class="wp-smiley"> {
    //        zoomToLonLat (lon, lat, 8);
    //    }
    //}
 
    // open feature popup if map width greater than 500 pixels (hides on portables)
    //if (selectFeature && $("#map").width() > 500 ) selectControl.select(feature);
}
function emAddVector(e)
{
	//OpenLayers.Event.stop(e);
	addMarker(map.getLonLatFromPixel(e.xy).lon,map.getLonLatFromPixel(e.xy).lat,0,"hola");
}

////////////////////////////////////////////////////////////////
////////// version anterior, usando features no se para que, ojo
function emFixateVector(ll,title,description)
{
	markersLayer.clearMarkers();
	if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
	
	AutoSizeFramedCloudMaxSize = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
		'autoSize': true, 
		'minSize': new OpenLayers.Size(350, 300),
		'maxSize': new OpenLayers.Size(450, 300)
	});
	var feature = new OpenLayers.Feature(savedMarkersLayer, ll); 
	feature.closeBox = true;
	feature.popupClass = AutoSizeFramedCloudMaxSize;
	var addPointFormHTML = "<form id='pointUpdateForm'>";
	addPointFormHTML += "<p style='margin:0 0 3px 0;'>Title<br /><input class='input-text' id='pointName' value='"+title+"' /></p>";
	addPointFormHTML += "<p style='margin:0 0 3px 0;'>Description<br /><textarea style='height:98px' class='input-textarea' id='pointDescription'>"+description+"</textarea></p>";
	addPointFormHTML += "<p style='margin:0 0 3px 0;'><input class='submit_button' type='submit' value='Update' id='pointSubmit' /></p>";
	addPointFormHTML += "<input type='hidden' id='fid' value='"+feature.id+"' />";
	addPointFormHTML += "</form>";
	feature.data.popupContentHTML = addPointFormHTML;
	feature.data.overflow = "auto";
	feature.data.icon = defaultIcon.clone();
	
	feature.createMarker();
	feature.marker.parent = feature;
	savedMarkersLayer.addMarker(feature.marker);
	
	feature.createPopup(feature.closeBox);
	console.debug(feature.popup);
	
	feature.marker.events.register('click',feature,function(e){
		markersLayer.clearMarkers();
		if(currentPopup != null) {currentPopup.destroy();currentPopup = null;}
		this.popup.toggle();
	});
	
	feature.popup.hide();
	map.addPopup(feature.popup);
}

jQuery(document).ready(function(){
	customVars = <?php echo json_encode($vars['customVars']) ?>;
	markersLayer = new OpenLayers.Layer.Markers('Markers');
	savedMarkersLayer = new OpenLayers.Layer.Markers('Saved Markers');
	map.addLayers([markersLayer,savedMarkersLayer]);

	activateMarkers();
	
	$('#pointForm').live('submit',function(e){
		var ll = currentMarker.lonlat;
		markersLayer.removeMarker(currentMarker);
		title = $(this).find('input#pointName').val();
		desc = $(this).find('textarea#pointDescription').val();
		mid = $(this).find('input#mid').val();
		//search for existing mid
		var savedMarkers = savedMarkersLayer.markers;
		$.each(savedMarkers, function(index, value){
			if(value.mid == mid) savedMarkersLayer.removeMarker(savedMarkersLayer.markers[index]);
		});
		emFixateMarker(ll,title,desc,mid);
		return false;
	});
	
});
</script>