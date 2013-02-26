<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/geolocation.js', CClientScript::POS_END);
$cs->registerScript('script', <<<JS
var pasajero = $('#pasajeros');
var numPasajeros = $('#numPasajeros'); 
var empresa = $('#empresa');    
var pasajerosExcelForm = $('#pasajerosExcelForm');
var direccionesPasajero = $('#direccionesPasajero');
var localDireccion;
$('#horaEmpresa').datetimepicker({
    dateFormat: "yy-mm-dd",
    timeFormat: "HH:mm:ss"
});

getUsuariosYDireccionesEmpresa();

        
empresa.change(function(){
    getUsuariosYDireccionesEmpresa();
});
pasajero.click(function(){
    if($(this).val() != null){
        numPasajeros.val($(this).val().length);
    }else{
        numPasajeros.val(0);
    }
});

pasajerosExcelForm.submit(function(){
    var formdata = new FormData();
    var input = document.getElementById("pasajerosExcel");
    var idEmpresa = empresa.val();
    $('#pasajerosError').html();
    $('#pasajerosError').parent().hide();
    formdata.append("pasajerosExcel", input.files[0]);
    formdata.append("idEmpresa", idEmpresa);    
    if (formdata) {
        $.ajax({
            url: "/taxisPrivados/usuario/nuevoArchivo",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false                
        }).done(function(data, textStatus, jqXHR){
            data = JSON.parse(data);
            $.each(data.pasajeros, function(id, pasajero){
                if($('#pasajero-'+id).length == 0){
                    pasajeros = '<fieldset id="pasajero-'+id+'" class="table-bordered"><legend>'+pasajero.nombre+'</legend>';                                   
                    pasajeros += '<div class="row"><label class="checkbox span5"><input type="checkbox" class="chb" name="pasajeros[]" id="'+pasajero.idDireccion+'" value="'+pasajero.idDireccion+'" checked>'+pasajero.direccion+'</label><div class="span3"><button class="btn btn-success editarDireccion" type="button" data-id-direccion="'+pasajero.idDireccion+'">Editar</button><button type="button" class="btn btn-danger eliminarDireccion" data-id-direccion="'+pasajero.idDireccion+'">Eliminar</button></div></div>';                    
                    pasajeros += '</fieldset>';
                    direccionesPasajero.append(pasajeros);
                }else{
                    if($('#'+pasajero.idDireccion).length == 0){
                        pasajeros = '<div class="row"><label class="checkbox span5"><input type="checkbox" class="chb" name="pasajeros[]" id="'+pasajero.idDireccion+'" value="'+pasajero.idDireccion+'" checked>'+pasajero.direccion+'</label><div class="span3"><button class="btn btn-success editarDireccion" type="button" data-id-direccion="'+pasajero.idDireccion+'">Editar</button><button type="button" class="btn btn-danger eliminarDireccion" data-id-direccion="'+pasajero.idDireccion+'">Eliminar</button></div></div>';                    
                        $('#pasajero-'+id).append(pasajeros);
                    }
                }               
            });
             if(data.pasajeros.error){
                    errorPasajero = '';
                    $.each(data.pasajeros.errores, function(index, error){
                        errorPasajero += '<li>'+error+'</li>';
                    });
                    $('#pasajerosError').html(errorPasajero);
                    $('#pasajerosError').parent().show();
                }
        });
    }
    return false;
});

$(document).on('click', '.eliminarDireccion', function(){
    localDireccion = $(this);
    $('#eliminarDireccionModal').modal('toggle');            
});

$('#aceptarEliminarDireccionModal').click(function(){
    eliminarDireccion();
    $('#eliminarDireccionModal').modal('toggle');
});

$(document).on('click', '.eliminarPasajero', function(){
    localPasajero = $(this);
    $('#eliminarPasajeroModal').modal('toggle');            
});

$('#aceptarEliminarPasajeroModal').click(function(){
    eliminarPasajero();
    $('#eliminarPasajeroModal').modal('toggle');
});

$(document).on('click', '.editarDireccion', function(){
    $('#direccionMapa').text($(this).parent().parent().children('label').text());
    $('#editarDireccion').show();
    initialize();
});            

$('#cancelarMapa').click(function(){
    $('#editarDireccion').hide();
});

$('#aceptarMapa').click(function(){
    $('#editarDireccion').hide();
});

$(document).on('change', '.chb', function(){
    $('input[type="checkbox"]', $(this).parent().parent().parent()).addClass('chb');
    $(this).removeClass('chb');
    $('.chb', $(this).parent().parent().parent()).attr('checked',false);
});

$(document).on('mouseenter', '.editButtons', function(){
    $('i', $(this)).removeClass('icon-white');
});

$(document).on('mouseleave', '.editButtons', function(){
    $('i', $(this)).addClass('icon-white');
});

function eliminarDireccion(){
    var url = '/taxisPrivados/usuario/desactivarDireccion';
    var data = {
        idDireccion:localDireccion.data('idDireccion')
    };
    
    $.getJSON(url, data, function(rsp){
        if(rsp.success){
            localDireccion.parent().parent().remove();
        }
    });
}

function eliminarPasajero(){
    var url = '/taxisPrivados/usuario/desactivar';
    var data = {
        idPasajero:localPasajero.data('idPasajero')
    };
    
    $.getJSON(url, data, function(rsp){
        if(rsp.success){
            localPasajero.parent().parent().parent().remove();
        }
    });
}

function getUsuariosYDireccionesEmpresa(){
    var idEmpresa = $('#empresa').val();
    var url = '/taxisPrivados/empresa/usuariosYDirecciones';
    var data = {
        id:idEmpresa
    };
    $.getJSON(url, data, function(rsp){
        var direccion = '<legend>Dirección empresa</legend>';
        var pasajeros = ''; 
        var soloUna = 0;
        $.each(rsp.direccion, function(index, value){            
            soloUna++;
            direccion += '<div class="row editButtons"><label class="checkbox span6"><input type="checkbox" name="direccionEmpresa[]" value="'+index+'">'+value+'</label><div class="span1"><i class="icon-edit icon-white editarDireccion" data-id-direccion="'+index+'"></i><i class="icon-trash icon-white eliminarDireccion" data-id-direccion="'+index+'"></i></div></div>';
        });
        if(soloUna === 1){
            direccion = $(direccion);
            $(direccion).find('input').attr("checked", true);
        }
        $('#direccionesEmpresa').html(direccion);
        if(typeof rsp.usuario === "undefined"){
            pasajeros = "<p>Por favor ingrese pasajeros.</p>";
        }else{
            $.each(rsp.usuario, function(index, value){
                pasajeros += '<fieldset id="pasajero-'+index+'" class="table-bordered"><legend class="editButtons"><span class="span6">'+value.nombre+'</span><span class="span1"><i class="icon-edit icon-white editarPasajero" data-id-pasajero="'+index+'"></i><i class="icon-trash icon-white eliminarPasajero" data-id-pasajero="'+index+'"></i></span><br class="clearfix"></legend>';
                if(typeof value.direccion === "undefined"){
                    pasajeros += "<p>Por favor ingrese una dirección.</p>";
                }else{
                    $.each(value.direccion, function(id, dir){                
                        pasajeros += '<div class="row editButtons"><label class="checkbox span6"><input type="checkbox" class="chb" name="pasajeros[]" id="'+id+'" value="'+id+'">'+dir+'</label><div class="span1"><i class="icon-edit icon-white editarDireccion" data-id-direccion="'+id+'"></i><i class="icon-trash icon-white eliminarDireccion" data-id-direccion="'+id+'"></i></div></div>';
                    });
                }    
                pasajeros += '</fieldset>';
            });
        }
        direccionesPasajero.html(pasajeros);
        //checkToRadio();
        numPasajeros.val(0);
    });
}

function checkToRadio(){
    $(".chb").each(function(){
          $(this).change(function(){
                $(".chb").attr('checked',false);
                $(this).attr('checked',true);
           });
     });                            
}
    
JS
        , CClientScript::POS_READY);
?>
<style type="text/css">
    .table-bordered{
        border-left: 1px solid #ddd;
        padding: 0 20px;
        margin-bottom: 15px;
    }
    .editarDireccion, .editarPasajero{
        margin-right: 10px;
    }
    .span3 {
        margin-bottom: 10px;
        width: 156px;
    }
    #editarDireccion{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: transparent;     
        background-image: url('/images/background.png');
        z-index: 10000;
    }
    #editarDireccion .span12{
        margin: 100px auto;
        float: none;
        background-color: white;
    }
    #pasajerosExcelForm fieldset{
        padding: 10px;
    }
    .peticionLabel{
        width: 220px;
    }
    i{
        cursor: pointer;
    }
</style>
<div class="row">
    <h1 class="span8">Crear Petición</h1>
    <div class="form span8">
        <?php echo CHtml::beginForm(); ?>

        <div>
            <?php echo CHtml::label('Sentido', 'sentido', array('class'=>'peticionLabel')) ?>
            <?php echo CHtml::dropDownList('sentido', '', array('0' => 'Empresa - Casa', '1' => 'Casa - Empresa')); ?>            
        </div>
        <div>
            <?php echo CHtml::label('Empresa', 'empresa', array('class'=>'peticionLabel')) ?>
            <?php echo CHtml::dropDownList('empresa', '', $empresas); ?>            
        </div>

        <div >            
            <fieldset id="direccionesEmpresa" class="table-bordered"></fieldset>            
        </div> 
        <div >
            <h3>Pasajeros</h3>
            <div id="direccionesPasajero"></div>              
        </div>                
        <div>
            <?php echo CHtml::label('Hora empresa', 'horaEmpresa'); ?>
            <?php echo CHtml::textField('horaEmpresa') ?>
        </div>
        <div>
            <?php echo CHtml::label('Observaciones', 'observaciones'); ?>
            <?php echo CHtml::textArea('observaciones') ?>
        </div>
        <div class="submit">
            <?php echo CHtml::submitButton('Pedir', array('class' => 'btn btn-primary')); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
    <div class="span4">
        <?php if ($peticion["success"]) { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p><strong>Se ha hecho una petición!</strong></p>
                <a href="<?php echo $this->createUrl('/taxisPrivados/peticion/ver', array('id' => $peticion['id'])); ?>" class="btn btn-primary">Ver</a>                
            </div>
        <?php } ?>  
        <?php if (count($error)) { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p><strong>Hay errores en el formulario</strong></p>
                <ul>
                    <?php foreach ($error as $key => $er) { ?>
                        <li><?php echo "<b>$key</b> {$er[0]}"; ?></li>
                    <? } ?>
                </ul>
            </div>
        <?php } ?>
        <div>
            <form id="pasajerosExcelForm" enctype="multipart/form-data">
                <fieldset class="table-bordered">                    
                    <label for="pasajerosExcel">Subir listado de pasajeros:</label>
                    <input type="file" name="pasajerosExcel" id="pasajerosExcel">
                    <button type="submit" class="btn">Cargar</button>                    
                </fieldset>
            </form>            
        </div>
        <div class="alert alert-error" style="display: none;">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p><strong>Hay errores con los pasajeros</strong></p>
            <ul id="pasajerosError">

            </ul>
        </div>
    </div>
    <div id="editarDireccion">
        <div class="row">
            <div class="span12">
                <div class="row">
                    <div  id="map_canvas" class="span8"></div>
                    <div class="span4">
                        <dl>
                            <dt>Direccion:</dt>
                            <dd id="direccionMapa"></dd>                            
                        </dl>
                        <button class="btn btn-primary" id="aceptarMapa">Aceptar</button>
                        <button class="btn btn-danger" id="cancelarMapa">Cancelar</button>
                        <p>Para ubicar las coordenadas de la dirección por favor <b>haga click</b> o <b>mueva el globo</b> al lugar al que pertenece.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="eliminarDireccionModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="eliminarDireccionModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="eliminarDireccionModalLabel">¿Eliminar?</h3>
    </div>
    <div class="modal-body">
        <p>¿Desea eliminar esta dirección?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button class="btn btn-primary" id="aceptarEliminarDireccionModal">Aceptar</button>
    </div>
</div>
<div id="eliminarPasajeroModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="eliminarPasajeroModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="eliminarPasajeroModalLabel">¿Eliminar?</h3>
    </div>
    <div class="modal-body">
        <p>¿Desea eliminar este pasajero?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button class="btn btn-primary" id="aceptarEliminarPasajeroModal">Aceptar</button>
    </div>
</div>