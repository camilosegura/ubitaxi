<?php
/* @var $this PhoneCarController */
/* @var $model PhoneCar */

$this->breadcrumbs=array(
	'Phone Cars'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PhoneCar', 'url'=>array('index')),
	array('label'=>'Create PhoneCar', 'url'=>array('create')),
	array('label'=>'View PhoneCar', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PhoneCar', 'url'=>array('admin')),
);
?>

<h1>Update PhoneCar <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>