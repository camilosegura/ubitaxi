<?php
/* @var $this CoordenatesController */
/* @var $model Coordenates */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitude')); ?>:</b>
	<?php echo CHtml::encode($data->latitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitude')); ?>:</b>
	<?php echo CHtml::encode($data->longitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('altitude')); ?>:</b>
	<?php echo CHtml::encode($data->altitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speed')); ?>:</b>
	<?php echo CHtml::encode($data->speed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeHost')); ?>:</b>
	<?php echo CHtml::encode($data->timeHost); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('placa')); ?>:</b>
	<?php echo CHtml::encode($data->placa); ?>
	<br />

	*/ ?>

</div>