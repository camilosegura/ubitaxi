<?php
/* @var $this PedidoController */
?>
<h1>Seguimiento del Pedido</h1>

<div class="row">
    <div class="row">
        <div class="span6">
            <dl>
                <dt>Número de pedido:</dt>
                <dd><?php echo $pedido['id']; ?></dd>            
            </dl>
            <button class="btn btn-danger">Cancelar</button>
        </div>
        <div class="span6">
            <dl>
                <dt>Estado:</dt>
                <dd><?php echo $pedido['estado']; ?></dd>
                <dt>Placa vehiculo:</dt>
                <dd><?php echo $pedido['placa']; ?></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <dl>
            <dt>Dirección recogida:</dt>
            <dd><?php echo $pedido['direccion_recogida']; ?></dd>
            <dt>Hora recogida:</dt>
            <dd><?php echo $pedido['hora_recogida']; ?></dd>
        </dl>
        <div class="accordion" id="accordion2">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                        Pasajeros
                    </a>
                </div>
                <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner">
                        <ul>
                            <li>
                                Pasajero 1 ...  -  Dirección 1
                            </li>
                        </ul>
                    </div>
                </div>
            </div>            
        </div>
        <div class="accordion" id="accordion3">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo">
                        Enviar mensaje al conductor
                    </a>
                </div>
                <div id="collapseTwo" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner">
                        <textarea></textarea>
                        <button>Enviar</button>
                    </div>
                </div>
            </div>            
        </div>
        <?php echo $this->renderPartial('/default/_mapa'); ?>
    </div>
</div>
