<?php
/* @var $this OperadorController */
/* @var $model Operador */

$this->breadcrumbs=array(
	'Operadors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Operador', 'url'=>array('index')),
	array('label'=>'Manage Operador', 'url'=>array('admin')),
);
?>

<h1>Create Operador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>