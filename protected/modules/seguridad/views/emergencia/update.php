<?php
/* @var $this EmergenciaController */
/* @var $model Emergencia */

$this->breadcrumbs=array(
	'Emergencias'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Emergencia', 'url'=>array('index')),
	array('label'=>'Create Emergencia', 'url'=>array('create')),
	array('label'=>'View Emergencia', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Emergencia', 'url'=>array('admin')),
);
?>

<h1>Update Emergencia <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>