<?php
/* @var $this ConductorVehiculoController */
/* @var $model ConductorVehiculo */

$this->breadcrumbs=array(
	'Conductor Vehiculos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConductorVehiculo', 'url'=>array('index')),
	array('label'=>'Create ConductorVehiculo', 'url'=>array('create')),
	array('label'=>'View ConductorVehiculo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConductorVehiculo', 'url'=>array('admin')),
);
?>

<h1>Update ConductorVehiculo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>