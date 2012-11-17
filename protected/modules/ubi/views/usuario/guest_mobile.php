<div data-role="page" id="guest">
    <div data-role="header">
        <a href="#popupFormPedido" data-theme="e" data-rel="popup" data-icon="arrow-d" id="solicitar">Solicitar</a>
        <h1>Mi Taxi</h1>
        <a href="#popupMenuPasajero" data-rel="popup" data-icon="gear" class="ui-btn-right" data-theme="b">Menú</a>
        <div data-transition="pop" data-role="popup" id="popupFormPedido" data-theme="a" class="ui-corner-all">
            <form id="formPedido">
                <div style="padding:10px 20px;">
                    <h3 class="ui-title">Ingrese sus datos</h3>
                    <label for="nombre" class="ui-hidden-accessible">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" value="" placeholder="Nombre y Apellido" data-theme="a" required="required" />

                    <label for="celeular" class="ui-hidden-accessible">Celular:</label>
                    <input type="tel" name="celular" id="celular" value="" placeholder="Celular" data-theme="a" required="required" />
                    
                    <label for="direccion" class="ui-hidden-accessible">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" value="" placeholder="Dirección" data-theme="a" required="required" />

                    <label for="email" class="ui-hidden-accessible">Email:</label>
                    <input type="email" name="email" id="email" value="" placeholder="Email" data-theme="a" required="required" />
                    
                    <input type="hidden" name="latitud" id="latitud" value="" />
                    <input type="hidden" name="longitud" id="longitud" value="" />
                    <button type="submit" data-theme="e" value="" name="enviarSolicitud" id="enviarSolicitud">Enviar</button>
                </div>
            </form>
        </div>
        <div data-role="popup" id="popupMenuPasajero" data-theme="a">
            <ul data-role="listview" data-inset="true" style="min-width:210px;padding:10px 20px;" data-theme="b">                
                <li><a href="login.html">Ingresar</a></li>
                <li><a href="registration.html" data-ajax="false">Registrarse</a></li>                
                <li><a href="#popupInstruction" data-rel="popup" data-position-to="window">Ayuda</a></li>
            </ul>
        </div>        
    </div>
    <div data-role="content">
        <div id="map_canvas" style="width: 100%; height: 100%"></div>
        <div data-role="popup" id="popupInstruction" data-overlay-theme="a" style="max-width:600px;" class="ui-corner-all ui-content">
            <div data-role="header" data-theme="a" class="ui-corner-top">
                <h1>Instrucciones</h1>
            </div>
            <div data-role="content" class="ui-corner-bottom ui-content" style="padding: 10px 5px;">
                <h3 class="ui-title">Para pedir un taxi:</h3>
                <ol data-role="listview" data-inset="true">                    
                    <li>
                        Mueva el globo o de click en su ubicación
                    </li>
                    <li>
                        Haga click en "Solicitar"
                    </li>
                    <li>
                        Llene TODO el formulario
                    </li>
                    <li>
                        "Enviar"                        
                    </li>
                </ol>
                <a href="#" data-theme="e" data-role="button" id="submitIns" data-rel="back">Cerrar</a>
            </div>
        </div>
    </div>
</div>