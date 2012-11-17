<?php /* Smarty version Smarty-3.1.7, created on 2012-02-06 02:06:27
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19880819374f2f3b344ee684-21518251%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1328511979,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19880819374f2f3b344ee684-21518251',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2f3b345e291',
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2f3b345e291')) {function content_4f2f3b345e291($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<div class="container">

    <div class="row">
        <div class="span8">
            <h3>Horarios de clase</h3>
            <p>
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
            </p>
        </div>
        <div class="span4">
            <?php if ($_smarty_tpl->tpl_vars['error']->value){?>
                <div class="alert alert-error">
                    <a class="close">x</a>
                    <strong>Error: </strong>
                    El nombre de usuario o clave estan equivocados.
                </div>
            <?php }?>
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

<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>