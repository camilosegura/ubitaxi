<?php
/* @var $this EstadoVehiculoController */
/* @var $model EstadoVehiculo */

$this->breadcrumbs=array(
	'Estado Vehiculos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EstadoVehiculo', 'url'=>array('index')),
	array('label'=>'Manage EstadoVehiculo', 'url'=>array('admin')),
);
?>

<h1>Create EstadoVehiculo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>