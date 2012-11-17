<?php
/* @var $this PedidoController */
/* @var $model Pedido */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_estado')); ?>:</b>
	<?php echo CHtml::encode($data->id_estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pasajero')); ?>:</b>
	<?php echo CHtml::encode($data->id_pasajero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion_origen')); ?>:</b>
	<?php echo CHtml::encode($data->direccion_origen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitud')); ?>:</b>
	<?php echo CHtml::encode($data->latitud); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitud')); ?>:</b>
	<?php echo CHtml::encode($data->longitud); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_operador')); ?>:</b>
	<?php echo CHtml::encode($data->id_operador); ?>
	<br />

	*/ ?>

</div>