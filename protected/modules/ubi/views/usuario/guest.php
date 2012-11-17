<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true", CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/geolocation.js', CClientScript::POS_END);
?>

<div class="span5">
    <div id="map_canvas"></div>
</div>
<div class="span4">

    <div class="form">
        <?php echo CHtml::beginForm("", "", array('class' => 'form-horizontal')); ?>

        <div class="control-group">
            <?php echo CHtml::label('Nombre', 'nombre', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nombre', "", array('placeholder' => 'Ingrese su Nombre')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Celular', 'celular', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('celular', "", array('placeholder' => 'Ingrese su Celular')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dirección', 'direccion', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('direccion', "", array('placeholder' => 'Ingrese su Dirección')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('email', 'email', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('email', "", array('placeholder' => 'Ingrese su email')) ?>
            </div>
        </div>
        <div>
            <?php echo CHtml::hiddenField('latitud', '0') ?>
            <?php echo CHtml::hiddenField('longitud', '0') ?>
        </div>


        <div class="control-group" id="buttons-guest">
            <?php echo CHtml::ajaxSubmitButton('Solicitar', '/ubi/usuario/hacerPedido', 
                    array(
                        'success'=>'function(data){                        
                        idPedido = data.id_pedido;
                        alert(idPedido);
                            }'
                        )); ?>
            
            <?php echo CHtml::ajaxSubmitButton('Cancelar', '/fdsfsd'); ?>
            
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->

</div>
