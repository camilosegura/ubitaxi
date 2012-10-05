<?php
/* @var $this OperadorVehiculoController */
/* @var $model OperadorVehiculo */

$this->breadcrumbs=array(
	'Operador Vehiculos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OperadorVehiculo', 'url'=>array('index')),
	array('label'=>'Manage OperadorVehiculo', 'url'=>array('admin')),
);
?>

<h1>Create OperadorVehiculo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>