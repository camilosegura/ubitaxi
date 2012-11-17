<?php
/* @var $this EstadoVehiculoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Estado Vehiculos',
);

$this->menu=array(
	array('label'=>'Create EstadoVehiculo', 'url'=>array('create')),
	array('label'=>'Manage EstadoVehiculo', 'url'=>array('admin')),
);
?>

<h1>Estado Vehiculos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
