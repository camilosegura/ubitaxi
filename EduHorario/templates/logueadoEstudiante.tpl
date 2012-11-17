<div class="span8">
    {if $inscribio eq 'false'}
        <div class="alert alert-error">
            <a class="close">X</a>
            <p>El curso no se pudo inscribir.</p>
        </div>
    {elseif $inscribio eq 'true'}
        <div class="alert alert-success">
        <a class="close">X</a>
        <p>El curso se ha inscrito correctamente.</p>
        </div>

    {/if}
    <form class="well" action="index.php" method="GET">
        <div class="control-group">
            <label class="control-label" for="select01">Select list</label>
            <div class="controls">
                <select id="grupo" name="grupo">
                    <option value="">Seleccione un grupo</option>
                    {foreach from=$grupos key=idGrupo item=grupo}
                        <option value="{$idGrupo}">{$grupo}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <input type="hidden" name="mod" value="inscribirGrupo">                
        <button class="btn" type="submit" name="inscribirG">Registrar</button>        
    </form>

</div>