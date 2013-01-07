var initialLocation;
var browserSupportFlag =  new Boolean();
var map = "";
var oldLat = 0;
var oldLng = 0;
//var revGoeUrl = "http://maps.googleapis.com/maps/api/geocode/json";
var revGoeUrl = "http://google.com";
var cafeMarker = "";
var direccion = ""

function initialize() {
    var myOptions = {
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
        }
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
    // Try W3C Geolocation (Preferred)
    if(navigator.geolocation) {
        browserSupportFlag = true;
        navigator.geolocation.getCurrentPosition(function(position) {
            oldLat = position.coords.latitude;
            oldLng = position.coords.longitude;
            setLatLng();
            initialLocation = new google.maps.LatLng(oldLat,oldLng);
            map.setCenter(initialLocation);
            handleRevGeocoder(initialLocation);
            var cafeMarkerImage = new google.maps.MarkerImage(
                'http://maps.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png', 
                null, 
                null, 
                null, 
                new google.maps.Size(90, 90));           
            cafeMarker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                icon: cafeMarkerImage,
                draggable:true
            });
            google.maps.event.addListener(cafeMarker, "dragend", function(event) {
                var point = cafeMarker.getPosition();                               
                oldLng = point.lng();
                oldLat = point.lat();
                handleRevGeocoder(point);     
                setLatLng();
            });
            google.maps.event.addListener(map, "click", function(event) {
                var point = event.latLng;
                oldLng = point.lng();
                oldLat = point.lat();
                handleRevGeocoder(event.latLng);   
                cafeMarker.setPosition(event.latLng);
                map.panTo(event.latLng);
                setLatLng();                
            });            
        }, function() {
            handleNoGeolocation(browserSupportFlag);
        }, { enableHighAccuracy: true });
    }
    // Browser doesn't support Geolocation
    else {
        browserSupportFlag = false;
        handleNoGeolocation(browserSupportFlag);
    }	
}
function handleNoGeolocation(errorFlag) {
	alert('code: '    + errorFlag.code    + '\n' +
            'message: ' + errorFlag.message + '\n');
    if (errorFlag == true) {
    	
        alert("Falló el servicio de Geolocalización, recargue su navegador.");

    } else {
        alert('No fue posible ubicar su posicion su navegador no soporta Geolocalizaciòn.');      
    }
    $("#home-butons").hide();
}
function handleRevGeocoder(point){
    (new google.maps.Geocoder()).geocode({
        latLng: point
    }, function(resp) {        
        if (resp[0]) {                       
            cafeMarker.setTitle(resp[0].formatted_address);
            direccion = resp[0].formatted_address;
            $("#direccion").val(resp[0].formatted_address);
        }                    
/**
 * Implementar esta funcion en su propio archivo js, es una funcion de 
 * callback
 * @returns {undefined}
 */  
        callbackRevGeocoder(resp);
    });
}

function setLatLng(){
    $("#latitud").val(oldLat);
    $("#longitud").val(oldLng);
}


