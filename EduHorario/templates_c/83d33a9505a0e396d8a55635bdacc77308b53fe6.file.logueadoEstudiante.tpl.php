<?php /* Smarty version Smarty-3.1.7, created on 2012-02-07 02:46:01
         compiled from "./templates/logueadoEstudiante.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10816466694f2fcb56597837-56778967%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83d33a9505a0e396d8a55635bdacc77308b53fe6' => 
    array (
      0 => './templates/logueadoEstudiante.tpl',
      1 => 1328600759,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10816466694f2fcb56597837-56778967',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2fcb565cab4',
  'variables' => 
  array (
    'inscribio' => 0,
    'grupos' => 0,
    'idGrupo' => 0,
    'grupo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2fcb565cab4')) {function content_4f2fcb565cab4($_smarty_tpl) {?><div class="span8">
    <?php if ($_smarty_tpl->tpl_vars['inscribio']->value=='false'){?>
        <div class="alert alert-error">
            <a class="close">X</a>
            <p>El curso no se pudo inscribir.</p>
        </div>
    <?php }elseif($_smarty_tpl->tpl_vars['inscribio']->value=='true'){?>
        <div class="alert alert-success">
        <a class="close">X</a>
        <p>El curso se ha inscrito correctamente.</p>
        </div>

    <?php }?>
    <form class="well" action="index.php" method="GET">
        <div class="control-group">
            <label class="control-label" for="select01">Select list</label>
            <div class="controls">
                <select id="grupo" name="grupo">
                    <option value="">Seleccione un grupo</option>
                    <?php  $_smarty_tpl->tpl_vars['grupo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['grupo']->_loop = false;
 $_smarty_tpl->tpl_vars['idGrupo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['grupos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['grupo']->key => $_smarty_tpl->tpl_vars['grupo']->value){
$_smarty_tpl->tpl_vars['grupo']->_loop = true;
 $_smarty_tpl->tpl_vars['idGrupo']->value = $_smarty_tpl->tpl_vars['grupo']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['idGrupo']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['grupo']->value;?>
</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="mod" value="inscribirGrupo">                
        <button class="btn" type="submit" name="inscribirG">Registrar</button>        
    </form>

</div><?php }} ?>