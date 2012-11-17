{include file="header.tpl"} 
{include file="menuArriba.tpl"}

<div class="container">
    <div class="row">
        {include file="menuEstudiante.tpl" inscritos=active} 
        <div class="span8">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Grupo</th>
                        <th>Hora inicio</th>
                        <th>Hora fin</th>
                        <th>Dia</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$grupos item=grupo}
                        <tr>
                            <td>{$grupo.nombre}</td>
                            <td>{$grupo.grupo}</td>
                            <td>{$grupo.horaInicio}</td>
                            <td>{$grupo.horaFin}</td>
                            <td>{$grupo.dia}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>

        </div>
    </div>

</div>
{include file="footer.tpl"}