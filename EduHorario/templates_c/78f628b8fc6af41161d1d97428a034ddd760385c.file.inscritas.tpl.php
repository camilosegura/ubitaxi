<?php /* Smarty version Smarty-3.1.7, created on 2012-02-07 02:25:26
         compiled from "./templates/inscritas.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1740399934f30c87d456db2-39223262%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78f628b8fc6af41161d1d97428a034ddd760385c' => 
    array (
      0 => './templates/inscritas.tpl',
      1 => 1328599518,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1740399934f30c87d456db2-39223262',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f30c87d4814b',
  'variables' => 
  array (
    'grupos' => 0,
    'grupo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f30c87d4814b')) {function content_4f30c87d4814b($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate ("menuArriba.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
    <div class="row">
        <?php echo $_smarty_tpl->getSubTemplate ("menuEstudiante.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('inscritos'=>'active'), 0);?>
 
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
                    <?php  $_smarty_tpl->tpl_vars['grupo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['grupo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['grupos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['grupo']->key => $_smarty_tpl->tpl_vars['grupo']->value){
$_smarty_tpl->tpl_vars['grupo']->_loop = true;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['grupo']->value['nombre'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['grupo']->value['grupo'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['grupo']->value['horaInicio'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['grupo']->value['horaFin'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['grupo']->value['dia'];?>
</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>