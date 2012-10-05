<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'modules/verificar.php';
include 'classes/EstudianteGrupo.php';
include 'modules/conexion.php';

$idcurso = isset ($_GET["grupo"]) ? $_GET["grupo"] : "";


if($idcurso == ""){
    

    header("Location: index.php?mod=logueado&inscribio=false");
    exit ();
}

$estGrupo = new EstudianteGrupo();

if(!$estGrupo->yaTieneCurso($idcurso)){
    $estGrupo->registreGrupo($idcurso);
    header("Location: index.php?mod=logueado&inscribio=true");
    exit ();
}else{
    header("Location: index.php?mod=logueado&inscribio=false");
    exit ();
}

?>
