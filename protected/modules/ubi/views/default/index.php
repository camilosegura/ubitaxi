<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true", CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->getBaseUrl().'/js/geolocation.js', CClientScript::POS_END);

?>

<div class="span5">
	<div id="map_canvas"></div>
</div>
<div class="span4">
	<form action="" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="nombre">Nombre</label>
			<div class="controls">
				<input required type="text" id="nombre"
					placeholder="Ingrese su Nombre">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="celular">Celular</label>
			<div class="controls">
				<input required type="text" id="celular"
					placeholder="Ingrese su Celular">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="direccion">Dirección</label>
			<div class="controls">
				<input required type="text" id="direccion"
					placeholder="Ingrese su Dirección">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">E-mail</label>
			<div class="controls">
				<input required type="email" id="email"
					placeholder="Ingrese su email">
			</div>

		</div>
		<div class="control-group" id="home-butons">
			<button type="submit" id="solicitar" class="btn">Solicitar Taxi</button>
			<button type="submit" id="cancelar" class="btn">Cancelar</button>
		</div>

	</form>
</div>
