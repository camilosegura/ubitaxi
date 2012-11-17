<?php
/* @var $this VehiculoController */
/* @var $model Vehiculo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehiculo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo'); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'placa'); ?>
		<?php echo $form->textField($model,'placa',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'placa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_conductor'); ?>
		<?php echo $form->textField($model,'id_conductor'); ?>
		<?php echo $form->error($model,'id_conductor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_seguimiento'); ?>
		<?php echo $form->textField($model,'id_seguimiento'); ?>
		<?php echo $form->error($model,'id_seguimiento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_telefono'); ?>
		<?php echo $form->textField($model,'id_telefono',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'id_telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_pedido'); ?>
		<?php echo $form->textField($model,'id_pedido'); ?>
		<?php echo $form->error($model,'id_pedido'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->