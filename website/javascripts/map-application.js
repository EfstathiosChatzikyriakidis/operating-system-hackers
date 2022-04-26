/*
 *  Copyright (C) 2012  Efstathios Chatzikyriakidis <stathis.chatzikyriakidis@gmail.com>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

var map = null;
var markerClusterer = null;
var geocoder = null;
var typeIcons = [];
var markers = [];

var markerIconWidth = 25;
var markerIconHeight = 25;

var mapCenterLat = 40.668178;
var mapCenterLng = 22.911115;

var clusterGridSize = 50;
var searchZoomLevel = 15;
var locateZoomLevel = 19;

var defaultIcon = new GIcon (G_DEFAULT_ICON);

var dialogOptions = {
  autoOpen  : false,
  resizable : false,
  draggable : false,
  width     : 560,
  show      : "fade",
  hide      : "fade",
  height    : 'auto',
  modal     : true
};

GMap2.prototype.hoverControls = function () {
  var theMap = this;

  theMap.showControls ();

  GEvent.addListener (theMap, "mouseover", function () {
    theMap.showControls ();
  });

  GEvent.addListener (theMap, "mouseout", function () {
    theMap.hideControls ();
  });
}

GMap.prototype.hoverControls = GMap2.prototype.hoverControls;

function makeIcon (image) {
  var icon = new GIcon (G_DEFAULT_ICON);

  icon.iconSize = new GSize (markerIconWidth, markerIconHeight);
  icon.image = image;
  icon.shadow = null;

  return icon;
}

function showAddress (address, addMarker, zoomLevel) {
  geocoder.getLatLng (address, function (point) {
    if (point) {
      map.setCenter (point, zoomLevel);

      if (addMarker) {
        map.addOverlay (new GMarker (point));
      }
    }
  });
}

function locateUs (coordinates, zoomLevel) {
  var separated = coordinates.split (",");

  var point = new GLatLng (parseFloat (separated[0]), parseFloat (separated[1]));

  map.setCenter (point, zoomLevel);
}

function initializeMapApplication () {
  if (GBrowserIsCompatible ()) {
    map = new GMap2 (document.getElementById ('map_canvas'));

    map.setCenter (new GLatLng (mapCenterLat, mapCenterLng), 2);

    map.setUIToDefault ();
    map.enableContinuousZoom ();
    map.hoverControls ();
    map.enableRotation ();

    G_PHYSICAL_MAP.getMinimumResolution = function () { return 2 };
    G_NORMAL_MAP.getMinimumResolution = function () { return 2 };
    G_SATELLITE_MAP.getMinimumResolution = function () { return 2 };
    G_HYBRID_MAP.getMinimumResolution = function () { return 2 };

    geocoder = new GClientGeocoder ();

    createTypeIcons ();

    $.get ("type-generate-markers-xml.php", function (xml) {
      if (xml.documentElement != null) {
        handleMapData (xml.documentElement.getElementsByTagName ("marker"));
      }
    });
  }
}

function createTypeIcons () {
  var typesString = $('#typesData').text ();

  if (typesString != '[]') {
    var typesArray = eval ('(' + typesString + ')');

    for (var type in typesArray) {
      typeIcons[type] = makeIcon ("graphics/markers-icons/" + typesArray[type]);
    }
  }
}

function refreshMap () {
  if (markerClusterer && markerClusterer.clearMarkers) {
    markerClusterer.clearMarkers ();
  }

  map.clearOverlays ();

  markerClusterer = new MarkerClusterer (map, markers, { gridSize: clusterGridSize });
}

function handleMapData (elements) {
  markers = [];

  for (var i = 0; i < elements.length; i++) {
    var mid     = elements[i].getAttribute ("mid");
    var name    = elements[i].getAttribute ("name");
    var tid     = elements[i].getAttribute ("tid");
    var point   = new GLatLng (parseFloat (elements[i].getAttribute ("lat")),
                               parseFloat (elements[i].getAttribute ("lng")));

    var marker = createMarker (mid, point, name, tid);

    markers.push (marker);
  }

  refreshMap ();
}

function maximize () {
  window.moveTo (0, 0);
  window.resizeTo (screen.availWidth, screen.availHeight);
}

function createMarker (mid, point, name, tid) {
  var icon = defaultIcon;

  if (typeIcons.length != 0) {
    icon = typeIcons[tid];
  }

  var marker = new GMarker (point, { title: name, icon: icon });

  var iframe = "<iframe style='width: 100%; height: 400px; border: 0px;' src='show-marker-data.php?mid=" + mid + "'></iframe>";

  GEvent.addListener (marker, "click", function () {
    $("#markerDialogWidget").html (iframe).dialog ("open");
  });

  return marker;
}

(function ($) {
  $(document).ready (function () {
    $("#markerDialogWidget").dialog (dialogOptions);

    $('#type_selection').change (function () {
      var requestData = { tid: $(this).val () };

      $.get ("type-generate-markers-xml.php", requestData, function (xml) {
        if (xml.documentElement != null) {
          handleMapData (xml.documentElement.getElementsByTagName ("marker"));
        }
      });
    });

    $('#search_button').click (function (event) {
      event.preventDefault ();

      var requestData = { keywords: $('#search_keywords').val () };

      $.get ("search-generate-markers-xml.php", requestData, function (xml) {
        if (xml.documentElement != null) {
          handleMapData (xml.documentElement.getElementsByTagName ("marker"));
        }
      });
    });

    $('#loading_image')
      .hide ()
      .ajaxStart (function () { $(this).show (); })
      .ajaxStop  (function () { $(this).hide (); });
  });
}) (jQuery);
