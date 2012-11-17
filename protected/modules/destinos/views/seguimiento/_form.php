<?php
/* @var $this SeguimientoController */
/* @var $model Seguimiento */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'seguimiento-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_vehiculo'); ?>
		<?php echo $form->textField($model,'id_vehiculo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'id_vehiculo'); ?>
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
		<?php echo $form->labelEx($model,'altitud'); ?>
		<?php echo $form->textField($model,'altitud',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'altitud'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'velocidad'); ?>
		<?php echo $form->textField($model,'velocidad',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'velocidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_host'); ?>
		<?php echo $form->textField($model,'time_host',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'time_host'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->