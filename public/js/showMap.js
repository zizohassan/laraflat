function showMap() {
    if ($("#showMap").length != 0) {
        var pos = {
            lat: $("#showMap").data('lat'),
            lng: $("#showMap").data('lng')
        }
        map = new google.maps.Map(document.getElementById('showMap'), {
            center: pos,
            zoom: 15
        });
        var marker = new google.maps.Marker({
            map: map
        });
        marker.setPosition(pos);
    }
}
showMap();