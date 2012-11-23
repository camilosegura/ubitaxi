<div data-role="page" id="controlPedido" data-theme="e"> 
    <div data-role="header" data-position="fixed">
        <a href="logged.html#addresses" data-icon="home" data-theme="e" data-ajax="false">Inicio</a>
        <h1>Mi Taxi</h1>        
    </div> 
    <div data-role="content">
        <div class="ui-grid-a">
            <div class="ui-block-a">Estado</div>
            <div class="ui-block-b"><button type="button"> Cancelar </button></div>	   
        </div>
        <div class="ui-grid-solo">
            <div class="ui-block-a">
                <div data-role="collapsible" data-content-theme="d">
                    <h3>Enviar Mensaje</h3>
                    <p>
                    <form>
                        <textarea name="textarea" id="textarea-a" placeholder="Escriba su mensaje" required="required">       
                        </textarea>
                        <button type="submit" data-theme="e"> Enviar </button>
                        </form>
                    </p>
                </div></div>
        </div>
        <a href="logged.html#menuLogged" data-icon="gear" data-theme="a" data-transition="slide" class="open_menu_log" data-role="button" data-ajax="false">Menú</a>
    </div> 
</div>