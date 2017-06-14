/**
 * Gmaps demo page
 */
(function() {
  'use strict';

  var latitude = 35.784,
    longitude = -78.670,
    mapZoom = 6;

  var mapOptions = {
    scrollwheel: false,
    center: new google.maps.LatLng(latitude, longitude),
    zoom: mapZoom,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById('google-container'), mapOptions);
  new google.maps.Marker({
    position: new google.maps.LatLng(latitude, longitude),
    map: map,
    visible: true
  });
})();
