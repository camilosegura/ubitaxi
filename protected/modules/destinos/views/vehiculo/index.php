<?php
/* @var $this VehiculoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehiculos',
);

$this->menu=array(
	array('label'=>'Create Vehiculo', 'url'=>array('create')),
	array('label'=>'Manage Vehiculo', 'url'=>array('admin')),
);
?>

<h1>Vehiculos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
