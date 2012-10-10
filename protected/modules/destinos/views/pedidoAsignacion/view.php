<?php
/* @var $this PedidoAsignacionController */
/* @var $model PedidoAsignacion */

$this->breadcrumbs=array(
	'Pedido Asignacions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PedidoAsignacion', 'url'=>array('index')),
	array('label'=>'Create PedidoAsignacion', 'url'=>array('create')),
	array('label'=>'Update PedidoAsignacion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PedidoAsignacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PedidoAsignacion', 'url'=>array('admin')),
);
?>

<h1>View PedidoAsignacion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_carrera',
		'id_vehiculo',
		'time',
	),
)); ?>
