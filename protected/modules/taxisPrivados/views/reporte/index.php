<?php
/* @var $this ReporteController */
$cs = Yii::app()->getClientScript();
$cs->registerScript('script', <<<JS
   $('.fecha').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true
    });
    $('#guardarReporte').click(function(){
        var url = '/taxisPrivados/reporte/actualizar';        
        var data = {pedido:{}};
        
        var trs = $('#reporteGeneral tbody tr');
        $.each($(trs), function(index, tr){      
            var valor = {};
            valor['valorEmpresa'] = $(tr).find('#valorEmpresa-'+$(tr).data('idPedido')).val();            
            valor['valorVehiculo'] = $(tr).find('.valorVehiculo').val();
            valor['ruta'] = $(tr).find('.ruta').val();            
            data['pedido'][$(tr).data('idPedido')] = valor;            
        });
        $.getJSON(url, data, function(rsp){});
    });
    
JS
        , CClientScript::POS_READY);
//$cs->registerCssFile();
?>
<style type="text/css">
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/' . Yii::app()->theme->getBaseUrl() . '/css/bootstrap-responsive.min.css'; ?>  
    .inputReporte{
        width: 85px;
    }
    #reporteGeneral span{
        display: block;
    }
    .row{
        margin-bottom: 20px;
    }
</style>
<div class="row">
    <h1>Reporte general</h1>
    <div class="">
        <form method="post">
            <div class="span6">
                <label>Empresa</label>
                <select name="empresa" id="empresa">
                    <option value="">(Todas)</option>
                    <?php foreach ($empresas as $key => $empresa) { ?>
                        <option value="<?php echo $key; ?>" <?php echo ($selected['empresa'] == $key) ? 'selected="selected"' : ''; ?>><?php echo $empresa; ?></option>
                    <?php } ?>
                </select>
                <label>Vehiculo</label>
                <select name="vehiculo" id="vehiculo">
                    <option value="">(Todos)</option>
                    <?php foreach ($vehiculos as $key => $vehiculo) { ?>
                        <option value="<?php echo $vehiculo->id; ?>" <?php echo ($selected['vehiculo'] == $vehiculo->id) ? 'selected="selected"' : ''; ?>><?php echo $vehiculo->placa; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="span6">
                <label>Fecha inicio</label>
                <input type="text" name="fechaInicio" id="fechaInicio" class="fecha" value="<?php echo ($selected['fechaInicio'] == '') ? date("Y-m-d") : $selected['fechaInicio']; ?>">
                <label>Fecha fin</label>
                <input type="text" name="fechaFin" id="fechaFin" class="fecha" value="<?php echo ($selected['fechaFin'] == '') ? date("Y-m-d") : $selected['fechaFin']; ?>">
            </div>
            <div class="span12">
                <button type="submit" class="btn">Generar</button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="span12">
        <table class="table table-bordered table-striped table-hover" id="reporteGeneral">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Planilla</th>                    
                    <th>Nombre de funcionarios</th>
                    <th>#</th>
                    <th>Empresa</th>
                    <th>Valor empresa</th>
                    <th>Ruta</th>
                    <th>Vehiculo</th>
                    <th>Valor vehiculo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($pedidos)) {
                    foreach ($pedidos as $key => $pedido) {
                        ?>
                        <tr data-id-pedido="<?php echo $key; ?>">
                            <td>
                                <?php echo $pedido['fecha']; ?>
                            </td>
                            <td>
                                <?php echo $key; ?>
                            </td>
                            <td>
                                <?php
                                $i = 0;
                                foreach ($pedido['pasajeros'] as $keyP => $pasajero) {
                                    ?>
                                    <span>
                                        <?php
                                        echo $pasajero;
                                        $i++;
                                        ?>
                                    </span>   
                                <?php }; ?>
                            </td>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $pedido['empresa']; ?>
                            </td>
                            <td>
                                <input type="text" class="valorEmpresa inputReporte" name="valorEmpresa-<?php echo $key; ?>" id="valorEmpresa-<?php echo $key; ?>" value="<?php echo $pedido['valorEmpresa']; ?>" >
                            </td>
                            <td>
                                <select class="ruta inputReporte">
                                    <option <?php echo ($pedido["ruta"] == "Normal") ? 'selected="selected"' : ''; ?> value="Normal">Normal</option>
                                    <option <?php echo ($pedido["ruta"] == "Este A.") ? 'selected="selected"' : ''; ?> value="Este A.">Este A.</option>
                                    <option <?php echo ($pedido["ruta"] == "Este") ? 'selected="selected"' : ''; ?> value="Este">Este</option>
                                    <option <?php echo ($pedido["ruta"] == "Soacha") ? 'selected="selected"' : ''; ?> value="Soacha">Soacha</option>
                                </select>
                            </td>
                            <td>
                                <?php echo $pedido['vehiculo']; ?>
                            </td>
                            <td>
                                <input type="text" class="valorVehiculo inputReporte" name="valorVehiculo-<?php echo $key; ?>" id="valorVehiculo-<?php echo $key; ?>" value="<?php echo $pedido['valorVehiculo']; ?>" >
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
        <button class="btn btn-primary" id="guardarReporte">Guardar</button>
    </div>
</div>
