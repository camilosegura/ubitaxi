<?php
/* @var $this ConductorVehiculoController */
/* @var $model ConductorVehiculo */

$this->breadcrumbs=array(
	'Conductor Vehiculos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConductorVehiculo', 'url'=>array('index')),
	array('label'=>'Create ConductorVehiculo', 'url'=>array('create')),
	array('label'=>'Update ConductorVehiculo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConductorVehiculo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConductorVehiculo', 'url'=>array('admin')),
);
?>

<h1>View ConductorVehiculo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_conductor',
		'id_vehiculo',
	),
)); ?>
