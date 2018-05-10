/*
    PLEASE INCLUDE THE GOOGLE MAPS API LIBRARY BEFORE THIS ONE.
    Example : <script src="http://maps.google.com/maps/api/js?key=YourApiKey" type="text/javascript"></script>
 */
/**
 * @param {jQuery} mapDomElement
 * @param {Array}  locations if you'd like to place markers on the map. Format is :
 * [
 *   [string Description, float Latitude, float Longitude],
 *   ['My home', -33.923036, 151.259052],
 * ]
 */
function initMap(mapDomElement, locations)
{
    if (typeof locations === 'undefined') {
        locations = [];
    }

    var map = new google.maps.Map(mapDomElement, {
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var infoWindow = new google.maps.InfoWindow();
    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < locations.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });
        bounds.extend(marker.position);
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(locations[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));
    }

    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
        map.setZoom(3);
        google.maps.event.removeListener(listener);
    });
}
