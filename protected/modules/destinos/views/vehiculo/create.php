<?php
/* @var $this VehiculoController */
/* @var $model Vehiculo */

$this->breadcrumbs=array(
	'Vehiculos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vehiculo', 'url'=>array('index')),
	array('label'=>'Manage Vehiculo', 'url'=>array('admin')),
);
?>

<h1>Create Vehiculo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>