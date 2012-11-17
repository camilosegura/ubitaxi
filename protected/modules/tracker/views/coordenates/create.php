<?php
/* @var $this CoordenatesController */
/* @var $model Coordenates */

$this->breadcrumbs=array(
	'Coordenates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Coordenates', 'url'=>array('index')),
	array('label'=>'Manage Coordenates', 'url'=>array('admin')),
);
?>

<h1>Create Coordenates</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>