<?php
/* @var $this PedidoAsignacionController */
/* @var $model PedidoAsignacion */

$this->breadcrumbs=array(
	'Pedido Asignacions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PedidoAsignacion', 'url'=>array('index')),
	array('label'=>'Manage PedidoAsignacion', 'url'=>array('admin')),
);
?>

<h1>Create PedidoAsignacion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>