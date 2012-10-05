<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'modules/verificar.php';
include 'libs/Smarty.class.php';
include 'classes/CursoGrupo.php';
include 'modules/conexion.php';

$inscribio = isset ($_GET["inscribio"]) ? $_GET["inscribio"] : "";
$menu = "";
$contenido = "";

$smarty = new Smarty();

if ($_SESSION["vinculacion_idvinculacion"] == "1") {
    $menu = "menuAdministrador.tpl";
    $contenido = "logueadoAdministrador.tpl";            
} else if ($_SESSION["vinculacion_idvinculacion"] == "2") {
    $menu = "menuAdministrativo.tpl";
    $contenido = "logueadoAdministrativo.tpl";
} else if ($_SESSION["vinculacion_idvinculacion"] == "3") {
    $menu = "menuEstudiante.tpl";
    $contenido = "logueadoEstudiante.tpl";
    $cursoGrupos = new CursoGrupo();
    $smarty->assign("grupos", $cursoGrupos->cursosDisponibles());   
    $smarty->assign("inscribio", $inscribio);
}


$smarty->assign("menu", $menu);
$smarty->assign("contenido", $contenido);
$smarty->display('logueado.tpl');
?>
