<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CursoGrupo
 *
 * @author camilo
 */
class CursoGrupo {
    //put your code here
    
    
    function cursosDisponibles(){
        $cursos = array();
        $query = "SELECT cursoGrupo.*, curso.* FROM curso, cursoGrupo, horarioGrupo WHERE cupos > 0 AND idcurso = curso_idcurso AND idcursoGrupo = idhorarioGrupo";
        $result = mysql_query($query);
        while ($row = mysql_fetch_array($result)){
            $cursos[$row["idcursoGrupo"]] = "{$row["nombre"]} - {$row["grupo"]}";
        }
        
        return $cursos;
    }
    
}

?>
