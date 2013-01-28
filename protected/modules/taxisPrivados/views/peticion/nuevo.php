<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('script', <<<JS
var pasajero = $('#pasajeros');
var numPasajeros = $('#numPasajeros'); 
var empresa = $('#empresa');    
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


function getUsuariosYDireccionesEmpresa(){
    var idEmpresa = $('#empresa').val();
    var url = '/taxisPrivados/empresa/usuariosYDirecciones';
    var data = {
        id:idEmpresa
    };
    $.getJSON(url, data, function(rsp){
        var direccion = '';
        var pasajeros = '';        
        $.each(rsp.direccion, function(index, value){            
            direccion += '<label class="checkbox"><input type="checkbox" name="direccionEmpresa[]" value="'+index+'">'+value+'</label>';
        });
        $('#direccionesEmpresa').html(direccion);
        
        $.each(rsp.usuario, function(index, value){
            pasajeros += '<label>'+value.nombre+'</label>';
            $.each(value.direccion, function(id, dir){                
                pasajeros += '<label class="checkbox"><input type="checkbox" class="chb" name="pasajeros[]" value="'+id+'">'+dir+'</label>';
            });            
        });
        $('#direccionesPasajero').html(pasajeros);
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

<div class="row">
    <h1>Crear Petición</h1>
    <div class="form span4">
        <?php echo CHtml::beginForm(); ?>

        <div>
            <?php echo CHtml::label('Sentido', 'sentido') ?>
            <?php echo CHtml::dropDownList('sentido', '', array('0'=>'Empresa - Casa', '1'=>'Casa - Empresa')); ?>            
        </div>
        <div>
            <?php echo CHtml::label('Empresa', 'empresa') ?>
            <?php echo CHtml::dropDownList('empresa', '', $empresas); ?>            
        </div>

        <div >
            <?php echo CHtml::label('Dirección empresa', 'direccionSalida'); ?> 
            <fieldset id="direccionesEmpresa"></fieldset>            
        </div> 
        <div >
            <?php echo CHtml::label('Pasajeros', 'pasajeros'); ?>
            <fieldset id="direccionesPasajero"></fieldset>              
        </div>
        <div class="rememberMe">
            <?php echo CHtml::label('Número de pasajeros', 'numPasajeros'); ?>
            <?php echo CHtml::textField('numPasajeros', '', array('readonly' => 'readonly')) ?>
        </div>        
        <div>
            <?php echo CHtml::label('Hora empresa', 'horaEmpresa'); ?>
            <?php echo CHtml::textField('horaEmpresa') ?>
        </div>
        <div>
            <?php echo CHtml::label('Observaciones', 'observaciones'); ?>
            <?php echo CHtml::textArea('observaciones') ?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Pedir'); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
    <div class="span8">
        <?php if($peticion["success"]){?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p><strong>Se ha hecho una petición!</strong></p>
            <a href="<?php echo $this->createUrl('/taxisPrivados/peticion/ver', array('id'=>$peticion['id'])); ?>" class="btn btn-primary">Ver</a>
            <a href="<?php echo $this->createUrl('/taxisPrivados/peticion/editar', array('id'=>$peticion['id'])); ?>" class="btn btn-primary">Editar</a>
        </div>
        <?php } ?>
        <p>
            <a href="/taxisPrivados/usuario/nuevoPasajero.html" class="btn btn-primary">Nuevo pasajero</a>
            <a href="#" class="btn btn-primary">Nueva dirección</a>
        </p>
        
    </div>
</div>