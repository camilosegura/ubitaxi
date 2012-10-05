<?php
/* @var $this OperadorVehiculoController */
/* @var $model OperadorVehiculo */

$this->breadcrumbs=array(
	'Operador Vehiculos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OperadorVehiculo', 'url'=>array('index')),
	array('label'=>'Create OperadorVehiculo', 'url'=>array('create')),
	array('label'=>'View OperadorVehiculo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OperadorVehiculo', 'url'=>array('admin')),
);
?>

<h1>Update OperadorVehiculo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>