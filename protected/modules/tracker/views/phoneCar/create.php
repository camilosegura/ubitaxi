<?php
/* @var $this PhoneCarController */
/* @var $model PhoneCar */

$this->breadcrumbs=array(
	'Phone Cars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PhoneCar', 'url'=>array('index')),
	array('label'=>'Manage PhoneCar', 'url'=>array('admin')),
);
?>

<h1>Create PhoneCar</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>