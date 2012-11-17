{include file="header.tpl" title=foo}
<div class="container">

    <div class="row">
        <div class="span8">
            <h3>Horarios de clase</h3>
            <p>
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
            </p>
        </div>
        <div class="span4">
            {if $error}
                <div class="alert alert-error">
                    <a class="close">x</a>
                    <strong>Error: </strong>
                    El nombre de usuario o clave estan equivocados.
                </div>
            {/if}
            <form action="" method="POST" class="well">
                <label>Usuario</label>
                <input type="text" class="span3" placeholder="Ingrese el usuario..." name="usuario">
                <label>Clave</label>
                <input type="password" class="span3" placeholder="Ingrese su clave..." name="clave">
                <button type="submit" class="btn">Ingresar</button>
            </form>
        </div>
    </div>
</div>

{include file="footer.tpl"}