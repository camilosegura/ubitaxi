<div data-role="page" id="addresses" data-theme="e"> 
    <div data-role="header" data-position="fixed">
        <a href="#newAddresses" data-theme="e" data-role="button" data-icon="plus">Nueva</a>
        <h1>Mi Taxi</h1>
        <a href="#confirmarDir" id="continuarDir" data-theme="e" data-role="button" data-icon="arrow-r">Continuar</a>
    </div> 
    <div data-role="content">
        <h2>Direcciones registradas</h2>
        <fieldset data-role="controlgroup" data-mini="true">
            <?php foreach ($direccion as $key => $dir) { ?>
                <input type="radio" name="direccionList" id="direccionList<?php echo $key; ?>" value="<?php echo $dir->id; ?>" />
                <label for="direccionList<?php echo $key; ?>"><?php echo $dir->direccion; ?></label>
            <?php } ?>
        </fieldset>
        <a href="#menuLogged" data-icon="gear" data-transition="slide" data-theme="a" class="open_menu_log" data-role="button">Menú</a>			
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
        <a href="#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button">Menú</a>
    </div> 
</div>
<div data-role="page" id="newAddresses" data-theme="e"> 
    <div data-role="header">
        <h1>Mi Taxi</h1>
        <a href="#cantidad" data-icon="arrow-r" data-theme="e" id="contNewAdd" class="ui-btn-right">Continuar</a>
    </div> 
    <div data-role="content">
        <div id="map_canvas" style="width: 100%; height: 100%"></div>
        <a href="#menuLogged" data-icon="gear" data-transition="slide" data-theme="a" class="open_menu_log" data-role="button">Menú</a>
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
            <select name="cant" id="cantidadAutos" data-native-menu="false">
                <option>Seleccione una cantidad</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            <input type="hidden" name="idDir" id="idDir" value="">            
            <button type="submit" data-theme="e" name="submit" value="submit-value">Solicitar</button>
        </form>
        <a href="#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button">Menú</a>
    </div> 
</div>
<div data-role="page" id="confirPedido" data-theme="e"> 
    <div data-role="header">
        <a href="/ubi/usuario/logged.html" data-icon="home" data-theme="e" data-ajax='false'>Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <div id="pedidoRsp"></div>
        <a href="#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button">Menú</a>
    </div>
    <div data-role="popup" id="popupConfirmarCorreo" data-theme="a" class="ui-corner-all">
        <div style="padding: 10px 20px;">
            <h3>¿Desea que se envíe la información de su pedido a su correo?</h3>
            <label for="un" class="ui-hidden-accessible">Clave:</label>             
            <a href="#" data-role="button" data-theme="b" data-rel="back" id="cancelEmail">Cancelar</a>
            <a href="#" data-role="button" data-theme="b" data-rel="back" id="enviarEmail">Enviar</a>            
        </div>

    </div>
</div>
<div data-role="page" id="menuLogged" data-theme="e"> 
    <div data-role="header">
        <a href="#addresses" data-icon="home" data-theme="e">Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <ul data-role="listview">
            <li><a href="#addressesEdit">Direcciones</a></li>
            <li><a href="#historialLogged">Historial</a></li>
            <li><a href="#activosLogged" data-ajax="false">Pedidos Activos</a></li>
            <li><a href="#">Mi Perfil</a></li>
            <li><a href="/user/logout.html" data-ajax='false'>Salir</a></li>            
        </ul>
    </div> 
</div>
<div data-role="page" id="addressesEdit" data-theme="e"> 
    <div data-role="header">
        <a href="#addresses" data-icon="home" data-theme="e">Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <div id="activasList"></div>
        <a href="#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button">Menú</a>
    </div> 
</div>
<div data-role="page" id="historialLogged" data-theme="e"> 
    <div data-role="header" data-position="fixed">
        <a href="#addresses" data-icon="home" data-theme="e">Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <div data-role="collapsible-set" data-content-theme="d" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">

            <?php
            rsort($historial);
            foreach ($historial as $key => $direcciones) {
                ?>
                <div data-role="collapsible" id="activeDir-' + value.id + '">
                    <h3><?php echo $direcciones->direccion_origen; ?> <?php echo $direcciones->finalizado->direccion_destino; ?></h3>
                    <div>                
                        <a href="#" class="eliminarHistorial" data-pedido="<?php echo $direcciones->id; ?>" data-role="button" data-icon="delete" data-theme="a" data-inline="true">Eliminar</a>
                    </div>
                </div>               

            <?php } ?>
            </ul>
        </div>
        <a href="#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button">Menú</a>
    </div> 
</div>
<div data-role="page" id="activosLogged" data-theme="e"> 
    <div data-role="header" data-position="fixed">
        <a href="#addresses" data-icon="home" data-theme="e">Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <div id="activosList"></div>
        <a href="#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button">Menú</a>
    </div> 
</div>