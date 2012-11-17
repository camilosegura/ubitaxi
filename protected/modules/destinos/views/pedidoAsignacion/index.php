<?php
/* @var $this PedidoAsignacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pedido Asignacions',
);

$this->menu=array(
	array('label'=>'Create PedidoAsignacion', 'url'=>array('create')),
	array('label'=>'Manage PedidoAsignacion', 'url'=>array('admin')),
);
?>

<h1>Pedido Asignacions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
