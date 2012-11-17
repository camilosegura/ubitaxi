<?php
/* @var $this OperadorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Operadors',
);

$this->menu=array(
	array('label'=>'Create Operador', 'url'=>array('create')),
	array('label'=>'Manage Operador', 'url'=>array('admin')),
);
?>

<h1>Operadors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
