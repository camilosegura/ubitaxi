<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstudianteGrupo
 *
 * @author camilo
 */
class EstudianteGrupo {
    //put your code here
    function yaTieneCurso($idcurso){
        $tiene = false;
        $query = "SELECT * FROM estudianteGrupo, cursoGrupo WHERE estudianteGrupo.usuario_idusuario = {$_SESSION["idusuario"]} AND cursoGrupo_idcursoGrupo = idcursoGrupo AND cursoGrupo_idcursoGrupo = $idcurso";
        $result = mysql_query($query);
        if(mysql_num_rows($result) > 0){
            $tiene = true;
        }
        
        return $tiene;
    }
    
    function registreGrupo($idcurso){
        $query = "INSERT INTO estudianteGrupo (usuario_idusuario, usuario_vinculacion_idvinculacion, cursoGrupo_idcursoGrupo) VALUES ('{$_SESSION["idusuario"]}', '{$_SESSION["vinculacion_idvinculacion"]}', '$idcurso')";
        mysql_query($query);
    }
    
    function obtenerGrupos(){
        
        $grupos = array();
        
        $query = "SELECT cursoGrupo.*, curso.*, diasSemana.*, horario.* FROM 
            diasSemana, horario, horarioGrupo, cursoGrupo, curso, estudianteGrupo WHERE
             iddiasSemana = diasSemana_iddiasSemana AND idhorario = horario_idhorario 
             AND idcursoGrupo = horarioGrupo.cursoGrupo_idcursoGrupo AND idcurso = curso_idcurso 
             AND idcursoGrupo = estudianteGrupo.cursoGrupo_idcursoGrupo AND estudianteGrupo.usuario_idusuario = {$_SESSION["idusuario"]} 
             ORDER BY curso.nombre ASC";
             
         $result = mysql_query($query);
         while ($row = mysql_fetch_array($result)){
             $grupos[] = $row;
         }
         
         return $grupos;
    }
}

?>
