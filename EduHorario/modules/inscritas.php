<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'modules/verificar.php';
include 'libs/Smarty.class.php';
include 'classes/EstudianteGrupo.php';
include 'modules/conexion.php';

$estGrupo = new EstudianteGrupo();

$grupos = $estGrupo->obtenerGrupos();

$smarty = new Smarty();
$smarty->assign("grupos", $grupos);
$smarty->display("inscritas.tpl");


?>
