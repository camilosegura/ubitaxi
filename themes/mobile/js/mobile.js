/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var guest = $('#guest');
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

guest.live('pageinit', function(event) {

});
$(document).on("pageinit", '#guest', function() {
    mapCanvas = $('#map_canvas');
    initialize();
    pasajeroEvents();
    setControlHeight();
});

$("#popupInstruction").live("pageshow", function() {
    //alert();     
});
$(document).on("pageinit", '#addresses', function() {
    continuarDir = $('#continuarDir');
    continuarDir.click(function(e) {
        var radioLisVal = $('input:radio[name=direccionList]:checked').val();
        if (typeof radioLisVal === 'string') {
            idDireccion = radioLisVal;
            jQuery.ajaxSetup({async: false});
            var url = "/ubi/usuario/getDireccion.html";
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
//newAddress.live("pageinit", function() {
$(document).on("pageinit", '#newAddresses', function() {
    mapCanvas = $('#map_canvas');
    setControlHeight();
    initialize();
});
$(document).on("pageinit", '#cantidad', function() {
    $("#idDir").val(idDireccion);
    $("#cantidadPedir").submit(function() {
        var url = "/ubi/usuario/hacerPedidoLogged.html";
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
    var url = "/ubi/usuario/getPedido.html";
    var data = {
        est: 'activo'
    }
    var listPedido = "";
    jQuery.ajaxSetup({async: false});
    $.getJSON(url, data, function(rsp) {
        totalPedidoActivos = rsp;
        $.each(rsp, function(index, value) {
            listPedido += "<li><a href='pedido.html?idp=" + value.id + "' data-pedido-activo='" + index + "' class='pedidoActivo'>" + value.direccion_origen + "</a></li>";
        })
        $('<ul data-role="listview">' + listPedido + '</ul>').appendTo('#activosList');
        $('#activosList').trigger("create");
        $('.pedidoActivo').click(function() {
            pedidoActivo = $(this).data('pedidoActivo');
        });
    });
    jQuery.ajaxSetup({async: true});
});

$(document).on("pageinit", '#controlPedido', function() {
    var idPedidoActual = $("#pedidoEditar").val();
    $("#pedidoCancelar").on("click", function() {
        var url = "/ubi/usuario/cancelarPedido";
        var data = {
            id: idPedidoActual
        };
        $.getJSON(url, data, function(rsp) {
            if (rsp.success) {
                $("#estadoPedido").html(rsp.est);
                $("#pedidoCancelar").hide();
            }
            console.log(rsp);
        });
    });
    $("#mensajePedido").on("submit", function() {
        var url = "/ubi/usuario/enviarMensaje";
        var coment = {
            id_pedido: idPedidoActual,
            comentario: $("#textMensaje").val(),
            id_tipo_comentario:0
        };
        var data = {
            PedidoComentario:coment
        };
    
        $.getJSON(url, data, function(rsp) {
            if (rsp.success) {
                $("#textMensaje").val("");
            }
            console.log(rsp);
        });
        return false;
    });

})
$(document).on('click', '#contNewAdd', function() {
    var url = "/ubi/usuario/agregarDireccion.html";
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

$(document).on('pageinit', '#confirPedido', function() {
    $('#pedidoRsp').html(pedidoRsp.msg)
    if (pedidoRsp.success) {

    }
})


function setControlHeight() {
    mapCanvas.height($(window).height() - 42);
}
