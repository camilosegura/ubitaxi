/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function pasajeroEvents(){
    //$("#enviarSolicitud").click(function(){
$("#formPedido").submit(function(event){        
        var nombre = $("#nombre").val();
        var celular = $("#celular").val();
        direccion = $("#direccion").val();
        var email = $("#email").val();
        var latitud = $("#latitud").val();
        var longitud = $("#longitud").val();
        var url = "/ubi/usuario/hacerPedido.html";
        var data = {
          nombre:nombre,
          celular:celular,
          direccion:direccion,
          email:email,
          latitud:latitud,
          longitud:longitud
        };
        
        $.getJSON(url, data, function(rsp){
            alert(rsp.msg);
        });
        $("#solicitar").click();
        return false;
        
    });
}

function validarForm(){
    
}