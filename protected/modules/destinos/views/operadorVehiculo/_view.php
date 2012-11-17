<?php
/* @var $this OperadorVehiculoController */
/* @var $model OperadorVehiculo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_operador')); ?>:</b>
	<?php echo CHtml::encode($data->id_operador); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_vehiculo')); ?>:</b>
	<?php echo CHtml::encode($data->id_vehiculo); ?>
	<br />


</div>