<?php
/* @var $this PhoneCarController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Phone Cars',
);

$this->menu=array(
	array('label'=>'Create PhoneCar', 'url'=>array('create')),
	array('label'=>'Manage PhoneCar', 'url'=>array('admin')),
);
?>

<h1>Phone Cars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
