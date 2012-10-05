<?php
/* @var $this CoordenatesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Coordenates',
);

$this->menu=array(
	array('label'=>'Create Coordenates', 'url'=>array('create')),
	array('label'=>'Manage Coordenates', 'url'=>array('admin')),
);
?>

<h1>Coordenates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
