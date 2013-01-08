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
        'id' => 'user-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
    ?>

    <p class="note"><?php echo UserModule::t('Campos con <span class="required">*</span> son requeridos.'); ?></p>

    <?php echo $form->errorSummary(array($model)); ?>

    <div >
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div >
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div >
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'email'); ?>
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
    <div>
        <?php echo CHtml::dropDownList('empresa', '', $empresas); ?>            
    </div>

    <div class="buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
    </div>
    <div>
        <?php echo CHtml::hiddenField('latitud', $latitud); ?>
        <?php echo CHtml::hiddenField('longitud', $longitud); ?>
        <?php echo CHtml::hiddenField('direccionTexto', $direccionTexto); ?>
        <?php echo CHtml::hiddenField('ciudad', $ciudad); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->
