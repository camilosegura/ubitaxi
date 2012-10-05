var initialLocation;
var browserSupportFlag =  new Boolean();
var lat;
var long;

function initialize() {
	var myOptions = {
			zoom: 18,
			mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);


	// Try W3C Geolocation (Preferred)
	if(navigator.geolocation) {
		browserSupportFlag = true;
		navigator.geolocation.getCurrentPosition(function(position) {
			lat = position.coords.latitude;
			long = position.coords.longitude;
			initialLocation = new google.maps.LatLng(lat,long);
			map.setCenter(initialLocation);
			var cafeMarkerImage = new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=cafe|FFFF00');
			var cafeMarker = new google.maps.Marker({
				position: initialLocation,
				map: map,
				icon: cafeMarkerImage
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

	function handleNoGeolocation(errorFlag) {
		if (errorFlag == true) {
			alert("Falló el servicio de Geolocalización, recargue su navegador.");

		} else {
			alert('No fue posible ubicar su posicion su navegador no soporta Geolocalizaciòn.');      
		}
		$("#home-butons").hide();
	}
}

function pedido(e) {
	e.preventDefault();
	var nom = document.getElementById('nombre').value;
	var cel = document.getElementById('celular').value;
	var direc = document.getElementById('direccion').value;
	var mail = document.getElementById('email').value;
	var time = Math.round(+new Date()/1000);
	var Car = {'id_estado':0, 'id_pasajero':1, 'time':time, 'direccion_origen':direc, 'latitud':lat, 'longitud':long, 'id_operador': 1}
	var dd = {'Carreras':Car};
	
	$.getJSON('/ubitaxi/carreras/createFromPage.html', dd, function(msj){
		console.log(msj);
	})
	
	
	
	/*
	var queryString = '?lat=' + Ulat + '&lng=' + Ulng + '&radius=' + 10 + '&us=' + nom + '&ce=' + cel + '&di=' + direc + '&ub=' + ubicacion;
	downloadUrl("interpretapos.php" + queryString, function (dato){
		var xml = parseXml(dato);
		var markerNodes = xml.documentElement.getElementsByTagName("marker");
		var i = 0;
		var name = markerNodes[i].getAttribute("name");
		d1 = name;
		var address = markerNodes[i].getAttribute("address");
		var distance = parseFloat(markerNodes[i].getAttribute("distance"));
		alert('El taxi de placas ' + name + ' estara en 5 minutos, recuerde que su codigo son los cuatro ultimos digitos de su celular.');

	});
	*/

}

