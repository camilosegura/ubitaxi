<?php
/* @var $this CarrerasController */
/* @var $model Carreras */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'carreras-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_estado'); ?>
		<?php echo $form->textField($model,'id_estado'); ?>
		<?php echo $form->error($model,'id_estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_pasajero'); ?>
		<?php echo $form->textField($model,'id_pasajero'); ?>
		<?php echo $form->error($model,'id_pasajero'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion_origen'); ?>
		<?php echo $form->textField($model,'direccion_origen',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'direccion_origen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'latitud'); ?>
		<?php echo $form->textField($model,'latitud',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'latitud'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'longitud'); ?>
		<?php echo $form->textField($model,'longitud',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'longitud'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_operador'); ?>
		<?php echo $form->textField($model,'id_operador'); ?>
		<?php echo $form->error($model,'id_operador'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->