<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(!isset($_POST['option']) || empty($_POST['option'])){
    echo "error - No option :(";
    exit();
}

switch($_POST['option']){
    case "select_provincias":
        if(isset($_POST['id_pais']) && !empty($_POST["id_pais"])){
            $provincias = getProvincias($mysqli, $_POST['id_pais']);
            foreach($provincias as $id=>$row){
                //utf8_encode para que json_encode pueda trabajar con ñ o acentos
                $provincias_2['options'][]=array_map('utf8_encode', $row);
            } 
            print(json_encode($provincias_2));
        }
    break;
    
    case "select_filiales":
        //if(isset($_POST['cod_curso']) && !empty($_POST["cod_curso"])){
            $filiales = getFiliales($mysqli, $_POST['id_provincia']);
            foreach($filiales as $id=>$row){
                //utf8_encode para que json_encode pueda trabajar con ñ o acentos
                $filiales_2['options'][]=array_map('utf8_encode', $row);
            } 
            print(json_encode($filiales_2));
        //}
    break;
    
    case "select_filiales_grupo":
        //if(isset($_POST['cod_curso']) && !empty($_POST["cod_curso"])){
            $provincias = getProvincias($mysqli, $_POST['id_pais']);
            foreach ($provincias as $id_p=>$data_p){
                $filiales = getFiliales($mysqli, $data_p['id']);
                foreach($filiales as $id=>$row){
                    //utf8_encode para que json_encode pueda trabajar con ñ o acentos
                    $filiales_2[$data_p['nombre']][]=array_map('utf8_encode', $row);
                } 
            }
            print(json_encode($filiales_2));
        //}
    break;
    
    case "get_datos_curso":
        $datos_curso = getDatosCurso($mysqli, $_POST['cod_curso'], $_POST['id_idioma'], $_POST['id_filial']);
        if(is_array($datos_curso)){
            array_walk_recursive($datos_curso,'myFunc');
        }
        
        print(json_encode($datos_curso));
        
    break;
    
    case "cambiar_estado_noticia":
        $retorno = array();
        if(isset($_POST['id_noticia'])){
            $res_sel = $mysqli->query("SELECT estado FROM novedades WHERE id={$_POST['id_noticia']}");
            if($res_sel->num_rows > 0){
                $estado = $res_sel->fetch_assoc();
                if($estado['estado'] == 1){
                    $nuevo_estado = 0;
                }else{
                    $nuevo_estado = 1;
                }
                $query = "UPDATE novedades SET estado={$nuevo_estado} WHERE id={$_POST['id_noticia']}";
                $resultado = $mysqli->query($query);
                $retorno['result'] = 'ok';
            }else{
                $retorno['result'] = 'fail';
            }
        }else{
            $retorno['result'] = 'fail';
        }
        print(json_encode($retorno));
    break;
    
    case "eliminar_noticia":
        $retorno = array();
        if(isset($_POST['id_noticia'])){
            $res_sel = $mysqli->query("SELECT id, imagen FROM novedades WHERE id={$_POST['id_noticia']}");
            if($res_sel->num_rows > 0){
                $novedad = $res_sel->fetch_assoc();
                unlink('../images/novedades/'.$novedad['imagen']);
                $resultado = $mysqli->query("DELETE FROM novedades WHERE id={$_POST['id_noticia']}");
                $retorno['result'] = 'ok';
            }else{
                $retorno['result'] = 'fail';
            }
        }else{
            $retorno['result'] = 'fail';
        }
        print(json_encode($retorno));
    break;
    
    case "cambiar_estado_curso":
        $retorno = array();
        if(isset($_POST['cod_curso']) && isset($_POST['id_idioma']) && isset($_POST['id_filial']) && isset($_POST['estado'])){
            $query = "UPDATE curso_filial_idioma SET estado={$_POST['estado']} WHERE cod_curso={$_POST['cod_curso']} AND id_filial={$_POST['id_filial']} AND id_idioma={$_POST['id_idioma']}";
            $resultado = $mysqli->query($query);
            if($resultado){
                $retorno['result'] = 'ok';
            }else{
                $retorno['result'] = 'Ocurrio un error al modificar el estado';
            }
        }else{
            $retorno['result'] = 'Faltan variables';
        }
        print(json_encode($retorno));
    break;
    
    case "agregar_tipo_curso":
        $retorno = array();
        $resultado = $mysqli->query("INSERT INTO tipos SET nombre_es='{$_POST['nombre_es']}', nombre_in='{$_POST['nombre_in']}', nombre_pt='{$_POST['nombre_pt']}', padre='{$_POST['tipo_curso']}'");
        if($resultado){
            $retorno['result'] = 'ok';
        }else{
            $retorno['result'] = 'Ocurrio un error al modificar el estado';
        }
        print(json_encode($retorno));
    break;
    
    case "editar_tipo_curso":
        $retorno = array();
        $nombre_es = $_POST['nombre_es'];
        $nombre_in = $_POST['nombre_in'];
        $nombre_pt = $_POST['nombre_pt'];
        $tipo_curso = $_POST['tipo_curso'];
        $resultado = $mysqli->query("UPDATE tipos SET nombre_es='{$nombre_es}', nombre_in='{$nombre_in}', nombre_pt='{$nombre_pt}', padre='{$tipo_curso}' WHERE id={$_POST['id_tipo']}");
        if($resultado){
            $retorno['result'] = 'ok';
        }else{
            $retorno['result'] = 'Ocurrio un error al modificar el estado';
        }
        print(json_encode($retorno));
    break;
    
    case "eliminar_tipo_curso":
        $retorno = array();
        if(isset($_POST['id_tipo'])){
            $res_sel = $mysqli->query("SELECT id FROM tipos WHERE id={$_POST['id_tipo']}");
            if($res_sel->num_rows > 0){
                $cursos_hijos = getTiposCursos($mysqli, $_POST['id_tipo']);
                foreach($cursos_hijos as $i=>$d){
                    $mysqli->query("DELETE FROM tipos WHERE id={$d['id']}");
                }
                $mysqli->query("DELETE FROM tipos WHERE id={$_POST['id_tipo']}");
                $retorno['result'] = 'ok';
            }else{
                $retorno['result'] = 'fail';
            }
        }else{
            $retorno['result'] = 'fail';
        }
        print(json_encode($retorno));
    break;
    
    case "asignar_curso_corto":
        $cod_curso = $_POST['cod_curso'];
        $tipos = array();
        $retorno = array();
        
        if(isset($_POST['arrayCheck'])) $tipos = $_POST['arrayCheck'];
        
        if(isset($cod_curso)){
            $mysqli->query("UPDATE curso_tipo SET estado=0 WHERE cod_curso='{$cod_curso}'");
            
            foreach($tipos as $id=>$data){
                $query = "SELECT id FROM curso_tipo WHERE cod_curso='{$cod_curso}' AND id_tipo='{$data}'";
                $resultado = $mysqli->query($query);
                if($resultado->num_rows == 0){
                    $mysqli->query("INSERT INTO curso_tipo SET cod_curso='{$cod_curso}', id_tipo='{$data}', estado=1");
                }else{
                    $mysqli->query("UPDATE curso_tipo SET estado=1 WHERE cod_curso='{$cod_curso}' AND id_tipo='{$data}'");
                }
                $retorno['result'] = 'ok';
            }
            
            if($_POST['color']){
                $res_color = $mysqli->query("UPDATE cursos SET color='{$_POST['color']}' WHERE cod_curso='{$cod_curso}'");
                if($res_color){
                    $retorno['result'] = 'ok';
                }else{
                    $retorno['result'] = 'Error al cambiar el color';
                }
            }
        }else{
            $retorno['result'] = 'No se encuentra el curso';
        }
        
        print(json_encode($retorno));
    break;
    
    case "enviar_consulta":
        if(isset($_POST['tipo']) && $_POST['tipo'] == '3' ){
            if(isset($_POST['filial']) && isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['phone'])){
                $retorno = guardarConsultaCurso($_POST['filial'], $_POST['email'], $_POST['nombre'], $_POST['phone']);
            }else{
                $retorno = array("success" => false, "error" => 'Faltan datos!');
            }
            print(json_encode($retorno));
        }
    break;
    
    case "eliminar_de_malla":
        $retorno = array();
        if(isset($_POST['id']))
        {
            $query = "DELETE FROM malla_curricular WHERE id = " . $_POST['id'];
            
            $resultado = $mysqli->query($query);
            
            if($resultado)
            {
                $retorno['result'] = 'ok';
            }
            else
            {
                $retorno['result'] = 'Ocurrio un error al modificar el estado';
            }
        }
        else
        {
            $retorno['result'] = 'Faltan variables';
        }
        print(json_encode($retorno));
    break;
    
    case "agregar_a_malla":
        $retorno = array();
        if(isset($_POST['materia']) && isset($_POST['cuatrimestre']) && isset($_POST['id_cfi']))
        {
            $query = "INSERT INTO malla_curricular (id_curso_filial_idioma, cuatrimestre, materia) VALUES ({$_POST['id_cfi']}, {$_POST['cuatrimestre']}, '{$_POST['materia']}')";
            
            $resultado = $mysqli->query($query);
            
            if($resultado)
            {
                $retorno['result'] = 'ok';
            }
            else
            {
                $retorno['result'] = 'Ocurrio un error al modificar el estado';
            }
        }
        else
        {
            $retorno['result'] = 'Faltan variables';
        }
        
        print(json_encode($retorno));
    break;
}

//funciones auxiliares

function myFunc(&$item, $key) {
    $item = utf8_encode($item);
}


?>