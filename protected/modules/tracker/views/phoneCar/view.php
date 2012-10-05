<?php
/* @var $this PhoneCarController */
/* @var $model PhoneCar */

$this->breadcrumbs=array(
	'Phone Cars'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PhoneCar', 'url'=>array('index')),
	array('label'=>'Create PhoneCar', 'url'=>array('create')),
	array('label'=>'Update PhoneCar', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PhoneCar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PhoneCar', 'url'=>array('admin')),
);
?>

<h1>View PhoneCar #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_android',
		'placa',
	),
)); ?>
