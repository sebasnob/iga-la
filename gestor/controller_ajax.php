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
        $datos_curso = getDatosCurso($mysqli, $_POST['cod_curso'], $_POST['id_pais'], $_POST['id_idioma'], $_POST['id_filial']);
        if(is_array($datos_curso)){
            $datos_curso = array_map('utf8_encode', $datos_curso);
        }
        
        print(json_encode($datos_curso));
        
    break;
}

?>
