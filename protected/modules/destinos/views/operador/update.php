<?php
/* @var $this OperadorController */
/* @var $model Operador */

$this->breadcrumbs=array(
	'Operadors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Operador', 'url'=>array('index')),
	array('label'=>'Create Operador', 'url'=>array('create')),
	array('label'=>'View Operador', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Operador', 'url'=>array('admin')),
);
?>

<h1>Update Operador <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>