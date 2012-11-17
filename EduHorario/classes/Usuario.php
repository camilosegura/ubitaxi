<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuario {

    function esUsuario($usuario, $clave) {

        $esUsuario = false;
        $query = "SELECT * FROM usuario WHERE usuario='$usuario' AND clave='$clave'";
        $result = mysql_query($query);
        if(mysql_num_rows($result) == 1){
            $esUsuario = true;
            $usuarioLog = mysql_fetch_array($result);
            
            $_SESSION["usuario"] = $usuarioLog["usuario"];
            $_SESSION["idusuario"] = $usuarioLog["idusuario"];
            $_SESSION["primerNombre"] = $usuarioLog["primerNombre"];
            $_SESSION["segundoNombre"] = $usuarioLog["segundoNombre"];
            $_SESSION["primerApellido"] = $usuarioLog["primerApellido"];
            $_SESSION["segundoApellido"] = $usuarioLog["segundoApellido"];
            $_SESSION["vinculacion_idvinculacion"] = $usuarioLog["vinculacion_idvinculacion"];
            
            
        }
        
        return $esUsuario;
    }

}

?>
