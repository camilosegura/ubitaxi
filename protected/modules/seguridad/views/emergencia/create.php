<?php
/* @var $this EmergenciaController */
/* @var $model Emergencia */

$this->breadcrumbs=array(
	'Emergencias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Emergencia', 'url'=>array('index')),
	array('label'=>'Manage Emergencia', 'url'=>array('admin')),
);
?>

<h1>Create Emergencia</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>