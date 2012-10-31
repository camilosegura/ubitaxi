var initialLocation;
var browserSupportFlag =  new Boolean();
var map = "";
var oldLat = 0;
var oldLng = 0;
//var revGoeUrl = "http://maps.googleapis.com/maps/api/geocode/json";
var revGoeUrl = "http://google.com";
var cafeMarker = "";

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
                'http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=cafe|FFFF00', 
                null, 
                null, 
                null, 
                new google.maps.Size(60, 90));           
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
        });
    }
    // Browser doesn't support Geolocation
    else {
        browserSupportFlag = false;
        handleNoGeolocation(browserSupportFlag);
    }	
}

function handleNoGeolocation(errorFlag) {
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
            alert(resp[0].formatted_address);
            $("#direccion").val(resp[0].formatted_address);
        }                    
                    
    });
}

function setLatLng(){
    $("#latitud").val(oldLat);
    $("#longitud").val(oldLng);
}
//initialize();

