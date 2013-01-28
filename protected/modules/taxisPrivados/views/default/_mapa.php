<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $this EmpresaController */
/* @var $model Empresa */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/geolocation.js', CClientScript::POS_END);
$cs->registerScript('script', <<<JS
    initialize();
JS
        , CClientScript::POS_READY);
?>
<div  id="map_canvas" class="span8"></div>