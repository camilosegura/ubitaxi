<?php /* Smarty version Smarty-3.1.7, created on 2012-02-07 01:49:00
         compiled from "./templates/menuEstudiante.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6898248664f2fcb5658d430-06847457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6972f4dfb82c04ee4ce8823ad1409121cec8833b' => 
    array (
      0 => './templates/menuEstudiante.tpl',
      1 => 1328597296,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6898248664f2fcb5658d430-06847457',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2fcb56591b0',
  'variables' => 
  array (
    'logueado' => 0,
    'inscritos' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2fcb56591b0')) {function content_4f2fcb56591b0($_smarty_tpl) {?><ul class="nav nav-pills nav-stacked span4">
    <li class="<?php echo $_smarty_tpl->tpl_vars['logueado']->value;?>
"><a href="index.php?mod=logueado">Cursos Disponibles</a></li>
    <li class="<?php echo $_smarty_tpl->tpl_vars['inscritos']->value;?>
"><a href="index.php?mod=inscritas">Cursos Inscritos</a></li>    
</ul><?php }} ?>