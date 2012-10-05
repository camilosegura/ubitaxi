<?php
/* @var $this ConductorVehiculoController */
/* @var $model ConductorVehiculo */

$this->breadcrumbs=array(
	'Conductor Vehiculos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConductorVehiculo', 'url'=>array('index')),
	array('label'=>'Manage ConductorVehiculo', 'url'=>array('admin')),
);
?>

<h1>Create ConductorVehiculo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>