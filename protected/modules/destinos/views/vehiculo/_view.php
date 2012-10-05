<?php
/* @var $this VehiculoController */
/* @var $model Vehiculo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('placa')); ?>:</b>
	<?php echo CHtml::encode($data->placa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_conductor')); ?>:</b>
	<?php echo CHtml::encode($data->id_conductor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_seguimento')); ?>:</b>
	<?php echo CHtml::encode($data->id_seguimento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_telefono')); ?>:</b>
	<?php echo CHtml::encode($data->id_telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />


</div>