<?php
/* @var $this EmergenciaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Emergencias',
);

$this->menu=array(
	array('label'=>'Create Emergencia', 'url'=>array('create')),
	array('label'=>'Manage Emergencia', 'url'=>array('admin')),
);
?>

<h1>Emergencias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
