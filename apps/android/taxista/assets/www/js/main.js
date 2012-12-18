var oldLat = 4.63394876;
var oldLng = -74.07235247;
var oldSpeed = 0; 
var oldAlt = 0;
var oldTime = 0;
var idTelefono = 0;
var idVehiculo = 0;
var idPedido = 0;
var estado = 0;
var idPedidoVehiculo = 0;
var idPasajero = 0;
var login = false;
var pageLogin = $("#pageLogin");
var pendiente = 0;
var control = $("#control");
var username = "";
var userpass = "";
var mapCanvas = $('#map_canvas');
var difLat = 0;
var difLng = 0;
var estadoButton = $('#estado-button');
var iniciar = $('#iniciar');
var sefue = $('#sefue');
var popupConfirmar = "";
var origin = '';
var originPasajero = '';
var latPasajero = 0;
var lngPasajero = 0;
var controlContent = $('#controlContent');
var directionsDisplay;
var map;
var layer;
var mensajeInterval;
var lastStateInterval = ""; 
var directionsService = new google.maps.DirectionsService();
var taxiIcon = new google.maps.MarkerImage(
		'http://ubitaxi.argesys.co/images/taxi.png', 
		null, 
		null, 
		null, 
		new google.maps.Size(24, 24));
var userIcon = new google.maps.MarkerImage(
		'http://ubitaxi.argesys.co/images/user_group.png', 
		null, 
		null, 
		null, 
		new google.maps.Size(24, 24));
//Wait for Cordova to load

document.addEventListener("deviceready", onDeviceReady, false);

//Cordova is ready

function onDeviceReady() {
	navigator.splashscreen.hide();
	window.plugins.tts.startup(startupWin, fail);
	idTelefono = device.uuid;
	getIdVehiculo();
	logout();
}



$(document).bind("mobileinit", function(){
	$("#testlayer").text("dd");
	$.mobile.ignoreContentEnabled = true;
	$.mobile.pushStateEnabled = false;
});

$(document).bind('pageinit', function(){	
	//$.mobile.changePage('#control', {transition : "slideup"});
	$("#loginForm").on("submit",handleLogin);
});

$(window).resize(function() {
	setControlHeight();
});
control.live("pageshow", function() {	
	mapCanvas.gmap("option", 'zoom', 16);
	mapCanvas.gmap("option", 'mapTypeId', google.maps.MapTypeId.ROADMAP);
	mapCanvas.gmap('refresh');	
	map = mapCanvas.gmap('get', 'map');
	directionsDisplay = new google.maps.DirectionsRenderer();	
	directionsDisplay.setOptions( { suppressMarkers: true } );
	layer = new google.maps.TrafficLayer();
	layer.setMap(map);	
	getLastState();	
});
control.live("pageinit", function() {
	controlContent = $('#controlContent');
	mapCanvas = $('#map_canvas');	
	buttonEvent();
	setControlHeight();	
});
function setControlHeight(){
	controlContent.height($(window).height() - 42);
}
function getLastState(){	
	if(idVehiculo == 0){
		if(lastStateInterval == ""){			
			lastStateInterval = setInterval(getLastState, 2000);
		}
	}else{
		var url = "http://ubitaxi.argesys.co/destinos/vehiculo/geLastState.html";
		var data = {
				idv : idVehiculo
		};
		/*
	$.ajax({
		url: url,
		data: data
	}).done(function(msj) { 
		navigator.notification.alert(msj, function() {}, "Tiene un pedido", "Aceptar");		
	});
		 */
		$.getJSON(url, data, function(rsp){
			
			
			if(rsp.success){
				if(rsp.vehiculo.id_pedido != 0){
					idPedido = rsp.vehiculo.id_pedido;
					speak("Tiene un pedido, el pasajero lo espera en "+rsp.pedido.direccion_origen);
					if(rsp.vehiculo.estado ==1){
						idPasajero = rsp.pedido.id_pasajero;										
						latPasajero = rsp.pedido.latitud;
						lngPasajero = rsp.pedido.longitud;
						pendiente = 0;
						markerPasajero();					
						estadoButton = $('#estado-button');
						iniciar = $('#iniciar');
						sefue = $('#sefue');
						estadoButton.hide();
						iniciar.show();
						sefue.show();
						mensajeInterval = setInterval(getMensaje, 5000);
						navigator.notification.alert(rsp.pedido.direccion_origen, function() {}, "Tiene un pedido", "Aceptar");
					}else if(rsp.vehiculo.estado == 0){					
						pendiente = 1;
						$("#popConfTiempo p").html("El pasajero lo espera en "+rsp.pedido.direccion_origen);
						$("#popConfTiempo").popup('open');
						$("#aceptarPedido").click(aceptarPedido);
						//navigator.notification.alert("Tiene un pedido, el pasajero lo espera en "+rsp.pedido.direccion_origen, aceptarPedido, "Tiene un pedido", "Aceptar");
					}
				}
			}			
		});
		clearInterval(lastStateInterval);
	}	
}

function mapRefresh(){

	origin = new google.maps.LatLng(oldLat, oldLng);
	mapCanvas.gmap("option", "center", origin);	
	mapCanvas.gmap('clear', 'markers');
	mapCanvas.gmap('addMarker', {'position': origin, 'icon':taxiIcon});

	if(latPasajero != 0){
		markerPasajero();
	}
}
function markerPasajero(){
	//navigator.notification.alert(latPasajero+" "+lngPasajero, function() {});
	originPasajero = new google.maps.LatLng(latPasajero, lngPasajero);
	mapCanvas.gmap('addMarker', {'position': originPasajero, 'icon':userIcon});
	var bounds = new google.maps.LatLngBounds(origin, originPasajero);	
	map.fitBounds(bounds);
	calcRoute();
}
function calcRoute() {    
	var request = {
			origin:origin,
			destination:originPasajero,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	directionsDisplay.setMap(map);
	directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);
		}
	});
}
function sendIdTelefono(idtelefono){
	navigator.notification.alert(idtelefono, function() {});
	idTelefono = idtelefono;
	var url = "/destinos/vehiculo/getid.html";
	var data = {
			id_telefono : idTelefono
	};
	$.getJSON(url, data, function(rsp){
		idVehiculo = rsp.id;
		$("#testlayer").text($("#testlayer").text() +" "+idVehiculo);
	});
}

function checkPreAuth() {

	if(!login) {
		$.mobile.changePage(pageLogin);        
	}
}

function handleLogin(){
	var sbutton =  $("#submitButton");
	sbutton.css('display', 'none');

	username = $('#username').val();
	userpass = $('#password').val();

	if(username != '' && userpass!= '') {		
		var url = "http://ubitaxi.argesys.co/ubi/usuario/loginCar.html";
		var data = {
				username:username,
				password:userpass,
				idTel:idTelefono
		};
		/*
		$.ajax({
			url: url,
			data: data
		}).done(function(msj) { 
			navigator.notification.alert(msj, function() {}, "Tiene un pedido", "Aceptar");		
		});
		*/
		
		$.getJSON(url, data, function(rsp){
			sbutton.css('display', 'block');
			if(rsp.success){				
				//navigator.notification.alert(rsp.success, function() {});
				login = true;
				$.mobile.changePage('#control', {transition : "slideup"});
			}else{
				navigator.notification.alert(rsp.msg, function() {});
			}
		});
		
	} else {
		//Thanks Igor!
		navigator.notification.alert("Debe ingresar un nombre de usuario y contraseña", function() {});		
	}

	return false;
}

function Locator(){

} 

Locator.prototype.sendLocation = function(lat, lng, alt, speed, time, phoneId) {
	//navigator.notification.alert(phoneId, function() {}, "Tiene un pedido", "Aceptar");	
	//idTelefono = phoneId;	
	//navigator.notification.alert(lat+" "+ lng+" "+ alt+" "+ speed+" "+ time +" "+ phoneId, function() {}, "Tiene un pedido", "Aceptar");	
	oldLat = lat;	
	oldLng = lng;
	oldSpeed = speed;
	oldAlt = alt;
	oldTime = time;

	if(!login){
		return false;
	}
	if(idVehiculo == 0){
		getIdVehiculo();
	}
	mapRefresh();
	difLat = Math.abs(lat - oldLat);
	difLng = Math.abs(lng - oldLng);
	//if(difLat > 0.00001 || difLng > 0.00001){
	var url = "http://ubitaxi.argesys.co/destinos/default/savepos.html";
	var seguimiento = {            
			latitud:lat,
			longitud:lng,
			altitud:alt,
			velocidad:speed,
			time:time,
			id_vehiculo:idVehiculo
	};
	var data = {				
			Seguimiento:seguimiento
	};

	$.getJSON(url, data, function(rsp){
		//navigator.notification.alert(rsp.success, function() {});

	});

	//}
};

Locator.prototype.send = function (){
	$("#testlayer").text("dd");
};

window.locator = new Locator();

function getIdVehiculo(){	
	var url = "http://ubitaxi.argesys.co/destinos/vehiculo/getid.html";
	var data = {
			id_telefono : idTelefono
	};

	$.getJSON(url, data, function(rsp){
		idVehiculo = rsp.id;				
	});
}

setInterval(getPedido, 5000);

function getPedido(){	
	//navigator.notification.alert(estado+" "+idVehiculo+" "+pendiente, function() {}, "Tiene un pedido", "Aceptar");
	if(estado == 0 && idVehiculo != 0 && pendiente == 0){    
		var url = 'http://ubitaxi.argesys.co/destinos/vehiculo/getPedido.html';
		var data = {
				id_vehiculo:idVehiculo
		};        
		$.getJSON(url, data, function(rsp){
			//navigator.notification.alert(rsp.msg, function() {}, "Tiene un pedido", "Aceptar");
			if(rsp.id_pedido != 0){
				//navigator.notification.alert(rsp.p_do, aceptarPedido, "Tiene un pedido", "Aceptar");
				$("#popConfTiempo p").html(rsp.p_do);
				$("#popConfTiempo").popup('open');
				$("#aceptarPedido").click(aceptarPedido);
				speak("Tiene un pedido");
				idPedido = rsp.id_pedido;   
				pendiente = 1;                
			}else{
				//$("#testlayer").html("id pedido "+idPedido);               
			}
		});
	}else if(pendiente == 1){    	
		speak("Tiene un pedido");
	}
}

function aceptarPedido(){
	var url = 'http://ubitaxi.argesys.co/ubi/pedido/aceptar';
	var data = {
			id_vehiculo:idVehiculo,
			id_pedido:idPedido,
			tiempo:$('#cantidadTiempo').val()
	};
	//$('#testlayer').load(url, data);    
	$.getJSON(url, data, function(rsp){

		if(rsp.success){
			idPasajero = rsp.id_pa;
			pendiente = 0;
			speak(rsp.msg);
			latPasajero = rsp.lat;
			lngPasajero = rsp.lng;			
			markerPasajero();
			navigator.notification.alert(rsp.msg, function(){}, "Dirección", "Aceptar");  

			estadoButton = $('#estado-button');
			iniciar = $('#iniciar');
			sefue = $('#sefue');

			estadoButton.hide();
			iniciar.show();
			sefue.show();
			mensajeInterval = setInterval(getMensaje, 5000);
		}else{
			speak(rsp.msg);  
		}
		//navigator.notification.alert(rsp.success+" "+rsp.msg, function(){}, "En aceptar pedido", "Aceptar");        
	});
}
function getMensaje(){
	//navigator.notification.alert("dddffgg", function(){}, "Error", "Aceptar");
	var url = "http://ubitaxi.argesys.co/ubi/pedido/getMensaje";
	var data = {
			id:idPedido
	};

	$.getJSON(url, data, function(rsp){
		if(rsp.success){
			navigator.notification.alert(rsp.msg, function() {speak(rsp.msg);}, "Tiene un Mensaje", "Aceptar");
		}
	});
}
function buttonEvent(){
	var estados = $('#estado'); 
	$('#salir').click(function (){
		logout();	
		$.mobile.changePage('#pageLogin', {transition : "slideup"});
	});
	estados.change(function(){
		mapRefresh();
		var url = "http://ubitaxi.argesys.co/destinos/estadoVehiculo/createCar.html";
		estado = $(this).val();
		var estadovehiculo = {
				estado:estado,
				id_vehiculo:idVehiculo,         
				time:oldTime
		};
		var data = {
				EstadoVehiculo:estadovehiculo
		};
		$.getJSON(url, data, function() {
			//navigator.notification.alert("logoutddd", function(){}, "En aceptar pedido", "Aceptar");
		});
	}); 
	$('#sefue').click(function (){
		var url = 'http://ubitaxi.argesys.co/ubi/pedido/sefue';
		var data = {
				id_vehiculo:idVehiculo,
				id_pedido:idPedido              
		};
		$.getJSON(url, data, function(rsp){
			sefue.hide();
			speak(rsp.msg);
			iniciar.hide();
			estadoButton.show();
			latPasajero = 0;
			directionsDisplay.setMap(null);
			mapRefresh();
		});
	});
	popupConfirmar = $("#popupConfirmar"); 
	$('#confirmarForm', popupConfirmar).on("click", function(){
		var url = 'http://ubitaxi.argesys.co/ubi/pedido/iniciar';
		var clave = $("#clave", popupConfirmar).val();		
		if(clave == ""){
			navigator.notification.alert("Ingrese la clave", function(){}, "Error", "Aceptar");
			return false;
		}
		var data = {
				id_vehiculo:idVehiculo,
				id_pedido:idPedido,    
				clave:clave
		};
		var success = false;
		jQuery.ajaxSetup({async: false});
		$.getJSON(url, data, function(rsp){			
			success = rsp.success; 
			speak(rsp.msg);			
			if(success){			
				sefue.hide();
				$('#llegada').show();			
				idPedidoVehiculo = rsp.id;
				iniciar.hide();
			}else{
				navigator.notification.alert(rsp.msg, function(){}, "Error", "Aceptar");
			}
		});
		jQuery.ajaxSetup({async: true});
		/*
		$.ajax({
			  url: url,
			  data: data
			}).done(function(msj) { 
				navigator.notification.alert(msj, function() {}, "Tiene un pedido", "Aceptar");
			});
		 */
		//navigator.notification.alert("success: "+success, function(){}, "Error", "Aceptar");
		return success;
	});
	$('#llegada').click(function (){
		var url = 'http://ubitaxi.argesys.co/ubi/pedido/llegada';
		var data = {
				val:2000,
				uni:100,
				lat:oldLat,
				lng:oldLng,
				id_pv:idPedidoVehiculo,
				id_vehiculo:idVehiculo,
				id_pedido:idPedido              
		};
		//$('#testlayer').load(url, data);
		var desPasajero = new google.maps.LatLng(oldLat, oldLng);
		handleRevGeocoder(desPasajero, idPedidoVehiculo);
		$.getJSON(url, data, function(rsp){
			//Locator.showToast(rsp.msg);			
			speak(rsp.msg);
			$('#llegada').hide();
			estadoButton.show();
			latPasajero = 0;
			directionsDisplay.setMap(null);
			mapRefresh();
			clearInterval(mensajeInterval);
			//directionsDisplay.setMap(map);
		});
	});
	$('#ocupado').click(function (){
		if($(this).hasClass("ocupado")){
			estados.val("0");
			estados.change();
			$(this).removeClass("ocupado");
			$('.ui-btn-text', this).text("Ocupado");
		}else{
			estados.val("1");
			estados.change();
			$(this).addClass("ocupado");
			$('.ui-btn-text', this).text("Disponible");
		}
	});
}
function handleRevGeocoder(point, idPedido){
	(new google.maps.Geocoder()).geocode({
		latLng: point
	}, function(resp) {        
		if (resp[0]) {                                   
			direccion = resp[0].formatted_address;  
			var url = 'http://ubitaxi.argesys.co/ubi/pedido/updateCar';
			var pedido = {
					id:idPedido,
					direccion_destino:direccion
			};
			var data = {
					Pedido:pedido
			};
			
			$.getJSON(url, data, function(rsp){
				//navigator.notification.alert(rsp.msg, function(){}, "Error", "Aceptar");
			});
		}                    

	});
}
function logout(){
	//navigator.notification.alert("logout", function(){}, "En aceptar pedido", "Aceptar");
	var url = "http://ubitaxi.argesys.co/ubi/usuario/logoutCar.html";
	var data = {};
	$.getJSON(url, data, function(){
		username = "";
		userpass = "";	
		estado = 0;
		pendiente = 0;
	});
}