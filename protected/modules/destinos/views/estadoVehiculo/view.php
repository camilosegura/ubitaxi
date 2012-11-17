<?php
/* @var $this EstadoVehiculoController */
/* @var $model EstadoVehiculo */

$this->breadcrumbs=array(
	'Estado Vehiculos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EstadoVehiculo', 'url'=>array('index')),
	array('label'=>'Create EstadoVehiculo', 'url'=>array('create')),
	array('label'=>'Update EstadoVehiculo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EstadoVehiculo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EstadoVehiculo', 'url'=>array('admin')),
);
?>

<h1>View EstadoVehiculo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'estado',
		'id_vehiculo',
		'time',
	),
)); ?>
