<?php
/* @var $this PeticionController */
/* @var $model Peticion */

$this->breadcrumbs=array(
	'Peticions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Peticion', 'url'=>array('index')),
	array('label'=>'Create Peticion', 'url'=>array('create')),
	array('label'=>'View Peticion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Peticion', 'url'=>array('admin')),
);
?>

<h1>Update Peticion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>