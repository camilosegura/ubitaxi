var newAddress = $('#newAddresses');
var contNewAdd = $('#contNewAdd');
var idDireccion = 0;
var cantidad = $('#cantidad');
var addresses = $('#addresses');
var continuarDir = $('#continuarDir');
var selectLat = 0;
var selectLng = 0;
var pedidoRsp = {};
var confirPedido = $('#confirPedido');
var totalPedidoActivos;
var pedidoActivo;

$(document).on("pageinit", '#pageLogin', function() {
    $("#loginForm").on("submit", handleLogin);
});
$(document).on("pagebeforeshow", '#pageLogin', function() {
    if (localStorage.getItem('nombre_usuario') && localStorage.getItem('contrasena_usuario')) {
        username = $('#username').val(localStorage.getItem('nombre_usuario'));
        userpass = $('#password').val(localStorage.getItem('contrasena_usuario'));
        $('#registrarse').hide();
    } else {
        $('#registrarse').show();
    }

});
$(document).on("pageinit", '#addresses', function() {
    continuarDir = $('#continuarDir');
    continuarDir.click(function(e) {
        var radioLisVal = $('input:radio[name=direccionList]:checked').val();
        if (typeof radioLisVal === 'string') {
            idDireccion = radioLisVal;
            jQuery.ajaxSetup({async: false});
            var url = "http://ubitaxi.argesys.co/ubi/usuario/getDireccion.html";
            var data = {
                idDir: idDireccion
            };
            $.getJSON(url, data, function(rsp) {
                selectLat = rsp.lat;
                selectLng = rsp.lng;
            });
            jQuery.ajaxSetup({async: true});
        } else {
            alert("Debe seleccionar una dirección, o agregar una nueva");
            return false;
        }
    });
});
$(document).on("pagebeforeshow", '#addresses', function() {
    var url = "http://ubitaxi.argesys.co/ubi/usuario/logged";
    var data = {};
    var listAddress = "";
    jQuery.ajaxSetup({async: false});
    $.getJSON(url, data, function(rsp) {
        totalAddress = rsp;
        $.each(rsp, function(index, value) {
            listAddress += '<input type="radio" name="direccionList" id="direccionList' + index + '" value="' + value.id + '" />';
            listAddress += '<label for="direccionList' + index + '">' + value.direccion + '</label>';
        })
        $('#direccionFielset').html(listAddress);
        $('#direccionFielset').trigger("create");
    });
    jQuery.ajaxSetup({async: true});
});
$(document).on("pageshow", '#newAddresses', function() {
    mapCanvas = $('#map_canvas');
    initialize();
    setControlHeight();
});
$(document).on("pageinit", '#cantidad', function() {
    $("#idDir").val(idDireccion);
    $("#cantidadPedir").submit(function() {
        var url = "http://ubitaxi.argesys.co/ubi/usuario/hacerPedidoLogged.html";
        var data = {
            cant: $("#cantidadAutos").val(),
            idDir: idDireccion
        };
        $.getJSON(url, data, function(rsp) {
            pedidoRsp = rsp;
            $.mobile.changePage("#confirPedido");
        });
        return false;
    })
});
$(document).on("pageshow", '#confirmarDir', function() {
    $("#map_canvas_conf").attr("src", "http://maps.google.com/maps/api/staticmap?center=" + selectLat + "," + selectLng + "&zoom=15&size=300x300&markers=color:blue%7Clabel:U%7C" + selectLat + "," + selectLng + "&sensor=true");
});
$(document).on("pagebeforeshow", '#activosLogged', function() {
    var url = "http://ubitaxi.argesys.co/ubi/usuario/getPedido.html";
    var data = {
        est: 'activo'
    }
    var listPedido = "";
    jQuery.ajaxSetup({async: false});
    $.getJSON(url, data, function(rsp) {
        totalPedidoActivos = rsp;
        $.each(rsp, function(index, value) {
            listPedido += "<li><a href='#controlPedido' data-pedido-activo='" + value.id + "' class='pedidoActivo'>" + value.direccion_origen + "</a></li>";
        })
        $('#activosList').html('<ul data-role="listview">' + listPedido + '</ul>');
        $('#activosList').trigger("create");

    });
    jQuery.ajaxSetup({async: true});
});

$(document).on("pageinit", '#controlPedido', function() {
    var idPedidoActual = pedidoActivo;
    $("#pedidoCancelar").on("click", function() {
        var url = "http://ubitaxi.argesys.co/ubi/usuario/cancelarPedido";
        var data = {
            id: idPedidoActual
        };
        $.getJSON(url, data, function(rsp) {
            if (rsp.success) {
                $("#estadoPedido").html(rsp.est);
                //$("#estadoPedido").html("Vehiculo en camino");
                $("#pedidoCancelar").hide();
            }
            console.log(rsp);
        });
    });
    $("#mensajePedido").on("submit", function() {
        var url = "http://ubitaxi.argesys.co/ubi/usuario/enviarMensaje";
        var coment = {
            id_pedido: idPedidoActual,
            comentario: $("#textMensaje").val(),
            id_tipo_comentario: 0
        };
        var data = {
            PedidoComentario: coment
        };

        $.getJSON(url, data, function(rsp) {
            if (rsp.success) {
                $("#textMensaje").val("");
            }
            console.log(rsp);
        });
        return false;
    });

});
$(document).on("pagebeforeshow", '#controlPedido', function() {
    var url = "http://ubitaxi.argesys.co/ubi/usuario/pedido";
    var data = {
        id: pedidoActivo
    };
    $.getJSON(url, data, function(rsp) {
        var msg = "";
        if (rsp.success) {
            if (rsp.pedido.tiempo_llegar != 0) {
                msg = 'El taxista llegará en ' + rsp.pedido.tiempo_llegar + ' minutos';
            } else {
                msg = 'Vehiculo en camino';
            }
        }
        $('#estadoPedido').html(msg);
    });
});
$(document).on("pagebeforeshow", '#addressesEdit', function() {
    var url = "http://ubitaxi.argesys.co/ubi/usuario/getDireccionActiva.html";
    var data = {
    }
    var listAddress = "";

    $.getJSON(url, data, function(rsp) {
        if (rsp.success) {
            totalDirActivas = rsp.direccion;
            listAddress += '<div data-role="collapsible-set" data-content-theme="d" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">';
            $.each(rsp.direccion, function(index, value) {

                listAddress += '<div data-role="collapsible" id="activeDir-' + value.id + '">';
                listAddress += '<h3>' + value.direccion + '</h3>';
                listAddress += '<div>';
                listAddress += '<a href="#" class="actualizarDir" data-pedido="' + value.id + '" data-role="button" data-icon="refresh" data-inline="true">Modificar</a>';
                listAddress += '<a href="#" class="eliminarDir" data-pedido="' + value.id + '" data-role="button" data-icon="delete" data-theme="a" data-inline="true">Eliminar</a>';
                listAddress += '</div>';
                listAddress += '</div>';

            });
            listAddress += '</div>';
            $('#activasList').html(listAddress);
            $('#activasList').trigger("create");
            $('.actualizarDir').click(function() {
                pedido = $(this).data('pedido');
                alert(pedido);
            });
            $('.eliminarDir').click(function() {
                pedido = $(this).data('pedido');
                var url = "http://ubitaxi.argesys.co/ubi/usuario/eliminarDireccion.html";
                var data = {
                    id: pedido
                }
                $.getJSON(url, data, function(rsp) {
                    $('#activeDir-' + pedido).remove();
                });

            });
        }
    });
});
$(document).on('click', '#contNewAdd', function() {
    var url = "http://ubitaxi.argesys.co/ubi/usuario/agregarDireccion.html";
    var data = {
        lat: oldLat,
        lng: oldLng,
        dir: direccion
    };
    jQuery.ajaxSetup({async: false});
    $.getJSON(url, data, function(rsp) {
        idDireccion = rsp.id;
    });
    jQuery.ajaxSetup({async: true});
});

$(document).on('pageshow', '#confirPedido', function() {

    $('#pedidoRsp').html('<a href="#controlPedido" data-pedido-activo="' + pedidoRsp.id_pedido + '" class="pedidoActivo" data-ico="arrow-r" data-role="button">Ver estado del pedido</a>');
    $('#pedidoRsp').trigger("create");
    if (pedidoRsp.success) {
        $("#popupConfirmarCorreo").popup('open');
    }
    $('#enviarEmail').click(function() {
        url = "http://ubitaxi.argesys.co/ubi/usuario/enviarMailTaxi";
        data = {
            idp: pedidoRsp.id_pedido
        }
        $.getJSON(url, data, function() {

        });
    });
});
$(document).on('pagebeforeshow', '#historialLogged', function() {
    var url = "http://ubitaxi.argesys.co/ubi/usuario/historial";
    var data = {};
    var listHistorial = "";
    jQuery.ajaxSetup({async: false});
    $.getJSON(url, data, function(rsp) {
        totalHistorial = rsp;
        $.each(rsp, function(index, value) {
            listHistorial += '<div data-role="collapsible" id="activeHistori-' + value.id + '">';
            listHistorial += '<h3>' + value.origen + ' ' + value.destino + '</h3>';
            listHistorial += '<div>';
            listHistorial += '<a href="#" class="eliminarHistorial"	data-pedido="' + value.id + '" data-role="button" data-icon="delete" data-theme="a" data-inline="true">Eliminar</a>';
            listHistorial += '</div></div>';
        })
        $('#historialFielset').html(listHistorial);
        $('#historialFielset').trigger("create");
    });
    jQuery.ajaxSetup({async: true});
});
$(document).on('pageshow', '#historialLogged', function() {
    $('.eliminarHistorial').click(function() {
        console.log("elliminando");
        var url = 'http://ubitaxi.argesys.co/ubi/usuario/elminarHistorial';
        var idHistorial = $(this).data('pedido');
        var data = {
            id: idHistorial
        }
        $.getJSON(url, data, function() {
            $('#activeHistori-' + idHistorial).remove();
        })
    })
});
$(document).on('click', '.pedidoActivo', function() {
    pedidoActivo = $(this).data('pedidoActivo');
});

function setControlHeight() {
    mapCanvas.height($(window).height() - 42);
}

function handleLogin() {
    var sbutton = $("#submitButton");
    sbutton.css('display', 'none');
    username = $('#username').val();
    userpass = $('#password').val();

    if (username != '' && userpass != '') {
        var url = "http://ubitaxi.argesys.co/ubi/usuario/loginMobile";
        var data = {
            username: username,
            password: userpass,
        };
        $.getJSON(url, data, function(rsp) {
            sbutton.css('display', 'block');
            if (rsp.success) {
                login = true;
                window.localStorage.setItem('nombre_usuario', username);
                window.localStorage.setItem('contrasena_usuario', userpass);
                $.mobile.changePage('#addresses', {transition: "slideup"});
            } else {
                navigator.notification.alert(rsp.msg, function() {
                });
            }
        });

    } else {
        //Thanks Igor!
        navigator.notification.alert("Debe ingresar un nombre de usuario y contraseña", function() {
        });
    }
    return false;
}
