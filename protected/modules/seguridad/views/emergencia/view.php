<?php
/* @var $this EmergenciaController */
/* @var $model Emergencia */

$this->breadcrumbs=array(
	'Emergencias'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Emergencia', 'url'=>array('index')),
	array('label'=>'Create Emergencia', 'url'=>array('create')),
	array('label'=>'Update Emergencia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Emergencia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Emergencia', 'url'=>array('admin')),
);
?>

<h1>View Emergencia #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_vehiculo',
		'time',
		'estado',
	),
)); ?>
