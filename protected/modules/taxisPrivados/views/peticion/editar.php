<?php
$horaEmpresa = ($peticion->sentido == '0') ? $peticion->hora_empresa : '0';

$cs = Yii::app()->getClientScript();
$cs->registerScript('script', <<<JS

   var horaEmpresa = "$horaEmpresa";       
   
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

setTimePicker($('#pedidos'));



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
                console.log(rsp);
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
            that.hide();
            $('.editarPedido', pedidoForm).show();
        }
     });
     return false;
    } 
    
});

$('#pedidos').on('click', '.eliminarPedido', function(){
    var pedidoForm = $(this).parents('.pedidoForm');
    var idPedido = pedidoForm.data('idPedido');
    var url = '/taxisPrivados/pedido/peticionEliminar';
    var data = {
        id:idPedido
    };
    
    if(typeof idPedido != "undefined"){
        $.getJSON(url, data, function(rsp){
            if(rsp.success){
                console.log(rsp);
                var listas = pedidoForm.find('.pasajerosDir').html();    
                $('#pasajerosDir').append(listas);
                pedidoForm.remove();
            }
        });
    }else{
        var listas = pedidoForm.find('.pasajerosDir').html();    
        $('#pasajerosDir').append(listas);
        pedidoForm.remove();
    }
    
    
});

function setTimePicker(pedidoForm){
    $('.timePicker', pedidoForm).datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: new Date(horaEmpresa),
        onClose: function(dateText, inst){
            var that = $(this);
            var url = '/taxisPrivados/vehiculo/libres';
            var data = {
                horaInicio:horaEmpresa,
                horaFin:dateText
            };
            $.getJSON(url, data, function(rsp){
                var direccion = '';
                var pedidoForm = {};
                if(rsp.success){
                    $.each(rsp.libres, function(index, value){            
                        direccion += '<option value="'+index+'">'+value+'</option>';
                    });                    
                    that.parents('.pedidoForm').find('.vehiculoLista').html(direccion);;
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
      cursor: "move"
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

JS
        , CClientScript::POS_READY);
?>
<div class="row">
    <h1>Editar Petición</h1>
    <div class="span5"><span><b>Empresa:</b> <?php echo $peticion->empresa->nombre; ?></span></div>
    <div class="span5">  <span><b>Hora empresa:</b> <?php echo $peticion->hora_empresa ?></span></div>
</div>
<div class="row">
    <div class="span5">
        <span><b>Direcciones empresa:</b></span>
        <ul class="unstyled" id="empresaDir">
            <?php foreach ($empresaDir as $key => $dir) { ?>
                <li data-id="<?php echo $key; ?>"><?php echo $dir; ?></li>
            <?php } ?>            
        </ul>
    </div>
    <div class="span5">
        <span><b>Direcciones pasajeros:</b></span>        
        <ul class="unstyled pasajerosDir" id="pasajerosDir">
            <?php foreach ($pasajeroDir as $key => $dir) { ?>
                <li data-id="<?php echo $key; ?>"><?php echo $dir; ?></li>
            <?php } ?>            
        </ul>
    </div>
    <div class="span2">
        <button  class="btn btn-primary" id="asignarPedido">Asignar pedido</button>
        <button type="button" class="btn btn-danger">Eliminar</button>
    </div>
</div>
<div class="row">
    <div class="span12">
        <span><b>Observaciones:</b></span>
        <p><?php echo $peticion->observaciones; ?></p>
    </div>
</div>
<div class="row">
    <h3>Pedidos</h3>
    <div id="pedidos">
        <?php
        if (isset($pedidos)) {
            foreach ($pedidos as $idPedido => $pedido) {
                ?>
                <div class="pedidoForm row" data-id-peticion="<?php echo $peticion->id; ?>" data-id-pedido="<?php echo $idPedido; ?>">
                    <form class="localPedidoForm">
                        <div class="span5">
                            <label>Hora <?php echo ($peticion->sentido == '0') ? 'fin:' : 'inicio:'; ?></label>
                            <input type="text" class="timePicker required" value="<?php echo ($peticion->sentido == '0') ? $pedido['fin'] : $pedido['inicio']; ?>">
                        </div>
                        <div class="span5">
                            <label>Vehiculo:</label>
                            <select class="vehiculoLista required">
                                <option value="<?php echo $pedido['idVehiculo']; ?>"><?php echo $pedido['placaVehiculo']; ?></option>
                            </select>
                        </div>
                        <div class="span5">
                            <p><b>Direcciones empresa:</b></p>
                            <ul class="unstyled empresasDir" style="min-height: 10px;">
                                <?php
                                if (isset($pedido['empresaDir'])) {
                                    foreach ($pedido['empresaDir'] as $idDireccion => $direccion) {
                                        ?>
                                        <li data-id="<?php echo $idDireccion; ?>"><?php echo $direccion; ?></li>   
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="span5">
                            <p><b>Direcciones pasajeros:</b></p>        
                            <ul class="unstyled pasajerosDir" style="min-height: 10px;">
                                <?php
                                if (isset($pedido['pasajeroDir'])) {
                                    foreach ($pedido['pasajeroDir'] as $idDireccion => $direccion) {
                                        ?>
                                        <li data-id="<?php echo $idDireccion; ?>"><?php echo $direccion; ?></li>   
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="span2">
                            <button class="btn btn-success editarPedido" type="submit">Editar</button>                            
                            <button type="button" class="btn btn-danger eliminarPedido">Eliminar</button>
                        </div>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>    
</div>




<div id="pedidoFormulario" class="pedidoForm row" style="display: none;" data-id-peticion="<?php echo $peticion->id; ?>" data-id-pedido="">
    <form class="localPedidoForm">
        <div class="span5">
            <label>Hora <?php echo ($peticion->sentido == '0') ? 'fin:' : 'inicio:'; ?></label>
            <input type="text" class="timePicker required">
        </div>
        <div class="span5">
            <label>Vehiculo:</label>
            <select class="vehiculoLista required">
                <option></option>
            </select>
        </div>
        <div class="span5">
            <p><b>Direcciones empresa:</b></p>
            <ul class="unstyled empresasDir" style="min-height: 10px;"></ul>
        </div>
        <div class="span5">
            <p><b>Direcciones pasajeros:</b></p>        
            <ul class="unstyled pasajerosDir" style="min-height: 10px;"></ul>
        </div>
        <div class="span2">
            <button class="btn btn-success editarPedido" type="submit" style="display: none;">Editar</button>
            <button class="btn btn-primary guardarPedido" type="submit">Guardar</button>
            <button type="button" class="btn btn-danger eliminarPedido">Eliminar</button>
        </div>
    </form>
</div>