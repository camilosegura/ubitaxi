<?php
$this->pageTitle = Yii::app()->name . ' - ' . "Control";
$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true", CClientScript::POS_END);
//$cs->registerScriptFile(Yii::app()->theme->getBaseUrl() . '/js/geolocation.js', CClientScript::POS_END);
$cs->registerScript('ubicar', '$("#posicion").click(function(){
    
    Locator.showToast("Hola Android");
    

})', CClientScript::POS_END)
?>
<div class="span10">
    <button class="btn" id="">Detalles</button>
    <button class="btn" id="">Emergencia</button>
    <select>
        <option>No disponible</option>
        <option>Almorzando</option>
        <option>Varado</option>
    </select>
    <button class="btn" id="">Salir</button>
    <span>Dirección</span>
    <span></span>
    <span>Celular:</span>
    <span></span>
    <button class="btn" id="posicion">Posición GPS</button>
    <button class="btn" id="">Navegación GPS</button>
    <span></span>
    <button class="btn" id="">Enviar Mensaje</button>
    <button class="btn" id="">Demora 10 min</button>
    <button class="btn" id="">Cliente se Fue</button>

</div>