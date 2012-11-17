<div data-role="page" id="addresses" data-theme="e"> 
    <div data-role="header" data-position="fixed">
        <a href="#newAddresses" data-theme="e" data-role="button" data-icon="plus">Nueva Dirección</a>
        <h1>Mi Taxi</h1>
        <a href="#confirmarDir" id="continuarDir" data-theme="e" data-role="button" data-icon="arrow-r">Continuar</a>
    </div> 
    <div data-role="content">
        <fieldset data-role="controlgroup" data-mini="true">
            <?php foreach ($direccion as $key => $dir) { ?>
                <input type="radio" name="direccionList" id="direccionList<?php echo $key; ?>" value="<?php echo $dir->id; ?>" />
                <label for="direccionList<?php echo $key; ?>"><?php echo $dir->direccion; ?></label>
            <?php } ?>
        </fieldset>
    </div> 
</div>
<div data-role="page" id="confirmarDir" data-theme="e"> 
    <div data-role="header">
        <a href="#addresses" data-icon="arrow-l" data-theme="e" >Corregir</a>
        <h1>Mi Taxi</h1>
        <a href="#cantidad" data-icon="arrow-r" data-theme="e" >Continuar</a>
    </div> 
    <div data-role="content">
        <img id="map_canvas_conf" src=""  style="width: 100%; height: 100%">
    </div> 
</div>
<div data-role="page" id="newAddresses" data-theme="e"> 
    <div data-role="header">
        <h1>Mi Taxi</h1>
        <a href="#cantidad" data-icon="arrow-r" data-theme="e" id="contNewAdd" class="ui-btn-right">Continuar</a>
    </div> 
    <div data-role="content">
        <div id="map_canvas" style="width: 100%; height: 100%"></div>
    </div> 
</div>
<div data-role="page" id="cantidad" data-theme="e"> 
    <div data-role="header">
        <a href="#addresses" data-icon="delete" data-theme="e" >Cancelar</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <form action="#" method="post" id="cantidadPedir">
            <label for="cantidadAutos"> Cantidad de taxis</label>
            <select name="cant" id="cantidadAutos" data-role="none">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            <input type="hidden" name="idDir" id="idDir" value="">            
            <button type="submit" data-theme="e" name="submit" value="submit-value">Solicitar</button>
        </form>
    </div> 
</div>
<div data-role="page" id="confirPedido" data-theme="e"> 
    <div data-role="header">
        <a href="/ubi/usuario/logged.html" data-icon="home" data-theme="e" data-ajax='false'>Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <p id="pedidoRsp"></p>
    </div> 
</div>