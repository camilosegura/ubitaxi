<?php
/* @var $this PedidoAsignacionController */
/* @var $model PedidoAsignacion */

$this->breadcrumbs=array(
	'Pedido Asignacions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PedidoAsignacion', 'url'=>array('index')),
	array('label'=>'Create PedidoAsignacion', 'url'=>array('create')),
	array('label'=>'View PedidoAsignacion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PedidoAsignacion', 'url'=>array('admin')),
);
?>

<h1>Update PedidoAsignacion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>