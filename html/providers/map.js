let map;
let marker;
let circle;

function initMap() {
    const initialPosition = { lat: 48.857613, lng: 2.351387 };
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: initialPosition,
    });

    marker = new google.maps.Marker({
        position: initialPosition,
        map: map,
        title: "My Location",
    });

    circle = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map: map,
        center: initialPosition,
        radius: 0, 
    });


    document.getElementById('radiusSlider').addEventListener('input', function () {
        const radiusInKm = this.value;
        circle.setRadius(radiusInKm * 1000);
    });
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const userPosition = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(userPosition);
            marker.setPosition(userPosition);
            circle.setCenter(userPosition);
        }, function () {
            handleLocationError(true, map.getCenter());
        });
    } else {
        handleLocationError(false, map.getCenter());
    }
    const input = document.getElementById('place-input');
    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    autocomplete.setFields(['geometry']); 

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
        }

        map.setCenter(place.geometry.location);
        map.setZoom(17);

        marker.setPosition(place.geometry.location);
        circle.setCenter(place.geometry.location);
    });

}


function handleLocationError(browserHasGeolocation, pos) {
    console.error(browserHasGeolocation ?
        "Erreur: Le service de géolocalisation a échoué." :
        "Erreur: Votre navigateur ne supporte pas la géolocalisation.");
    map.setCenter(pos);
}



window.initMap = initMap;
