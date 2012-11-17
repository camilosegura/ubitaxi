<?php
$this->pageTitle = Yii::app()->name . ' - ' . "Control";
$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true", CClientScript::POS_END);
//$cs->registerScriptFile(Yii::app()->theme->getBaseUrl() . '/js/geolocation.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/main.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/locator.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/control.js', CClientScript::POS_END);
?>
<div class="span10">
    <div id="main-control">
        <button class="btn" id="detalles">Detalles</button>
        <button class="btn" id="emergencia">Emergencia</button>
        <select name="estado" id="estado">
            <option value="0">Disponible</option>
            <option value="1">Ocupado</option>
            <option value="2">Almorzando</option>
            <option value="3">Varado</option>
            <option value="4">Descanso</option>
        </select>
        <button class="btn" id="salir">Salir</button>
        <span>Dirección</span>
        <span></span>
        <span>Celular:</span>
        <span></span>
        <button class="btn" id="posicion">Posición GPS</button>
        <button class="btn" id="navegacion">Navegación GPS</button>
        <textarea id="mensaje-text"></textarea>
        <button class="btn" id="mensaje">Enviar Mensaje</button>
        <button class="btn" id="demora">Demora 10 min</button>
        <button class="btn" id="sefue">Cliente se Fue</button>
        <button class="btn" id="iniciar">Iniciar Recorrido</button>
        <button class="btn" id="llegada">Finalizar Recorrido</button>
    </div>
    <div id="control-aceptar">
        <p>¿Desea aceptar este pedido pedido?</p>
        <p id="cliente-dir"></p>
        <p>
            <button type="button" class="btn btn-large btn-primary" id="pedido-aceptar">Aceptar</button>
            <!-- <button type="button" class="btn btn-large btn-danger" id="pedido-rechazar">Rechazar</button> -->
        </p>
    </div>
    <div id="testlayer" ></div>
</div>