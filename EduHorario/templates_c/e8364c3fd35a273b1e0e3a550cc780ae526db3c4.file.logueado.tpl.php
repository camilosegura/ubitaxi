<?php /* Smarty version Smarty-3.1.7, created on 2012-02-07 01:49:38
         compiled from "./templates/logueado.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16800516534f2f80b28f3720-29750674%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8364c3fd35a273b1e0e3a550cc780ae526db3c4' => 
    array (
      0 => './templates/logueado.tpl',
      1 => 1328597374,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16800516534f2f80b28f3720-29750674',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2f80b294afc',
  'variables' => 
  array (
    'menu' => 0,
    'contenido' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2f80b294afc')) {function content_4f2f80b294afc($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate ("menuArriba.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
    <div class="row">
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['menu']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('logueado'=>'active'), 0);?>
 
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['contenido']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 
    </div>

</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>