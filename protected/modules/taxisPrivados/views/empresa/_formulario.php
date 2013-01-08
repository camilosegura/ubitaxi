<?php
/* @var $this EmpresaController */
/* @var $model Empresa */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/geolocation.js', CClientScript::POS_END);
$cs->registerScript('script', <<<JS
    initialize();
JS
        , CClientScript::POS_READY);
?>

<div class="form span4">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'empresa-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="">
        <?php echo $form->labelEx($model, 'nombre'); ?>
        <?php echo $form->textField($model, 'nombre', array('size' => 60, 'maxlength' => 500)); ?>
        <?php echo $form->error($model, 'nombre'); ?>
    </div>
    <div>
        <label for="direccionNumero" class="required">Dirección <span class="required">*</span></label>
        <div class="input-prepend">        
            <span class="add-on" id="dirTexto"></span>
            <input id="direccionNumero" name="direccionNumero" type="text">        
        </div>
    </div>
    <div>
        <?php echo CHtml::label('Complemento dirección ( bloque, etc)', 'direccionCompl'); ?>
        <?php echo CHtml::textField('direccionCompl'); ?>
    </div>
    <div class="buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
    <div>
        <?php echo CHtml::hiddenField('latitud', $latitud); ?>
        <?php echo CHtml::hiddenField('longitud', $longitud); ?>
        <?php echo CHtml::hiddenField('direccionTexto', $direccionTexto); ?>
        <?php echo CHtml::hiddenField('ciudad', $ciudad); ?>
    </div>
    <?php $this->endWidget(); ?>        

</div><!-- form -->
