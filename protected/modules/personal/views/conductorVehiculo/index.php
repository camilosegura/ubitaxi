<?php
/* @var $this ConductorVehiculoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Conductor Vehiculos',
);

$this->menu=array(
	array('label'=>'Create ConductorVehiculo', 'url'=>array('create')),
	array('label'=>'Manage ConductorVehiculo', 'url'=>array('admin')),
);
?>

<h1>Conductor Vehiculos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
