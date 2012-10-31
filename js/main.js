var oldLat = 0;
var oldLng = 0;
var oldSpeed = 0; 
var oldAlt = 0;
var oldTime = 0;
var idTelefono = 0;
var idVehiculo = 0;
var idPedido = 0;
var estado = 0;
var idPedidoVehiculo = 0;
var idPasajero = 0;


$(document).ready(function(){
	idTelefono = Locator.getIdPhone();
        //idTelefono = idTelefono.toString();
        //idTelefono = "1da4050f2a91a934";
        
        
        $("#testlayer").text(idTelefono);      
       
})

function sendIdTelefono(idtelefono){
    idTelefono = idtelefono;
    var url = "/destinos/vehiculo/getid.html";
        var data = {
            id_telefono : idTelefono
        }
         $.getJSON(url, data, function(rsp){
            idVehiculo = rsp.id;
            $("#testlayer").text($("#testlayer").text() +" "+idVehiculo);
        });
}