/*$.ajax({
 url: url,
 data: data
 }).done(function(msj) { 
 navigator.notification.alert(msj);
 });*/
var oldLat = 4.63394876;
var oldLng = -74.07235247;
var oldSpeed = 0;
var oldAlt = 0;
var oldTime = 0;
var idTelefono = 0;
var idVehiculo = 0;
var idPedido = 0;
var estado = 0;
var login = false;
var pageLogin = $("#pageLogin");
var pendiente = 0;
var control = $("#control");
var username = "";
var userpass = "";
var mapCanvas = $('#map_canvas');
var difLat = 0;
var difLng = 0;
var popupConfirmar = "";
var origin = '';
var originPasajero = '';
var latPasajero = 0;
var lngPasajero = 0;
var controlContent = $('#controlContent');
var directionsDisplay;
var dirDestinos = 0;
var dirPasajeros = {};
var map;
var layer;
var mensajeInterval;
var lastStateInterval = "";
var reservas = {};
var reintentos = {};
var popupPedido = {};
var panelPedido;
var panelPedidos;
var panelPedidoInfo;
var idPedidocont;
var finalizar;
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
    jQuery.ajaxSetup({timeout: 5000});
});

$(document).bind('pageinit', function() {
    $("#loginForm").on("submit", handleLogin);
});
$(window).resize(function() {
    setControlHeight();
});
control.live("pageshow", function() {
    startTime();
    origin = new google.maps.LatLng(oldLat, oldLng);
    mapCanvas.gmap("option", "center", origin);
    mapCanvas.gmap("option", 'zoom', 16);
    mapCanvas.gmap("option", 'mapTypeId', google.maps.MapTypeId.ROADMAP);
    mapCanvas.gmap('refresh');
    map = mapCanvas.gmap('get', 'map');
    directionsDisplay = new google.maps.DirectionsRenderer();
    directionsDisplay.setOptions({suppressMarkers: true});
    layer = new google.maps.TrafficLayer();
    layer.setMap(map);
    getPedido();
    panelPedidos.popup('open');
});
control.live("pageinit", function() {
    controlContent = $('#controlContent');
    mapCanvas = $('#map_canvas');
    setPanelHeight();
    panelPedido = $('#panelPedido');
    panelPedidos = $('#panelPedidos');
    verPedido = $('#verPedido');
    panelPedidoInfo = $('#panelPedidoInfo');
    idPedidocont = $('#idPedido');
    finalizar = $('#finalizar');
    $('.fallido').hide();
    setControlHeight();
    setInterval(getPedido, 20000);
});

$(document).on('click', '#finalizar', function() {
    idPedido = $(this).data('idPedido');
    var url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/actualizarEstado';
    var data = {
        id: idPedido,
        estado: 4
    };

    if (typeof dirPasajeros[idPedido] === 'undefined' || !Object.keys(dirPasajeros[idPedido]).length) {
        $(this).hide();
        $('.fallido').show();        
        return false;
    }
    finalizarPedido(url, data);
    getPedido();
});
$(document).on('click', '#fallido', function() {    
    var url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/actualizarEstado';
    var data = {
        id: idPedido,
        estado: 2
    };
    finalizarPedido(url, data);
    getPedido();
});
$(document).on('click', '#cancelarFallido', function() {
    $('.fallido').hide();
    finalizar.show();
});
$(document).on('click', '#salir', function() {
    logout();
    $.mobile.changePage('#pageLogin');
});


$(document).on('click', '.popupPedidoBtn', function() {
    idPedido = $(this).data('idPedido');
    setPopupPedido(popupPedido[idPedido]);
});
$(document).on('change', '.checkPasajero', function() {
    var url = '';
    var dirPasajero = {};
    var data = {
        check: $(this)[0].checked,
        idPedido: $(this).data('idPedido'),
        idDir: $(this).data('idDireccion')
    };
    reservas[$(this).data('idPedido')]['pasajeroDir'][$(this).data('idDireccion')]['confirmado'] = $(this)[0].checked;

    if ($(this)[0].checked) {
        dirPasajero[$(this).data('idDireccion')] = reservas[$(this).data('idPedido')]['pasajeroDir'][$(this).data('idDireccion')];
        dirPasajeros[$(this).data('idPedido')] = dirPasajero;
        popupPedido[$(this).data('idPedido')].find('input#checkbox-' + $(this).data('idDireccion')).attr('checked', true);
        url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/setConfirmacion';

    } else {
        popupPedido[$(this).data('idPedido')].find('input#checkbox-' + $(this).data('idDireccion')).attr('checked', false);
        delete dirPasajeros[$(this).data('idPedido')][$(this).data('idDireccion')];
        url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/borrarConfirmacion';

    }
    $.getJSON(url, data, function(rsp) {

    }).error(function(jqXHR, textStatus, errorThrown) {
        var currentTime = new Date().getTime();
        reintentos[currentTime] = setInterval(function() {
            reintentarEnvio(url, data, currentTime, dummy);
        }, 5000);
    });

});

function setControlHeight() {
    controlContent.height($(window).height() - 42);
}

function mapRefresh() {

    origin = new google.maps.LatLng(oldLat, oldLng);
    mapCanvas.gmap("option", "center", origin);
    mapCanvas.gmap('clear', 'markers');
    mapCanvas.gmap('addMarker', {'position': origin, 'icon': taxiIcon});

    if (dirDestinos != 0) {
        markerDestinos();
    }
}
function markerDestinos() {
    $.each(dirDestinos, function(index, value) {
        if (value.latitud !== '0' && value.longitud !== '0') {
            home = new google.maps.LatLng(value.latitud, value.longitud);
            mapCanvas.gmap('addMarker', {'position': home, 'icon': userIcon});
        }
    });
}

function checkPreAuth() {

    if (!login) {
        $.mobile.changePage(pageLogin);
    }
}

function handleLogin() {

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
            if (rsp.success) {
                login = true;
                $.mobile.changePage('#control');
            } else {
                navigator.notification.alert(rsp.msg, function() {
                }, 'Error de Ingreso', 'Volver a intentar');
            }
        }).error(function(jqXHR, textStatus, errorThrown) {
            navigator.notification.alert('Hay problemas en la conexión, intente de nuevo', function() {
            }, 'Error', 'Aceptar');

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
    }).error(function(jqXHR, textStatus, errorThrown) {
        var currentTime = new Date().getTime();
        reintentos[currentTime] = setInterval(function() {
            reintentarEnvio(url, data, currentTime, dummy);
        }, 5000);
    });
}


function getPedido() {
    //navigator.notification.alert("sss");
    var botonesPedido = '<a href="#" data-role="button" data-theme="a">No tiene pedidos</a>';
    var url = 'http://ubitaxi.argesys.co/taxisPrivados/pedido/getReservasVehiculo';
    var data = {
        id_vehiculo: idVehiculo
    };

    $.getJSON(url, data, function(rsp) {

        var getPedidos = rsp.pedidos;
        if (rsp.success && !Object.identical(reservas, getPedidos)) {
            reservas = getPedidos;
            var botonPedido = {};
            var listEmpresaDir = '';
            var listPasajeroDir = '';
            var selectoresPanel = '';
            var dirPasajero = {};
            var primerPedido = 0;
            var theme = '';
            var servicio = '';
            botonesPedido = '';
            $.each(rsp.pedidos, function(id, pedido) {
                selectoresPanel += '#panelPedido-' + id + ',';
                theme = ((pedido.sentido==='0') ? 'e' : 'b');
                servicio = ((pedido.sentido==='0') ? 'Recogida' : 'Entrada');
                botonPedido[pedido.orden] = '<a href="#panelPedido" data-role="button" data-rel="popup" data-id-pedido="' + id + '" class="popupPedidoBtn" data-theme="'+theme+'">' + pedido.inicio + '</a>';
                $.each(pedido.pasajeroDir, function(idDir, direccion) {
                    if (direccion.confirmado) {
                        dirPasajero[idDir] = direccion;
                        dirPasajeros[id] = dirPasajero;
                    }
                });
            
                listPasajeroDir = listPasajeroInicio(id, pedido.pasajeroDir, theme);
                listEmpresaDir = listEmpresadirInicio(pedido.empresaDir, pedido.sentido, pedido.inicio, pedido.fin, pedido.empresa, theme);
                popupPedido[id] = $(pedidoPopup(id, listPasajeroDir, listEmpresaDir, pedido.sentido, 'panelPedido', Object.keys(pedido.pasajeroDir).length, servicio));
            });
            $.each(botonPedido, function(i, boton) {
                if (primerPedido === 0) {
                    primerPedido = boton;
                }
                botonesPedido += boton;
            });

            panelPedidos.html(botonesPedido);
            panelPedidos.trigger("create");
            idPedido = $(primerPedido).data('idPedido');
            setPopupPedido(popupPedido[idPedido]);
            panelPedido.popup('close');
            panelPedido.popup('open');
            speak('Tiene un pedido');
            navigator.notification.vibrate(1000);
            verPedido.show();
        } else if (!rsp.success) {
            panelPedidos.html(botonesPedido);
            panelPedidos.trigger("create");
            panelPedido.popup('close');
            verPedido.hide();
        }
    });
}
function pedidoPopup(id, listPasajeroDir, listEmpresaDir, sentido, idPop, totalPasasjeros, servicio) {
    var popupPedido = '';
    popupPedido += '<div data-role="popup" id="' + idPop + '-' + id + '" data-corners="false" data-theme="none" data-shadow="false" class="popupPedido">';
    if (sentido === '0') {
        popupPedido += '<div class="pedidoDirCont"><h3>Inicio &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;'+servicio+'</h3>';
        popupPedido += listEmpresaDir;
        popupPedido += '</div>';
        popupPedido += '<div class="pedidoDirCont"><h3>Fin &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;'+totalPasasjeros+' Pasajero(s)</h3>';
        popupPedido += listPasajeroDir;
        popupPedido += '</div>';
    } else {
        popupPedido += '<div class="pedidoDirCont"><h3>Inicio &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;'+servicio+'</h3>';
        popupPedido += listPasajeroDir;
        popupPedido += '</div>';
        popupPedido += '<div class="pedidoDirCont"><h3>Fin &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;'+totalPasasjeros+' Pasajero(s)</h3>';
        popupPedido += listEmpresaDir;
        popupPedido += '</div>';
    }
    popupPedido += '<div style="clear:both;"></div>';
    popupPedido += '<div style="clear:both;"></div></div>';
    return popupPedido;
}
function listPasajeroInicio(id, pasajeroDir, theme) {
    var checked = '';
    var listPasajeroDir = '<fieldset data-role="controlgroup" data-theme="'+theme+'">';
    $.each(pasajeroDir, function(idDir, direccion) {
        if (direccion.confirmado) {
            checked = 'checked';
        } else {
            checked = '';
        }
        listPasajeroDir += '<input type="checkbox" name="checkbox-' + idDir + '" id="checkbox-' + idDir + '" class="custom checkPasajero" data-id-pedido="' + id + '" data-id-direccion="' + idDir + '" ' + checked + ' data-theme="'+theme+'" />';
        listPasajeroDir += '<label for="checkbox-' + idDir + '" data-theme="'+theme+'">' + direccion.direccion + '<br>' + direccion.nombre_pasajero + '</label>';
    });
    listPasajeroDir += '</fieldset>';
    return listPasajeroDir;
}

function listEmpresadirInicio(empresaDir, sentido, inicio, fin, nombre, theme) {
    var listEmpresaDir = '<ul data-role="listview" data-inset="true" data-theme="'+theme+'">';
    $.each(empresaDir, function(idDir, direccion) {
        if (sentido == '0') {
            listEmpresaDir += '<li>' + nombre + '<br>' + direccion.direccion + '<br>' + inicio + '</li>';
        } else {
            listEmpresaDir += '<li>' + nombre + '<br>' + direccion.direccion + '<br>' + fin + '</li>';
        }
    });
    listEmpresaDir += '</ul>';
    return listEmpresaDir;
}

function setPanelHeight() {
    $('.popupPedido').on({
        popupbeforeposition: function() {
            var h = $(window).height();
            $('.popupPedido').css("height", h);
        }
    });
}
function reintentarEnvio(url, data, interval, callback) {

    $.getJSON(url, data, function(rsp) {
        clearInterval(reintentos[interval]);
        callback(rsp);
    });
}

function dummy(rsp) {
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

function startTime()
{
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
// add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('reloj').innerHTML = h + ":" + m + ":" + s;
    document.getElementById('relojPedido').innerHTML = h + ":" + m + ":" + s;
    t = setTimeout(function() {
        startTime()
    }, 500);

}

function checkTime(i)
{
    if (i < 10)
    {
        i = "0" + i;
    }
    return i;
}
function setPopupPedido(popupPedidoHtml) {
    panelPedidoInfo.html(popupPedidoHtml.html());
    panelPedidoInfo.trigger("create");
    $('span', idPedidocont).html(idPedido);
    finalizar.data('idPedido', idPedido);
}
function finalizarPedido(url, data) {
    dirDestinos = 0;
    mapRefresh();
    verPedido.hide();
    $.getJSON(url, data, function(rsp) {
    }).error(function(jqXHR, textStatus, errorThrown) {
        var currentTime = new Date().getTime();
        reintentos[currentTime] = setInterval(function() {
            reintentarEnvio(url, data, currentTime, dummy)
        }, 5000);

    });
}
$(document).on('popupafteropen', '#panelPedido', function() {
    verPedido.hide();
    panelPedidos.hide();
    $('#reloj').hide();
});
$(document).on('popupafterclose', '#panelPedido', function() {
    verPedido.show();
    panelPedidos.show();
    $('#reloj').show();
});	   