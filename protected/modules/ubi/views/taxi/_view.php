<?php
/* @var $this TaxiController */
/* @var $model Taxi */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_vehiculo')); ?>:</b>
	<?php echo CHtml::encode($data->id_vehiculo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_propietario')); ?>:</b>
	<?php echo CHtml::encode($data->id_propietario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_propietario')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo_propietario); ?>
	<br />


</div>