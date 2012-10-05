<?php
/* @var $this CoordenatesController */
/* @var $model Coordenates */

$this->breadcrumbs=array(
	'Coordenates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Coordenates', 'url'=>array('index')),
	array('label'=>'Create Coordenates', 'url'=>array('create')),
	array('label'=>'View Coordenates', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Coordenates', 'url'=>array('admin')),
);
?>

<h1>Update Coordenates <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>