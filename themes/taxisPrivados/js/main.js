/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Implementacion de la funcion de callback de geolocation
 * @param {type} resp
 * @returns {undefined}
 */
function callbackRevGeocoder(resp) {
    console.log(resp);
    var dirText = '';
    var dirNum = '';
    var dir = '';
    var city = '';
    if (resp[0]) {
        city = resp[1].formatted_address;
        dir = resp[0].formatted_address;
        dir = dir.split('#');
        dirText = dir[0];
        dir = dir[1].split(',');
        dirNum = dir[0];

    }
    $('#dirTexto').html(dirText + ' #');
    $('#direccionTexto').val(dirText + ' #');
    $('#direccionNumero').val(dirNum);
    $('#ciudad').val(city);
}

jQuery.ajaxSetup({beforeSend: function() {
        $('#ajaxLoader').toggle();
    },
    complete: function() {
        $('#ajaxLoader').toggle();
    }});