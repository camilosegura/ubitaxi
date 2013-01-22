<?php
/* @var $this PeticionController */
/* @var $model Peticion */

$this->breadcrumbs=array(
	'Peticions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Peticion', 'url'=>array('index')),
	array('label'=>'Manage Peticion', 'url'=>array('admin')),
);
?>

<h1>Create Peticion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>