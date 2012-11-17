<?php
/* @var $this CoordenatesController */
/* @var $model Coordenates */

$this->breadcrumbs=array(
	'Coordenates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Coordenates', 'url'=>array('index')),
	array('label'=>'Create Coordenates', 'url'=>array('create')),
	array('label'=>'Update Coordenates', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Coordenates', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Coordenates', 'url'=>array('admin')),
);
?>

<h1>View Coordenates #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'latitude',
		'longitude',
		'altitude',
		'speed',
		'time',
		'timeHost',
		'placa',
	),
)); ?>
