if(askUserGeoLocation) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      lat = position.coords.latitude;
      lng = position.coords.longitude;
      map.setView([lat, lng]);
    }, function() {
      //handleLocationError(true, infoWindow, map.getCenter());
    });
  }
}

var map = L.map('map').setView([lat, lng], z);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var routeStartStatus = false;
var routeEndStatus = false;
var routeStart = '';
var routeEnd = '';

var polyline = '';

var routeStartLat = 0;
var routeStartLng = 0;

var routeEndLat = 0;
var routeEndLng = 0;

function showRouteStartCSS() {
  $("#start_route_input_box").addClass('selected');
}

function hideRouteStartCSS() {
  $("#start_route_input_box").removeClass('selected');
}

function showRouteEndCSS() {
  $("#end_route_input_box").addClass('selected');
}

function hideRouteEndCSS() {
  $("#end_route_input_box").removeClass('selected');
}

function toggleRouteStart() {
  routeEndStatus = false;
  hideRouteEndCSS();
  if (routeStartStatus) {
    routeStartStatus = false;
    hideRouteStartCSS();
  } else {
    routeStartStatus = true;
    showRouteStartCSS();
  }
}

function toggleRouteEnd() {
  routeStartStatus = false;
  hideRouteStartCSS();
  if (routeEndStatus) {
    routeEndStatus = false;
    hideRouteEndCSS();
  } else {
    routeEndStatus = true;
    showRouteEndCSS();
  }
}

function search(str) {
  $("#directions-wrap").hide();
  $("#result-box").html("");
  $("#result-box").show();
  $.ajax({ 
    type: 'GET', 
    url: "https://nominatim.openstreetmap.org/search.php?q="+str+"&countrycodes=pt&format=json", 
    data: { get_param: 'value' }, 
    dataType: 'json',
    success: function (data) { 
      $.each(data, function(index, element) {
        var result = '';

        result += '<div class="result" onclick="zoom('+element.lat+', '+element.lon+')">';
        result += '<div class="name" title="'+element.display_name+'">'+element.display_name+'</div>';
        
        if (typeof element.icon !== 'undefined') {          
          var img_src = element.icon;
        } else {
          var img_src = 'https://nominatim.openstreetmap.org/ui/mapicons/poi_place_village.p.20.png';
        }
        result += '<img src="'+img_src+'" title="'+element.type+'">';        
        
        result += '<div class="coor"><label>Lat.:</label><span>'+element.lat+'</span><label> Long.:</label><span>'+element.lon+'</span></div>';
        result += '</div>';

        $('#result-box').append(result);
      });
    }
  });
}

function zoom(x, y) {
  map.panTo(new L.LatLng(x, y));	
}

function getWeather(lat, lng) {
  $.ajax({
    dataType: "json",
    url: baseURL+"/api/weather?lat="+lat+"&lon="+lng, 
    success: function(result){
      var weather = result.current;
      
      $("#current-weather .temp").html(weather.temp + 'ºC');
      $("#current-weather .cond").html(weather.cond_txt);
      $("#current-weather .humid").html(weather.humidity + '% '+humidityName);
    }
  });
}

function getStreet(lat, lng) {
  $('#map-info').html("");
  
  $.ajax({ 
    type: 'GET', 
    url: "https://nominatim.openstreetmap.org/reverse?format=xml&lat="+lat+"&lon="+lng+"&zoom=18", 
    data: { get_param: 'value' }, 
    dataType: 'xml',
    success: function (data) {
      $(data).find("reversegeocode").each(function(){
        var result1 = $(this).find("result").text();
        $('#map-info').append(result1);
      });     
    }
  });
}

function mapUpdate(e) {
  var lat = e.latlng.lat;
  var lng = e.latlng.lng;

  getStreet(lat, lng);
  getWeather(lat, lng); 
}

window.onload = function() {
  getStreet(lat, lng);
  getWeather(lat, lng);
};

map.on('mouseover', function(e) {
  mapUpdate(e); 
});

map.on('mouseup', function(e) {
  mapUpdate(e); 
});

function removePolyline() {
  if (polyline != '') {
    map.removeLayer(polyline);
  }
}

function removeStartMarker() {
  if (routeStart != '') {
    map.removeLayer(routeStart);
  }
  removePolyline();
}

function addStartMarker(e) {
  var defaultIcon = L.icon({
    iconUrl: baseURL+'/assets/images/location-pin.png',
    iconSize: [48, 48]
  });

  routeStartLat = e.latlng.lat;
  routeStartLng = e.latlng.lng;
  routeStart = new L.marker(e.latlng, {
    icon: defaultIcon
  }).addTo(map);
}

function removeEndMarker() {
  if (routeEnd != '') {
    map.removeLayer(routeEnd);
  }
  removePolyline();
}

function addEndMarker(e) {
  var defaultIcon = L.icon({
    iconUrl: baseURL+'/assets/images/location-pin.png',
    iconSize: [48, 48]
  });

  routeEndLat = e.latlng.lat;
  routeEndLng = e.latlng.lng;
  routeEnd = new L.marker(e.latlng, {
    icon: defaultIcon
  }).addTo(map);
}

map.on('click', function(e){

  if (routeStartStatus) {
    removeStartMarker();
    addStartMarker(e);
  }

  if (routeEndStatus) {
    removeEndMarker();
    addEndMarker(e);
  }

  if (routeEnd != '' && routeStart != '') {
    getRoute();
  }
    
});

function getRoute() {
  showDirectionsLoading();
  $.ajax({
    dataType: "json",
    url: baseURL+"/api/map/directions?from_lat="+routeStartLat+"&from_lng="+routeStartLng+"&to_lat="+routeEndLat+"&to_lng="+routeEndLng, 
    success: function(result){
      console.log('Directions', result);
      var points = result.coordinates;

      removePolyline();
      polyline = L.polyline(points, {color: polylineColor}).addTo(map);


      showDirections(result.steps);
    }
  });
}


function showDirectionsLoading() {
  $("#result-box").hide();
  $("#directions-wrap").show();
  $('#directions-box').html("");
  $("#directions-loading_box").show();
}

function showDirections(directions) {
  $('#directions-box').html("");
  $('#directions-wrap').show();
  $.each(directions, function(index, direction) {
    var result = '';

    result += '<div class="direction">';

    result += '<div class="icon"><img title="'+direction.type.title+'" src="'+baseURL+direction.type.icon+'"></div>';

    result += '<div class="info">';
    result += '<div class="name">'+direction.name+'</div>';
    result += '<div class="instruction">'+direction.instruction+'</div>';
    result += '</div>';

    result += '<div class="details">';
    result += '<div class="distance" title="Distance">'+direction.distance+'mt</div>';
    result += '<div class="duration">'+direction.duration+'sec</div>';
    result += '</div>';
    
    /*
    direction.icon based on direction.type
    if (typeof direction.icon !== 'undefined') {          
      var img_src = element.icon;
    } else {
      var img_src = 'https://nominatim.openstreetmap.org/ui/mapicons//poi_place_village.p.20.png';
    }
    result += '<img src="'+img_src+'" title="'+element.type+'">';        
    */

    result += '</div>';    
    $('#directions-box').append(result);
  });
  $("#directions-loading_box").hide();
}

var locationMarkers = [];

function removeLocations() {
  locationMarkers = [];
}

function locationAsEndMarker(i) {
  removeEndMarker();
  map.closePopup();

  //routeEnd = locationMarkers[i].popup;
  routeEndLat = locationMarkers[i].coords.lat;
  routeEndLng = locationMarkers[i].coords.lng;

  getRoute();
}

function addLocations(locations) {
  removeLocations();

  var defaultIcon = L.icon({
    iconUrl: 'https://www.estevesweb.pt/assets/images/location-pin.png',
    iconSize: [25, 25]
  });

  for (var i = 0; i < locations.length; i++) {

    var popUpMarker = '';

    if (typeof locations[i].html !== 'undefined') {
      popUpMarker += locations[i].html;
    } else {

      if (typeof locations[i].image !== 'undefined' && typeof locations[i].image.src !== 'undefined') {
        popUpMarker += '<img src="' + locations[i].image.src + '">';
      }

      if (typeof locations[i].name !== 'undefined') {
        popUpMarker += '<p class="name">' + locations[i].name + '</p>';
      }

      if (typeof locations[i].address !== 'undefined') {
        popUpMarker += '<p class="address"><i class="fa fa-home" aria-hidden="true"></i>' + locations[i].address + '</p>';
      }

      if (typeof locations[i].phone !== 'undefined') {
        popUpMarker += '<p class="phone"><i class="fa fa-phone" aria-hidden="true"></i>' + locations[i].phone + '</p>';
      }

      if (typeof locations[i].email !== 'undefined') {
        popUpMarker += '<p class="email"><i class="fa fa-at" aria-hidden="true"></i>' + locations[i].email + '</p>';  
      }

      if (typeof locations[i].url !== 'undefined') {
        popUpMarker += '<p class="url"><i class="fa fa-external-link" aria-hidden="true"></i><a target="_parent" href="' + locations[i].url + '">'+viewMoreInfoTxt+'</a></p>';
      }

    }

    popUpMarker += '<div onclick="locationAsEndMarker('+i+')">'+markAsDestinationTxt+'</div>';

    locationMarkers[i] = {
      popup: L.popup({
        className: 'esteves-map-popup'
      }).setContent(popUpMarker),
      coords: {
        lat: locations[i].coords.lat,
        lng: locations[i].coords.lng
      }
    }

    var options = {};

    if (typeof locations[i].icon !== 'undefined') {
      options.icon = L.icon(locations[i].icon);
    } else {
      options.icon = defaultIcon;
    }

    L.marker([locations[i].coords.lat, locations[i].coords.lng], options).addTo(map).bindPopup(locationMarkers[i].popup);

  }
}

window.addEventListener('message', (event) => {
  data = JSON.parse(event.data);

  if (typeof data.locations !== 'undefined') {
    addLocations(data.locations);
  }
});

$("#toggle_side_hide").on("click", function() {
  //alert( "Handler for .click() called." );
  $("#side-box").addClass('hidden');
  $("#map-box").addClass('full');
  $("#toggle_side_show").removeClass('hidden');
});

$("#toggle_side_show").on("click", function() {
  //alert( "Handler for .click() called." );
  $("#side-box").removeClass('hidden');
  $("#map-box").removeClass('full');
  $("#toggle_side_show").addClass('hidden');
});