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
var dirDestinos = 0;
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
var casaIcon = new google.maps.MarkerImage(
        'http://ubitaxi.argesys.co/images/casa.png',
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
$(document).bind("mobileinit", function() {
    $.mobile.ignoreContentEnabled = true;
    $.mobile.pushStateEnabled = false;
    $.mobile.buttonMarkup.hoverDelay = 0;
});

$(document).bind('pageinit', function() {
    $("#loginForm").on("submit", handleLogin);
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
    directionsDisplay.setOptions({suppressMarkers: true});
    layer = new google.maps.TrafficLayer();
    layer.setMap(map);
    getLastState();/*-------------------------------------------------------------*/
});
control.live("pageinit", function() {
    controlContent = $('#controlContent');
    mapCanvas = $('#map_canvas');
    buttonEvent();/*-------------------------------------------------------------*/
    setControlHeight();
    setInterval(getPedido, 5000);
});
function setControlHeight() {
    controlContent.height($(window).height() - 42);
}
function getLastState() {/*-------------------------------------------------------------*/
    if (idVehiculo == 0) {
        if (lastStateInterval == "") {
            lastStateInterval = setInterval(getLastState, 2000);
        }
    } else {
        var url = "http://ubitaxi.argesys.co/destinos/vehiculo/geLastState.html";
        var data = {
            idv: idVehiculo
        };

        $.getJSON(url, data, function(rsp) {

            if (rsp.success) {
                if (rsp.vehiculo.id_pedido != 0) {
                    idPedido = rsp.vehiculo.id_pedido;
                    speak("Tiene un pedido, el pasajero lo espera en " + rsp.pedido.direccion_origen);
                    if (rsp.vehiculo.estado == 1) {
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
                        navigator.notification.alert(rsp.pedido.direccion_origen, function() {
                        }, "Tiene un pedido", "Aceptar");
                    } else if (rsp.vehiculo.estado == 0) {
                        pendiente = 1;
                        $("#popConfTiempo p").html("El pasajero lo espera en " + rsp.pedido.direccion_origen);
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
function mapRefresh() {

    origin = new google.maps.LatLng(oldLat, oldLng);
    mapCanvas.gmap("option", "center", origin);
    mapCanvas.gmap('clear', 'markers');
    mapCanvas.gmap('addMarker', {'position': origin, 'icon': taxiIcon});

    if (latPasajero != 0) {
        markerPasajero();
    }
    if (dirDestinos != 0) {
        markerDestinos();
    }
}
function markerPasajero() {
    //navigator.notification.alert(latPasajero+" "+lngPasajero, function() {});
    originPasajero = new google.maps.LatLng(latPasajero, lngPasajero);
    mapCanvas.gmap('addMarker', {'position': originPasajero, 'icon': userIcon});
    var bounds = new google.maps.LatLngBounds(origin, originPasajero);
    map.fitBounds(bounds);
    calcRoute();
}
function calcRoute() {
    var request = {
        origin: origin,
        destination: originPasajero,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsDisplay.setMap(map);
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}
function markerDestinos() {
    $.each(dirDestinos, function(index, value) {
        home = new google.maps.LatLng(value.latitud, value.longitud);
        mapCanvas.gmap('addMarker', {'position': home, 'icon': casaIcon});
    });
}
function sendIdTelefono(idtelefono) {/*-------------------------------------------------------------*/
    navigator.notification.alert(idtelefono, function() {
    });
    idTelefono = idtelefono;
    var url = "/destinos/vehiculo/getid.html";
    var data = {
        id_telefono: idTelefono
    };
    $.getJSON(url, data, function(rsp) {
        idVehiculo = rsp.id;
        $("#testlayer").text($("#testlayer").text() + " " + idVehiculo);
    });
}

function checkPreAuth() {

    if (!login) {
        $.mobile.changePage(pageLogin);
    }
}

function handleLogin() {
    var sbutton = $("#submitButton");
    //sbutton.css('display', 'none');

    username = $('#username').val();
    userpass = $('#password').val();

    if (username != '' && userpass != '') {
        var url = "http://ubitaxi.argesys.co/ubi/usuario/loginCar.html";
        var data = {
            username: username,
            password: userpass,
            idTel: idTelefono
        };

        $.getJSON(url, data, function(rsp) {
            sbutton.css('display', 'block');
            if (rsp.success) {
                login = true;
                $.mobile.changePage('#control');
            } else {
                navigator.notification.alert(rsp.msg, function() {
                }, 'Error de Ingreso', 'Volver a intentar');
            }
        });

    } else {
        //Thanks Igor!
        navigator.notification.alert("Debe ingresar un nombre de usuario y contraseña", function() {
        });
    }

    return false;
}

function Locator() {

}

Locator.prototype.sendLocation = function(lat, lng, alt, speed, time) {
    //navigator.notification.alert(lat+" "+ lng+" "+ alt+" "+ speed+" "+ time +" "+ phoneId, function() {}, "Tiene un pedido", "Aceptar");	
    oldLat = lat;
    oldLng = lng;
    oldSpeed = speed;
    oldAlt = alt;
    oldTime = time;

    if (!login) {
        return false;
    }
    if (idVehiculo == 0) {
        getIdVehiculo();
    }
    mapRefresh();
    difLat = Math.abs(lat - oldLat);
    difLng = Math.abs(lng - oldLng);
    //if(difLat > 0.00001 || difLng > 0.00001){

    var url = "http://ubitaxi.argesys.co/destinos/default/savepos.html";
    var seguimiento = {
        latitud: lat,
        longitud: lng,
        altitud: alt,
        velocidad: speed,
        time: time,
        id_vehiculo: idVehiculo
    };
    var data = {
        Seguimiento: seguimiento
    };

    $.getJSON(url, data, function(rsp) {
        //navigator.notification.alert(rsp.success, function() {});

    });

    //}
};


window.locator = new Locator();

function getIdVehiculo() {
    var url = "http://ubitaxi.argesys.co/destinos/vehiculo/getid.html";
    var data = {
        id_telefono: idTelefono
    };

    $.getJSON(url, data, function(rsp) {

        if (rsp.success) {
            idVehiculo = rsp.id;
        } else {
            navigator.notification.alert("Por favor registre este dispositivo.  UUID:" + idTelefono, function() {
            }, 'Terminal sin registrar', 'Aceptar');
        }
    });
}


function getPedido() {/*-------------------------------------------------------------*/
    //navigator.notification.alert("sss", function() {}, "Tiene un pedido", "Aceptar");
    var url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/getReservasVehiculo.html';
    var data = {
        id_vehiculo: idVehiculo
    };

    $.getJSON(url, data, function(rsp) {
        if (rsp.success) {
            var botonPedido = '';
            var popupPedido = '';
            var listEmpresaDir = '';
            var listPasajeroDir = '';
            var selectoresCont = '';
            var selectoresPanel = '';
            $.each(rsp.pedidos, function(id, pedido) {
                selectoresCont += '#panelPedido-' + id + '-popup,';
                selectoresPanel += '#panelPedido-' + id + ',';
                botonPedido += '<a href="#panelPedido-' + id + '" data-role="button" data-rel="popup">' + pedido.inicio + '</a>';
                popupPedido += '<div data-role="popup" id="panelPedido-' + id + '" data-corners="false" data-theme="none" data-shadow="false" data-tolerance="0,0">';
                listPasajeroDir = '';
                $.each(pedido.pasajeroDir, function(idDir, direccion) {
                    listPasajeroDir += '<input type="checkbox" name="checkbox-' + idDir + '" id="checkbox-' + idDir + '" class="custom" />';
                    listPasajeroDir += '<label for="checkbox-' + idDir + '">' + direccion.direccion + '<br>' + direccion.nombre_pasajero + '</label>';
                });
                listEmpresaDir = '';
                $.each(pedido.empresaDir, function(idDir, direccion) {
                    if (pedido.sentido == '0') {
                        listEmpresaDir += '<li>' + direccion.direccion + '<br>'+pedido.inicio+'</li>';
                    }else{
                        listEmpresaDir += '<li>' + direccion.direccion + '<br>'+pedido.fin+'</li>';
                    }
                });

                if (pedido.sentido == '0') {
                    popupPedido += '<div class="pedidoDirCont"><h3>Inicio recorrido</h3>';
                    popupPedido += '<ul data-role="listview" data-inset="true">';
                    popupPedido += listEmpresaDir;
                    popupPedido += '</ul></div>';
                    popupPedido += '<div class="pedidoDirCont"><h3>Fin recorrido</h3>';
                    popupPedido += '<fieldset data-role="controlgroup">';
                    popupPedido += listPasajeroDir;
                    popupPedido += '</fieldset></div>';
                } else {
                    popupPedido += '<div class="pedidoDirCont"><h3>Inicio recorrido</h3>';
                    popupPedido += '<fieldset data-role="controlgroup">';
                    popupPedido += listPasajeroDir;
                    popupPedido += '</fieldset></div>';
                    popupPedido += '<div class="pedidoDirCont"><h3>Fin recorrido</h3>';
                    popupPedido += '<ul data-role="listview" data-inset="true">';
                    popupPedido += listEmpresaDir;
                    popupPedido += '</ul></div>';
                }
                popupPedido += '<div style="clear:both;"></div>';
                popupPedido += '</div>';

            });
            $('#panelPedidos').html(botonPedido);
            $('#panelPedidos').trigger("create");
            $('#panelPedido').html(popupPedido);
            $('#panelPedido').trigger("create");


            selectoresCont = selectoresCont.substring(0, selectoresCont.length - 1);
            selectoresPanel = selectoresPanel.substring(0, selectoresPanel.length - 1);
            $(selectoresCont).css({
                'left': '0 !important'
            });
            $(selectoresPanel).css({
                'width': '108%',
                'border': '1px solid #000',
                'border-right': 'none',
                'background': 'rgba(0,0,0,.5)',
                'margin': '-1px 0'});
            $(selectoresPanel).on({
                popupbeforeposition: function() {
                    var h = $(window).height();

                    $(selectoresPanel).css("height", h);
                }
            });
        } else {
            //$("#testlayer").html("id pedido "+idPedido);               
        }
    });

}

function aceptarPedido() {/*-------------------------------------------------------------*/
    var url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/aceptar';
    var data = {
        id_vehiculo: idVehiculo,
        id_pedido: idPedido
    };
    //$('#testlayer').load(url, data);    
    $.getJSON(url, data, function(rsp) {

        if (rsp.success) {
            pendiente = 0;
            speak(rsp.msg);
            latPasajero = rsp.lat;
            lngPasajero = rsp.lng;
            markerPasajero();
            navigator.notification.alert(rsp.msg, function() {
            }, "Dirección", "Aceptar");

            estadoButton = $('#estado-button');
            iniciar = $('#iniciar');
            sefue = $('#sefue');

            estadoButton.hide();
            iniciar.show();
            sefue.show();
            mensajeInterval = setInterval(getMensaje, 5000);
        } else {
            speak(rsp.msg);
        }
        //navigator.notification.alert(rsp.success+" "+rsp.msg, function(){}, "En aceptar pedido", "Aceptar");        
    });
}
function getMensaje() {
    //navigator.notification.alert("dddffgg", function(){}, "Error", "Aceptar");
    var url = "http://ubitaxi.argesys.co/ubi/pedido/getMensaje";
    var data = {
        id: idPedido
    };

    $.getJSON(url, data, function(rsp) {
        if (rsp.success) {
            navigator.notification.alert(rsp.msg, function() {
                speak(rsp.msg);
            }, "Tiene un Mensaje", "Aceptar");
        }
    });
}
function buttonEvent() {/*-------------------------------------------------------------*/
    var estados = $('#estado');
    $('#salir').click(function() {
        logout();
        $.mobile.changePage('#pageLogin', {transition: "slideup"});
    });
    estados.change(function() {
        mapRefresh();
        var url = "http://ubitaxi.argesys.co/destinos/estadoVehiculo/createCar.html";
        estado = $(this).val();
        var estadovehiculo = {
            estado: estado,
            id_vehiculo: idVehiculo,
            time: oldTime
        };
        var data = {
            EstadoVehiculo: estadovehiculo
        };
        $.getJSON(url, data, function() {
            //navigator.notification.alert("logoutddd", function(){}, "En aceptar pedido", "Aceptar");
        });
    });
    $('#sefue').click(function() {
        var url = 'http://ubitaxi.argesys.co/ubi/pedido/sefue';
        var data = {
            id_vehiculo: idVehiculo,
            id_pedido: idPedido
        };
        $.getJSON(url, data, function(rsp) {
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
    $('#confirmarPasajeros', popupConfirmar).on("click", function() {
        var url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/iniciar';
        var pasajeros = $("#cantidadPasajeros", popupConfirmar).val();

        var data = {
            id_vehiculo: idVehiculo,
            id_pedido: idPedido,
            pasajeros: pasajeros
        };
        var success = false;

        jQuery.ajaxSetup({async: false});
        $.getJSON(url, data, function(rsp) {
            success = rsp.success;
            speak(rsp.msg);

            if (success) {
                dirDestinos = rsp.direcciones;
                markerDestinos();

                sefue.hide();
                $('#llegada').show();
                idPedidoVehiculo = rsp.id;
                iniciar.hide();
                latPasajero = 0;
                directionsDisplay.setMap(null);
                mapRefresh();
            } else {
                navigator.notification.alert(rsp.msg, function() {
                }, "Error", "Aceptar");
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
    $('#llegada').click(function() {
        var url = 'http://ubitaxi.argesys.co/ubi/pedido/llegada';
        var data = {
            val: 2000,
            uni: 100,
            lat: oldLat,
            lng: oldLng,
            id_pv: idPedidoVehiculo,
            id_vehiculo: idVehiculo,
            id_pedido: idPedido
        };
        //$('#testlayer').load(url, data);
        var desPasajero = new google.maps.LatLng(oldLat, oldLng);
        handleRevGeocoder(desPasajero, idPedidoVehiculo);
        $.getJSON(url, data, function(rsp) {
            //Locator.showToast(rsp.msg);			
            speak(rsp.msg);
            $('#llegada').hide();
            estadoButton.show();
            latPasajero = 0;
            dirDestinos = 0;
            directionsDisplay.setMap(null);
            mapRefresh();
            clearInterval(mensajeInterval);
            //directionsDisplay.setMap(map);
        });
    });
    $('#ocupado').click(function() {
        if ($(this).hasClass("ocupado")) {
            estados.val("0");
            estados.change();
            $(this).removeClass("ocupado");
            $('.ui-btn-text', this).text("Ocupado");
        } else {
            estados.val("1");
            estados.change();
            $(this).addClass("ocupado");
            $('.ui-btn-text', this).text("Disponible");
        }
    });
}
function handleRevGeocoder(point, idPedido) {/*-------------------------------------------------------------*/
    (new google.maps.Geocoder()).geocode({
        latLng: point
    }, function(resp) {
        if (resp[0]) {
            direccion = resp[0].formatted_address;
            var url = 'http://ubitaxi.argesys.co/ubi/pedido/updateCar';
            var pedido = {
                id: idPedido,
                direccion_destino: direccion
            };
            var data = {
                Pedido: pedido
            };

            $.getJSON(url, data, function(rsp) {
                //navigator.notification.alert(rsp.msg, function(){}, "Error", "Aceptar");
            });
        }

    });
}
function logout() {
    //navigator.notification.alert("logout", function(){}, "En aceptar pedido", "Aceptar");
    var url = "http://ubitaxi.argesys.co/ubi/usuario/logoutCar.html";
    var data = {};
    $.getJSON(url, data, function() {
        username = "";
        userpass = "";
        estado = 0;
        pendiente = 0;
    });
}