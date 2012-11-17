<?php

$this->breadcrumbs=array(
	'Phone Cars'=>array('index'),
	'Cars',
);

$this->menu=array(
	array('label'=>'List PhoneCar', 'url'=>array('index')),
	array('label'=>'Create PhoneCar', 'url'=>array('create')),
);
?>
<ul>
<?php
foreach ($model as $key=>$field){
	?>
<li>
	<?php 
	echo CHtml::link($field->placa, array('/tracker/coordenates/showTrack/id/'.$field->placa));
	?>
</li>
	<?php 
}
?>
</ul>