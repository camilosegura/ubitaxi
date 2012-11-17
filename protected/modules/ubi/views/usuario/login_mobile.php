<div data-role="page" id="login" data-theme="e"> 
    <div data-role="header"><h1>Mi Taxi</h1></div> 
    <div data-role="content">
        <form id="formPedido" data-ajax="false" method="POST">
            <div style="padding:10px 20px;">
                <h3 class="ui-title">Ingrese sus datos</h3>
                <label for="username" class="ui-hidden-accessible">Usuario o Email:</label>
                <input type="text" name="UserLogin[username]" id="username" value="" placeholder="Usuario o Email" data-theme="e" required="required" />

                <label for="password" class="ui-hidden-accessible">Celular:</label>
                <input type="password" name="UserLogin[password]" id="password" value="" placeholder="Contraseña" data-theme="e" required="required" />
                              
                <input id="rememberMe" type="hidden" value="0" name="UserLogin[rememberMe]">
                <input name="UserLogin[rememberMe]" id="UserLogin_rememberMe" value="1" type="checkbox">
                <label for="UserLogin_rememberMe">Recordarme</label>	
                                
                <button type="submit" data-theme="e" value="" name="ingresar" id="ingresar">Ingresar</button>
            </div>
        </form>
    </div> 

</div>