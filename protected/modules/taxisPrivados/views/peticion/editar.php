<?php
$horaEmpresa = $peticion->hora_empresa;
$sentido = $peticion->sentido;
if ($peticion->sentido == '0') {
    $minTime = $horaEmpresa;
    $maxTime = '';
} else {
    $minTime = 0;
    $maxTime = $horaEmpresa;
}


$cs = Yii::app()->getClientScript();
$cs->registerScript('script', <<<JS

   var horaEmpresa = "$horaEmpresa";   
   var sentido = "$sentido";
   var minTime = "$minTime";
   var maxTime = "$maxTime";
   var idPeticion = $('#pedidoFormulario').data('idPeticion');
   var pedidos = $('#pedidos');
   var idPedido = 'undefined';
   var pedidoForm = 'undefined';

   setTimePicker($('#pedidos'));
   setInterval(buscarLeidos, 5000);
   setInterval(buscarConfirmaciones, 5000);
   
    $( "#empresaDir" ).sortable({
      connectWith: ".empresasDir",
      cursor: "move"
    }).disableSelection();;    

$('#asignarPedido').click(function(){
    var pedidoForm = $('#pedidoFormulario').clone();
    pedidoForm.attr('id', '');
    pedidoForm.prependTo('#pedidos').show();
    formPedidosEvent(pedidoForm);    
});

$('#eliminarPeticion').click(function(){
    $('#eliminarPeticionModal').modal('toggle');
});

$('#aceptarEliminarPeticionModal').click(function(){
    eliminarPeticion();
});

$('#pedidos').on('click', '.eliminarDir', function(){
    $(this).parent().remove();
});

$('#pedidos').on('click', '.editarPedido', function(){
    var pedidoForm = $(this).parents('.pedidoForm');    
    var url = '/taxisPrivados/pedido/peticionEditar';
    var data = getLocalPedido(pedidoForm);
    var frm =  $ (".localPedidoForm", pedidoForm);
    frm.validate();
    if($(frm).valid()){       
        $.getJSON(url, data, function(rsp){
            if(rsp.success){
                
            }
        });
        return false;
    }                
});

$('#pedidos').on('click', '.guardarPedido', function(){
    var that = $(this);
    var pedidoForm = $(this).parents('.pedidoForm');
    var url = '/taxisPrivados/pedido/peticionNuevo';
    var data = getLocalPedido(pedidoForm);
    var frm =  $ (".localPedidoForm", pedidoForm);
    frm.validate();
    if($(frm).valid()){       
     $.getJSON(url, data, function(rsp){
        if(rsp.success){
            pedidoForm.data('idPedido', rsp.id);  
            pedidoForm.addClass('rSinLeer');
            pedidoForm.attr('id', 'pedidoForm-'+rsp.id);            
            that.hide();
            $('.botonesPedido i', pedidoForm).addClass('icon-time');
            $('.editarPedido', pedidoForm).show();            
        }
     });
     return false;
    } 
    
});

$('#pedidos').on('click', '.eliminarPedido', function(){
    $('#eliminarPedidoModal').modal('toggle');
    pedidoForm = $(this).parents('.pedidoForm');
    idPedido = pedidoForm.data('idPedido');        
});

$('#aceptarEliminarPedidoModal').click(function(){
    eliminarPedido();
    $('#eliminarPedidoModal').modal('toggle');
});

function eliminarPedido(){
    var url = '/taxisPrivados/pedido/peticionEliminar';
    var data = {
        id:idPedido
    };
    
    if(typeof idPedido != "undefined"){
        $.getJSON(url, data, function(rsp){
            if(rsp.success){
                var listas = pedidoForm.find('.pasajerosDir').html().replace('<i class="icon-time"></i>', '').replace('<i class="icon-ok"></i>', '');
                $('#pasajerosDir').append(listas);
                pedidoForm.remove();
            }
        });
    }else{
        var listas = pedidoForm.find('.pasajerosDir').html();    
        $('#pasajerosDir').append(listas);
        pedidoForm.remove();
    }
}

function eliminarPeticion(){    
    var url = '/taxisPrivados/peticion/eliminar';    
    data = {
        id:idPeticion
    };    
    $.getJSON(url, data, function(rsp){
        if(rsp.success){
            window.location.pathname = '/taxisPrivados/peticion/ver';
        }
    });
}

function setTimePicker(pedidoForm){
    $('.timePicker', pedidoForm).datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: new Date(minTime),
        maxDate: new Date(maxTime),
        onClose: function(dateText, inst){
            var that = $(this);
            var url = '/taxisPrivados/vehiculo/libres';
            var data = {};
            idPedido = $(this).parents('.pedidoForm').data('idPedido');
            console.log(idPedido);
            data["idPedido"] = (idPedido === '') ? 0 : idPedido;
            
            if(sentido === "0"){
                data["horaInicio"] = horaEmpresa;
                data["horaFin"] = dateText;
            }else{
                data["horaInicio"] = dateText;
                data["horaFin"] = horaEmpresa;
            }
            console.log(that.parents('.pedidoForm').find('.vehiculoLista option:selected'));
            $.getJSON(url, data, function(rsp){
                var direccion = '';
                var pedidoForm = {};
                if(rsp.success){
                    $.each(rsp.libres, function(index, value){            
                        direccion += '<option value="'+index+'">'+value+'</option>';
                    });                    
                    that.parents('.pedidoForm').find('.vehiculoLista').html(direccion).removeAttr('disabled');
                }
            });
        }
    });
}

function getLocalPedido(formulario){
    
    var idPedido = formulario.data('idPedido');
    var idPeticion = formulario.data('idPeticion');    
    var idsDirEmpresa = getIdDireccion('empresasDir', formulario);
    var idsDirPasajeros = getIdDireccion('pasajerosDir', formulario);
    var fin = formulario.find('.timePicker').val();
    var idVehiculo = formulario.find('.vehiculoLista').val();
    var data = {
        id:idPedido,
        idPeticion:idPeticion,
        dirPasa:idsDirPasajeros,
        dirEmp:idsDirEmpresa,
        fin:fin,
        idVehiculo:idVehiculo
    };
    
    return data;
}

function getIdDireccion(clase, formulario){
    var listas = formulario.find('.'+clase+' li');
    var ids = [];
    $.each(listas, function(index, lista){
        ids[index] = $(lista).data('id');
    });
    return ids;
}

function formPedidosEvent(pedidoForm){
    
    $( ".pasajerosDir").sortable({
      connectWith: ".pasajerosDir",
      cursor: "move",
      receive: function(event, ui){
        console.log();
        if(ui.item.parents('#pasajerosDir').length === 1){
            ui.item.children('i').remove();
        }else{
            ui.item.children('i').remove();
            ui.item.append('<i class="icon-time"></i>');
        }        
      }
    });    
    $( ".empresasDir" ).sortable({
      connectWith: ".empresasDir",
      cursor: "move",
      receive: function(event, ui){        
        if(ui.sender.attr('id') == 'empresaDir'){
            ui.item.clone().appendTo('#empresaDir');
            ui.item.append(' <button type="button" class="btn btn-danger eliminarDir"><b>X</b></button>');
            var listas = $('li', this );
            var igual = 0;
            $.each(listas, function(index, lista){                
                if($(lista).data('id') == ui.item.data('id')){
                    igual++;
                }
            });
            if(igual >= 2){
                ui.item.remove();
            }            
        }else{
            ui.item.remove();
        }
      }
    }).disableSelection();
    $(".pasajerosDir").sortable( "refresh" );
    $(".empresasDir").sortable( "refresh" );    
    setTimePicker(pedidoForm);
}

function buscarLeidos(){
    var url = '/taxisPrivados/pedido/getEstados';
    var data = {
        idPedidos:{}
    };
    var rSinLeer = $('.rSinLeer', pedidos);
    if(rSinLeer.length){
        $.each(rSinLeer, function(i, sinLeer){
            data.idPedidos[i] = $(sinLeer).data('idPedido');
        });
        jQuery.ajaxSetup({
            beforeSend: function() {},
            complete: function() {}
        });
        $.getJSON(url, data, function(rsp){
            if(rsp.success){
                $.each(rsp.pedidos, function(id, estado){
                    if(estado === '1'){
                        $('.botonesPedido i', '#pedidoForm-'+id).removeClass('icon-time');
                        $('.botonesPedido i', '#pedidoForm-'+id).addClass('icon-ok');
                        $('#pedidoForm-'+id).removeClass('rSinLeer');
                        $('#pedidoForm-'+id).addClass('rLeido');
                    }
                });
            }
        });
        jQuery.ajaxSetup({beforeSend: function() {
            $('#ajaxLoader').toggle();
        },
        complete: function() {
            $('#ajaxLoader').toggle();
        }});
    }
}

function buscarConfirmaciones(){
    var url = '/taxisPrivados/peticion/getConfirmados';
    var data = {
        idPeticion:idPeticion
    };
    
    jQuery.ajaxSetup({
        beforeSend: function() {},
        complete: function() {}
    });
    $.getJSON(url, data, function(rsp){
        if(rsp.success){            
            $('.pasajerosDir li i', pedidos).removeClass('icon-ok');
            $('.pasajerosDir li i', pedidos).addClass('icon-time');
            $.each(rsp.confirmaciones, function(i, confirmacion){
                $('i', '#dir-'+confirmacion.id_direccion).removeClass('icon-time');
                $('i', '#dir-'+confirmacion.id_direccion).addClass('icon-ok');
            });
        }
    });
    jQuery.ajaxSetup({beforeSend: function() {
        $('#ajaxLoader').toggle();
    },
    complete: function() {
        $('#ajaxLoader').toggle();
    }});
}

JS
        , CClientScript::POS_READY);
?>
<style type="text/css">
    .empresasDir, .pasajerosDir{
        background-color: #f7f7f9;
        border: 1px solid #e1e1e8;
        border-radius: 4px;
        min-height: 30px;
        padding: 10px;
    }
    .eliminarDir{
        float: right;
    }
    .empresasDir li, .pasajerosDir li{
        background-color: white;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #e1e1e8;
    }
</style>
<div class="row">
    <h1 class="span12">Editar Petición</h1>
    <div class="span6"><span><b>Empresa:</b> <?php echo $peticion->empresa->nombre; ?></span></div>
    <div class="span6"><span><b>Hora empresa:</b> <?php echo $peticion->hora_empresa ?></span></div>
</div>
<div class="row">
    <div class="span6">
        <span><b>Direcciones empresa:</b></span>
        <ul class="unstyled empresasDir" id="empresaDir">
            <?php
            if (is_array($empresaDir)) {
                foreach ($empresaDir as $key => $dir) {
                    ?>
                    <li id="dir-<?php echo $key; ?>" data-id="<?php echo $key; ?>"><?php echo $dir; ?></li>
                    <?php
                }
            }
            ?>            
        </ul>
    </div>
    <div class="span6">
        <span><b>Direcciones pasajeros:</b></span>        
        <ul class="unstyled pasajerosDir" id="pasajerosDir">
            <?php
            if (is_array($pasajeroDir)) {
                foreach ($pasajeroDir as $key => $dir) {
                    ?>
                    <li id="dir-<?php echo $key; ?>" data-id="<?php echo $key; ?>"><?php echo $dir; ?></li>
                    <?php
                }
            }
            ?>            
        </ul>
    </div>    
</div>
<div class="row">
    <div class="span12">
        <span><b>Observaciones:</b></span>
        <p><?php echo $peticion->observaciones; ?></p>
    </div>
</div>
<div class="row">
    <div class="span12">
        <button  class="btn btn-primary" id="asignarPedido">Asignar pedido</button>
        <button type="button" class="btn btn-danger"id="eliminarPeticion" data-id-peticion="<?php echo $peticion->id; ?>">Eliminar</button>        
    </div>
</div>
<div class="row">
    <h3 class="span12">Pedidos</h3>
    <div id="pedidos" class="span12">
        <?php
        if (isset($pedidos)) {
            foreach ($pedidos as $idPedido => $pedido) {
                ?>
                <div id="pedidoForm-<?php echo $idPedido ?>" class="pedidoForm row <?php echo ($pedido["estadoReserva"] == '0') ? 'rSinLeer' : 'rLeido'; ?>" data-id-peticion="<?php echo $peticion->id; ?>" data-id-pedido="<?php echo $idPedido; ?>">
                    <form class="localPedidoForm span12">
                        <div class="row">
                            <div class="span12">
                                <div class="row">
                                    <div class="span6">
                                        <label>Hora <?php echo ($peticion->sentido == '0') ? 'fin:' : 'inicio:'; ?></label>
                                        <input type="text" class="timePicker required" value="<?php echo ($peticion->sentido == '0') ? $pedido['fin'] : $pedido['inicio']; ?>">
                                    </div>
                                    <div class="span6">
                                        <label>Vehiculo:</label>
                                        <select class="vehiculoLista required">
                                            <option value="<?php echo $pedido['idVehiculo']; ?>"><?php echo $pedido['placaVehiculo']; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="row">
                                    <div class="span6">
                                        <p><b>Direcciones empresa:</b></p>
                                        <ul class="unstyled empresasDir">
                                            <?php
                                            if (isset($pedido['empresaDir'])) {
                                                foreach ($pedido['empresaDir'] as $idDireccion => $direccion) {
                                                    ?>
                                                    <li id="dir-<?php echo $idDireccion; ?>" data-id="<?php echo $idDireccion; ?>"><?php echo $direccion; ?></li>   
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="span6">
                                        <p><b>Direcciones pasajeros:</b></p>        
                                        <ul class="unstyled pasajerosDir">
                                            <?php
                                            if (isset($pedido['pasajeroDir'])) {
                                                foreach ($pedido['pasajeroDir'] as $idDireccion => $direccion) {
                                                    ?>
                                                    <li id="dir-<?php echo $idDireccion; ?>" data-id="<?php echo $idDireccion; ?>"><?php echo $direccion; ?><i class="icon-time"></i></li>   
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="row">
                                    <div class="span12 botonesPedido">
                                        <button class="btn btn-success editarPedido" type="submit">Editar</button>                            
                                        <button type="button" class="btn btn-danger eliminarPedido">Eliminar</button>
                                        <i class="<?php echo ($pedido["estadoReserva"] == '0') ? 'icon-time' : 'icon-ok'; ?>"></i>
                                    </div>
                                </div>
                            </div>
                            <br style="clear: both;">
                        </div>
                        <hr>
                    </form>                    
                </div>                
                <?php
            }
        }
        ?>
    </div>    
</div>




<div id="pedidoFormulario" class="pedidoForm row" style="display: none;" data-id-peticion="<?php echo $peticion->id; ?>" data-id-pedido="">
    <form class="localPedidoForm span12">
        <div class="row">
            <div class="span12">
                <div class="row">
                    <div class="span6">
                        <label>Hora <?php echo ($peticion->sentido == '0') ? 'fin:' : 'inicio:'; ?></label>
                        <input type="text" class="timePicker required">
                    </div>
                    <div class="span6">
                        <label>Vehiculo:</label>
                        <select class="vehiculoLista required" disabled>
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span12">
                <div class="row">
                    <div class="span6">
                        <p><b>Direcciones empresa:</b></p>
                        <ul class="unstyled empresasDir"></ul>
                    </div>
                    <div class="span6">
                        <p><b>Direcciones pasajeros:</b></p>        
                        <ul class="unstyled pasajerosDir"></ul>
                    </div>
                </div>
            </div>
            <div class="span12">
                <div class="row">
                    <div class="span12 botonesPedido">
                        <button class="btn btn-success editarPedido" type="submit" style="display: none;">Editar</button>
                        <button class="btn btn-primary guardarPedido" type="submit">Guardar</button>
                        <button type="button" class="btn btn-danger eliminarPedido">Eliminar</button>
                        <i></i>
                    </div>
                </div>
            </div>
            <br style="clear: both;">
        </div>
        <hr>
    </form>

    <hr>
</div>
<!-- Modal -->
<div id="eliminarPedidoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="eliminarPedidoModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="eliminarPedidoModalLabel">¿Eliminar?</h3>
  </div>
  <div class="modal-body">
    <p>¿Desea eliminar este Pedido?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-primary" id="aceptarEliminarPedidoModal">Aceptar</button>
  </div>
</div>
<div id="eliminarPeticionModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="eliminarPeticionModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="eliminarPeticionModalLabel">¿Eliminar?</h3>
  </div>
  <div class="modal-body">
    <p>¿Desea eliminar esta Peticion?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-primary" id="aceptarEliminarPeticionModal">Aceptar</button>
  </div>
</div>