<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('script', <<<JS
var pasajero = $('#pasajeros');
var numPasajeros = $('#numPasajeros'); 
var empresa = $('#empresa');    
$('#horaSalida').timepicker();

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
            direccion += '<option value="'+index+'">'+value+'</option>';
        });
        $('#direccionSalida').html(direccion);
        
        $.each(rsp.usuario, function(index, value){
            pasajeros += '<optgroup label="'+value.nombre+'">';
            $.each(value.direccion, function(id, dir){
                pasajeros += '<option value="'+id+'">'+dir+'</option>';
            });
            pasajeros += '</optgroup>';
        });
        $('#pasajeros').html(pasajeros);
        numPasajeros.val(0);
    });
}
JS
        , CClientScript::POS_READY);
?>

<div class="row">
    <h1>Crear Pedido</h1>
    <div class="form span4">
        <?php echo CHtml::beginForm(); ?>

        <div>
            <?php echo CHtml::label('Empresa', 'empresa') ?>
            <?php echo CHtml::dropDownList('empresa', '', $empresas); ?>            
        </div>

        <div >
            <?php echo CHtml::label('Dirección de salida', 'direccionSalida'); ?>
            <?php echo CHtml::dropDownList('direccionSalida', '', array()) ?>
        </div> 
        <div >
            <?php echo CHtml::label('Pasajeros', 'pasajeros'); ?>
            <?php echo CHtml::dropDownList('pasajeros[]', '', array(), array('multiple' => 'multiple')) ?>
        </div>

        <div class="rememberMe">
            <?php echo CHtml::label('Número de pasajeros', 'numPasajeros'); ?>
            <?php echo CHtml::textField('numPasajeros', '', array('readonly' => 'readonly')) ?>
        </div>
        <div>
            <?php echo CHtml::label('Número de destinos', 'numDestinos'); ?>
            <?php echo CHtml::tag('input', array('type' => 'number', 'name' => 'numDestinos', 'id' => 'numDestinos')) ?>
        </div>
        <div>
            <?php echo CHtml::label('Hora de salida', 'horaSalida'); ?>
            <?php echo CHtml::textField('horaSalida') ?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Pedir'); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
    <div class="span8">
        <?php if($pedido["success"]){?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p><strong>Se ha hecho un pedido!</strong> En el siguiente enlace podra hacer seguimiento al su pedido.</p>
            <a href="<?php echo $this->createUrl('/taxisPrivados/pedido/ver', array('id'=>$pedido['id'])); ?>" class="btn btn-primary">Ver estado del pedido</a>
        </div>
        <?php } ?>
        <p>
            <a href="/taxisPrivados/usuario/nuevoPasajero.html" class="btn btn-primary">Nuevo pasajero</a>
            <a href="#" class="btn btn-primary">Nueva dirección</a>
        </p>
        
    </div>
</div>