/** Google map creation and maintenance (jquery.gmap.js). */
// TODO: use jquery.jmap.js (http://code.google.com/p/jmaps)
(function($) {
$.gmap = {
    DEFAULT_ICON: null,
    maps: {},
    markers: {},
    id: function(map) {
        for (var key in $.gmap.maps) {
            if ($.gmap.maps[key] == map)
                return key;
        }
        return '';
    },
    /** Center map, persist setting. */
    center: function(map, point, zoom) {
        var cookie = $.gmap.id(map) + '-center';
        if (point === undefined) {
            return $.gmap.cache(cookie);
        }
        map.setCenter(point, zoom);
        $.gmap.cache(cookie, point);
    },
    /** Cache geocoding information. */
    cache: function(address, latlng) {
        if (!address) return false;
        if (typeof(address) != 'string') return $.gmap.parseLatLng(value);
        var cookie = address.replace(/[^-a-zA-Z0-9]/g,'_');
        if (latlng === undefined) {
            if ($.cookie && $.cookie(cookie)) {
                var value = $.cookie(cookie).replace(/[+]/g, ' ');
                return $.gmap.parseLatLng(value);
            }
            return false;
        }
        if ($.cookie) 
          $.cookie(cookie, latlng, {path:'/', domain:'.<?php echo DOMAIN; ?>'});
    },
    scan_markers: function() {
        $('.gmapped').each(function() {
            for (var key in $.gmap.maps) {
              var map = $.gmap.maps[key];
              if (map.autoPopulate) {
                $.gmap.mark(map, this);
              }
            }
        });
    },
    getMarkerElements: function(marker) {
        for (var key in marker) {
            if (marker[key] && marker[key].length > 1
                && typeof(marker[key][0]) == 'object'
                && marker[key][0].nodeType) {
                return marker[key];
            }
        }
    },
    geocode: function(address, callback) {
        if (!address) return false;
        var cached = $.gmap.cache(address);
        if (cached) {
            callback(cached);
            return cached;
        }
        else {
            $.gmap.geocoder.getLatLng(address, function(point) {
                if (point) {
                    $.gmap.cache(address, point);
                }
                else {
                    //alert("Google lookup failed for " + address);
                }
                callback(point);
            });
            return false;
        }
    },
    parseLatLng: function(str) {
        if (typeof(str) == 'string') {
            if (str.match(/^ *\( *[-+]?[0-9.]+ *, *[-+]?[0-9.]+ *\) *$/g)) {
                var value = str.substring(1, str.length-1);
                return GLatLng.fromUrlValue(value);
            }
        }
        if (str && str.lat && str.lng) {
            if (typeof(str.lat) == 'function'
                && typeof(str.lng) == 'function') {
                return new GLatLng(str.lat(), str.lng());
            }
            return new GLatLng(str.lat, str.lng);
        }
        return false;
    },
    mark: function(map, options, callback) {
        callback = callback || function() { };
        if (typeof (options) == 'string') {
            options = { address:options };
        }
        if (!map) {
            callback(null, "<?php echo elgg_echo('gmap:nomap'); ?>");
            return;
        } 
        if (!options) {
            callback(null, "<?php echo elgg_echo('gmap:noopts'); ?>");
            return;
        }
        if (options.nodeType) {
            var elem = options;
            options = {
                latlng:$.gmap.parseLatLng($(elem).attr('latlng')),
                address:$(elem).attr('address'),
                origin:$(elem).attr('origin'),
                html:$(elem).html(),
                type:$(elem).attr('type')
            };
        }
        if (!options.latlng) {
            if (!options.address) {
                callback(null, "<?php echo elgg_echo('gmap:noloc'); ?>");
                return;
            }
            options.latlng = $.gmap.geocode(options.address, function(point) {
                if (point) {
                    options.latlng = point;
                    $.gmap.mark(map, options, callback);
                }
                else {
                    // TODO: notify app to clean up the address?
                    // TODO: maybe try a different service?  allow user
                    // fix? 
                    callback(null, "<?php echo elgg_echo('gmap:failed:geocode'); ?>");
                }
            });
            if (!options.latlng) return;
        } 
        var markers_url = IMAGES + 'markers/';
        var icon = $.gmap.DEFAULT_ICON;
        if (!icon) {
            icon = new GIcon();
            icon.image = markers_url + 'generic.png';
            icon.shadow = markers_url + 'shadow.png';
            icon.iconSize = new GSize(20,34);
            icon.shadowSize = new GSize(37,34);
            icon.iconAnchor = new GPoint(9,34);
            icon.infoWindowAnchor = new GPoint(9,2);
            icon.infoShadowAnchor = new GPoint(18,25);
            $.gmap.DEFAULT_ICON = icon;
        }
        options.type = options.type || 'generic';
        icon = new GIcon(icon);
        icon.image = markers_url + options.type + '.png';

        var old = $.gmap.markers[options.latlng];
        if (old) {
            map.removeOverlay(old);
        }
        var marker = new GMarker(options.latlng, {icon:icon});
        map.addOverlay(marker);
        $.gmap.markers[options.latlng] = marker;
        if (options.html) {
            GEvent.addListener(marker, "click", function() {
                marker.openInfoWindowHtml(options.html);
            });
            if (options.visible) {
              marker.openInfoWindowHtml(options.html);
            }
        }
        if (options.origin) {
            $(options.origin).click(function() {
                $.gmap.center(map, options.latlng);
                if (options.html) {
                  marker.openInfoWindowHtml(options.html);
                }
                return false;
            }); 
        }
        callback(marker);
    },
    mapCount: 1
};

$.fn.gmap = function(options) {

    if (options === undefined) {
        return $.gmap.maps[this.attr('id')];
    }

    // If we aren't supported, we're done
    if (!window.GBrowserIsCompatible || !GBrowserIsCompatible()) {
        return this;
    }

    if (!$.gmap.geocoder) {
        $.gmap.geocoder = new GClientGeocoder();
    }

    // Sanitize options
    if (!options || typeof options != 'object') {
        options = {};
    }
    options.mapOptions = options.mapOptions || {};
    options.markers = options.markers || {};
    options.controls = options.controls || {};

    // Map all our elements
    return this.each(function() {
        var address = options.address;
        var zoom = options.zoom;

        // Make sure we have a valid id
        if (!this.id) {
            this.id = "gmap" + $.gmap.mapCount++;
        }
        // Create a map and a shortcut to it at the same time
        var id = this.id;
        var map = $.gmap.maps[id] = new GMap2(this, options.mapOptions);
        if (!map) return;
        var center = $.gmap.center(map);
        map.setCenter(center?center:new GLatLng(20, 0), zoom);

        map.autoPopulate = options.autoPopulate !== false;
        if (!address) {
            address = $.gmap.center(map);
        }
        var latlng = $.gmap.parseLatLng(address);
        if (latlng) {
            $.gmap.center(map, latlng, zoom);
        }
        else {
            latlng = $.gmap.cache(address);
            if (latlng) {
                $.gmap.center(map, latlng, zoom);
            }
            else {
                $.gmap.geocode(address, function(point) {
                    if (point) {
                        $.gmap.cache(address, point);
                        $.gmap.center(map, point, zoom);
                    }
                    else {
                        // TODO: notify app of error 
                    }
                });
            }
        }
        // Add controls to our map
        var i;
        for (i = 0; i < options.controls.length; i++) {
            var c = options.controls[i];
            eval("map.addControl(new " + c + "());");
        }
        // If we have markers, put them on the map
        if (options.markers) {
          $(options.markers).each(function() {
              $.gmap.mark(map, this);
          });
        }
        // Scan the rest of the page for markers
        if (map.autoPopulate) {
            $.gmap.scan_markers();
        }
    });
};

$(window).unload(function() { GUnload(); });
})(jQuery);