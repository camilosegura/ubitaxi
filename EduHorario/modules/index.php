<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'classes/Usuario.php';
include 'modules/conexion.php';
include 'libs/Smarty.class.php';

$usuario = isset ($_POST["usuario"]) ? $_POST["usuario"] : "";
$clave = isset ($_POST["clave"]) ? $_POST["clave"] : "";
$error = false;
$miUsuario = new Usuario();

if($miUsuario->esUsuario($usuario, $clave) || isset ($_SESSION["usuario"])){
    header("Location: index.php?mod=logueado");
    exit ();
}

if(isset ($_POST["usuario"])){
    $error = true;
}

$smarty = new Smarty();
$smarty->assign("error", $error);
$smarty->display('index.tpl');

?>
