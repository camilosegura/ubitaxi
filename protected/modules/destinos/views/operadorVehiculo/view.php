<?php
/* @var $this OperadorVehiculoController */
/* @var $model OperadorVehiculo */

$this->breadcrumbs=array(
	'Operador Vehiculos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OperadorVehiculo', 'url'=>array('index')),
	array('label'=>'Create OperadorVehiculo', 'url'=>array('create')),
	array('label'=>'Update OperadorVehiculo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OperadorVehiculo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OperadorVehiculo', 'url'=>array('admin')),
);
?>

<h1>View OperadorVehiculo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_operador',
		'id_vehiculo',
	),
)); ?>
