/**
 * Gmaps demo page
 */
(function() {
  'use strict';

  /******** Base map ********/
  new google.maps.Map(document.getElementById('baseMap'), {
    center: {
      lat: -34.397,
      lng: 150.644
    },
    scrollwheel: false,
    zoom: 8
  });

 /******** Styled map ********/
  var styleArray = [{
    featureType: 'all',
    stylers: [{
      saturation: -80
    }]
  }, {
    featureType: 'road.arterial',
    elementType: 'geometry',
    stylers: [{
      hue: '#00ffee'
    }, {
      saturation: 50
    }]
  }, {
    featureType: 'poi.business',
    elementType: 'labels',
    stylers: [{
      visibility: 'off'
    }]
  }];
  new google.maps.Map(document.getElementById('styleMap'), {
    center: {
      lat: -34.397,
      lng: 150.644
    },
    scrollwheel: false,
    styles: styleArray,
    zoom: 8
  });

  /******** Satellite map ********/
  new google.maps.Map(document.getElementById('satelliteMap'), {
    center: {
      lat: -34.397,
      lng: 150.644
    },
    mapTypeId: google.maps.MapTypeId.SATELLITE,
    scrollwheel: false,
    zoom: 8
  });

  /******** Directions map ********/
  var chicago = {
    lat: 41.85,
    lng: -87.65
  };
  var indianapolis = {
    lat: 39.79,
    lng: -86.14
  };
  var directionsMap = new google.maps.Map(document.getElementById('directionsMap'), {
    center: chicago,
    scrollwheel: false,
    zoom: 7
  });
  var directionsDisplay = new google.maps.DirectionsRenderer({
    map: directionsMap
  });

  // Set destination, origin and travel mode.
  var request = {
    destination: indianapolis,
    origin: chicago,
    travelMode: google.maps.TravelMode.DRIVING
  };

  // Pass the directions request to the directions service.
  var directionsService = new google.maps.DirectionsService();
  directionsService.route(request, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      // Display the route on the map.
      directionsDisplay.setDirections(response);
    }
  });

  /******** Markers map ********/
  var myLatLng = {
    lat: -25.363,
    lng: 131.044
  };

  // Create a map object and specify the DOM element for display.
  var markersMap = new google.maps.Map(document.getElementById('markersMap'), {
    center: myLatLng,
    scrollwheel: false,
    zoom: 4
  });

  // Create a marker and set its position.
  new google.maps.Marker({
    map: markersMap,
    position: myLatLng,
    title: 'Hello World!'
  });
})();
