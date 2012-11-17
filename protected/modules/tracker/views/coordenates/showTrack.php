<?php
Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js?sensor=true');
Yii::app()->clientScript->registerScript('map', "
	
		    var latlng = new google.maps.LatLng(".$model1->latitude .", ".$model1->longitude .");
		    var myOptions = {
		      zoom: 18,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP
		    };
		    var map = new google.maps.Map(document.getElementById('map_canvas'),
		        myOptions);
				
			var cafeMarkerImage =
		      new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=cafe|FFFF00');
		    var cafeMarker = new google.maps.Marker({
		      position: latlng,
		      map: map,
		      icon: cafeMarkerImage,
		      title: '".$model1->timeHost ."'
		  });
	
	
	
");
$this->breadcrumbs=array(
	'Coordenates'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Coordenates', 'url'=>array('index')),
array('label'=>'Create Coordenates', 'url'=>array('create')),
);
?>
<h1>Seguimiento al Movil</h1>
<div id="map_canvas" style=" height:500px" class="span-18"></div>

<?php 
Yii::import('application.extensions.EGMap.*');
$gMap = new EGMap();
 
$gMap->setWidth(710);
// it can also be called $gMap->height = 400;
$gMap->setHeight(400);
$gMap->zoom = 18; 

 
$first = array_slice($model, 0, 1);
$last = array_slice($model, -1, 1);

$start =  new EGMapCoord($first[0]->latitude, $first[0]->longitude);
$stop =  new EGMapCoord($last[0]->latitude, $last[0]->longitude);

$waypoints = array();
echo $i = 0;
foreach ($model as $key=>$field){
	echo ++$i.'<br>';
	$point = new EGMapCoord($field->latitude, $field->longitude, true);
	$waypoints[] = new EGMapDirectionWayPoint($point);
}
$gMap->setCenter($first[0]->latitude, $first[0]->longitude);
$direction = new EGMapDirection($start, $stop, 'direction_sample', array('waypoints' => $waypoints));

$direction->optimizeWaypoints = true;
$direction->provideRouteAlternatives = true;
 
$renderer = new EGMapDirectionRenderer();
$renderer->draggable = true;
$renderer->panel = "direction_pane";
$renderer->setPolylineOptions(array('strokeColor'=>'#FFAA00'));
 
$direction->setRenderer($renderer);
 
$gMap->addDirection($direction);
 
$gMap->renderMap();

?>
<div id="direction_pane"></div>

