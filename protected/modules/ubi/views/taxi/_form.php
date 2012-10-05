<?php
/* @var $this TaxiController */
/* @var $model Taxi */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'taxi-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_vehiculo'); ?>
		<?php echo $form->textField($model,'id_vehiculo'); ?>
		<?php echo $form->error($model,'id_vehiculo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_propietario'); ?>
		<?php echo $form->textField($model,'id_propietario'); ?>
		<?php echo $form->error($model,'id_propietario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_tipo_propietario'); ?>
		<?php echo $form->textField($model,'id_tipo_propietario'); ?>
		<?php echo $form->error($model,'id_tipo_propietario'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->