<?php
/* @var $this TaxiController */
/* @var $model Taxi */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_vehiculo'); ?>
		<?php echo $form->textField($model,'id_vehiculo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_propietario'); ?>
		<?php echo $form->textField($model,'id_propietario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_tipo_propietario'); ?>
		<?php echo $form->textField($model,'id_tipo_propietario'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->