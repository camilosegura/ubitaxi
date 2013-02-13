<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style type="text/css">
    .alert{
        padding: 8px 0;
    }
    .alert div{
        margin-left: 14px;
    }
</style>
<div class="row">
    <h1 class="span12">Peticiones</h1>
    <?php foreach ($model as $key => $peticion) { ?>
        <div class="alert alert-info span12">
            <div>
                <p><strong><?php echo $peticion->empresa->nombre; ?></strong></p>            
                <p><strong><?php echo $peticion->hora_empresa; ?></strong></p>            
                <a href="<?php echo $this->createUrl('/taxisPrivados/peticion/editar', array('id' => $peticion->id)); ?>" class="btn btn-primary">Editar</a>
            </div>
        </div>

    <?php } ?>

</div>