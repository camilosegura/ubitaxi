/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function sendLocation(lat, lng, alt, speed, time, androidID){
    var difLat = Math.abs(lat - oldLat);
    var difLng = Math.abs(lng - oldLng);
    oldLat = lat;	
    oldLng = lng;
    oldSpeed = speed;
    oldAlt = alt;
    oldTime = time;
    
    if(difLat > 0.00001 || difLng > 0.00001){
        var url = "/destinos/default/savepos.html";
        var seguimiento = {            
            latitud:lat,
            longitud:lng,
            altitud:alt,
            velocidad:speed,
            time:time
        };
        var data = {
            id_telefono:androidID,
            Seguimiento:seguimiento
        };
        $.getJSON(url, data, getConfirmation);
    }
    /*
    Locator.showToast(difLat+ " " +difLng);
    Locator.showToast(lat +" "+lng+" "+alt+" "+speed+" "+time+" "+androidID);
    */
}

function getConfirmation(rsp){
    
    console.log(rsp);
    Locator.showToast(rsp.success);    
}

