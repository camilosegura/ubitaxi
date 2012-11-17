<?php
/* @var $this EstadoVehiculoController */
/* @var $model EstadoVehiculo */

$this->breadcrumbs=array(
	'Estado Vehiculos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EstadoVehiculo', 'url'=>array('index')),
	array('label'=>'Create EstadoVehiculo', 'url'=>array('create')),
	array('label'=>'View EstadoVehiculo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EstadoVehiculo', 'url'=>array('admin')),
);
?>

<h1>Update EstadoVehiculo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>