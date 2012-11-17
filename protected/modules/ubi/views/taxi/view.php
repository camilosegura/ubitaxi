<?php
/* @var $this TaxiController */
/* @var $model Taxi */

$this->breadcrumbs=array(
	'Taxis'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Taxi', 'url'=>array('index')),
	array('label'=>'Create Taxi', 'url'=>array('create')),
	array('label'=>'Update Taxi', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Taxi', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Taxi', 'url'=>array('admin')),
);
?>

<h1>View Taxi #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_vehiculo',
		'id_propietario',
		'id_tipo_propietario',
	),
)); ?>
