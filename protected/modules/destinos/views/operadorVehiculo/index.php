<?php
/* @var $this OperadorVehiculoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Operador Vehiculos',
);

$this->menu=array(
	array('label'=>'Create OperadorVehiculo', 'url'=>array('create')),
	array('label'=>'Manage OperadorVehiculo', 'url'=>array('admin')),
);
?>

<h1>Operador Vehiculos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
