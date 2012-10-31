$(document).ready(function(){
    
    buttonEvent();
    setInterval(getPedido, 5000);
});

function buttonEvent(){
    $("#emergencia").click(function(){
        var url = "/seguridad/emergencia/createCar.html";
        var emergencia = {
            id_vehiculo:idVehiculo,         
            time:oldTime
        };
        var data = {
            Emergencia:emergencia
        };
        $.getJSON(url, data, getConfirmation);
    });
    
    $('#estado').change(function(){
        var url = "/destinos/estadoVehiculo/createCar.html";
        estado = $(this).val();
        //Locator.showToast(estado);
        var estadovehiculo = {
            estado:estado,
            id_vehiculo:idVehiculo,         
            time:oldTime
        };
        var data = {
            EstadoVehiculo:estadovehiculo
        };
        $.getJSON(url, data, getConfirmation);
    //$('#testlayer').load(url, data)
    });       
    
    $('#pedido-rechazar').click(function (){
        var url = '/ubi/pedido/rechazar';
        var data = {
            id_vehiculo:idVehiculo            
        };
        $.getJSON(url, data, function(rsp){
            Locator.showToast(rsp.msg);
            Locator.speakOut(rsp.msg);
        });
    });
    
    $('#pedido-aceptar').click(function (){
        Locator.showToast('sdafsa');
        var url = '/ubi/pedido/aceptar';
        var data = {
            id_vehiculo:idVehiculo,
            id_pedido:idPedido
        };
        //$('#testlayer').load(url, data);
        
        $.getJSON(url, data, function(rsp){
            
            if(rsp.success){
                idPasajero = rsp.id_pa;
            }else{
                
            }
            Locator.showToast(rsp.success);
            Locator.showToast(rsp.msg);
            Locator.speakOut(rsp.msg);
        });
        
    });
    
    $('#sefue').click(function (){
        var url = '/ubi/pedido/sefue';
        var data = {
            id_vehiculo:idVehiculo,
            id_pedido:idPedido              
        };
        $.getJSON(url, data, function(rsp){
            Locator.showToast(rsp.msg);
            Locator.speakOut(rsp.msg);
        });
    });
    
    $('#iniciar').click(function (){
        var url = '/ubi/pedido/iniciar';
        var data = {
            id_vehiculo:idVehiculo,
            id_pedido:idPedido              
        };
        //$('#testlayer').load(url, data);
        
        $.getJSON(url, data, function(rsp){
            Locator.showToast(rsp.msg);
            Locator.speakOut(rsp.msg);
            idPedidoVehiculo = rsp.id;
        });
        
    });
    $('#llegada').click(function (){
        var url = '/ubi/pedido/llegada';
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
        
        $.getJSON(url, data, function(rsp){
            Locator.showToast(rsp.msg);
            Locator.speakOut(rsp.msg);
        });
        
    });
    $('#mensaje').click(function (){
        var url = '/ubi/pedido/mensajeUsuario';
        var data = {
            msg:$('#mensaje-text').val(),
            id_pa:idPasajero,
            id_vehiculo:idVehiculo,
            id_pedido:idPedido              
        };
        $.getJSON(url, data, function(rsp){
            Locator.showToast(rsp.msg);
            Locator.speakOut(rsp.msg);
        });
    });
}

function getPedido(){
    Locator.showToast(estado+' '+idVehiculo);
    if(estado == 0 && idVehiculo != 0){
        Locator.showToast('f')
        var url = '/destinos/vehiculo/getPedido.html';
        var data = {
            id_vehiculo:idVehiculo
        }
                
        $.getJSON(url, data, function(rsp){
            if(rsp.id_pedido != 0){
                //Locator.showToast(rsp.id_pedido);
                Locator.speakOut("Tiene un pedido");
                idPedido = rsp.id_pedido;
                $('#main-control').hide();
                $('#control-aceptar').show();    
                $('#cliente-dir').html(rsp.p_do);
            }else{
                $('#main-control').show();
            //$('#control-aceptar').hide();                
            }
        });
    }
}

