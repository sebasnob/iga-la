<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

$datos_curso = getDatos($mysqli, $_POST['id_curso'],$_POST['idioma']);

//Funcion auxiliar para determinar la extension de un archivo
function getExtension($str){
	$i = strrpos($str,".");
	if (!$i){ 
		return "";
	}
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

$message="";

//##### MODIFICACION DE COLORES #####//
if($_POST['chose_color']){
	$query = "UPDATE cursos SET color='".$_POST['chose_color']."' WHERE id=".$_POST['id_curso'];
	$result = $mysqli->query($query);
	if($result){
		$message = "<br/>El color se modifico correctamente.<br/>";
	}
}
//##### FIN MODIFICACION DE COLORES #####//


//##### MODIFICACION DE SLIDER #####//
if(isset($_FILES['imageSlider']['name']) && $_FILES['imageSlider']['name'] != ''){
    if(!$_FILES['imageSlider']['error']){

        if(file_exists($datos_curso['img_cabecera'])){
            unlink($datos_curso['img_cabecera']);
        }

        $ext = getExtension($_FILES['imageSlider']['name']);
        $ruta_slider = 'images/slider/curso-'.$_POST['id_curso'].'/'.$_POST['idioma'].'/';
        $new_file_name = "slider-curso-".$_POST['id_curso'].".".$ext;

        $exito = move_uploaded_file($_FILES['imageSlider']['tmp_name'], $ruta_slider.$new_file_name);

        if($exito){
                $query = "UPDATE curso_idioma SET img_cabecera='".$ruta_slider.$new_file_name."' WHERE id_curso=".$_POST['id_curso']." AND idioma='".$_POST['idioma']."'";
                $result = $mysqli->query($query);
                if($result){
                        $message = "<br/>Imagen de los materiales agregada correctamente.<br/>";
                }
        }else{
                $message = "Hubo error al modificar la imagen";
        }
    }
}
//##### FIN MODIFICACION DE SLIDER #####//

if(isset($_FILES['imageMateriales']['name']) && $_FILES['imageMateriales']['name'] != ''){
    if(!$_FILES['imageMateriales']['error']){
        if(file_exists($datos_curso['img_materiales'])){
            unlink($datos_curso['img_materiales']);
        }

        $ext = getExtension($_FILES['imageMateriales']['name']);
        $ruta_materiales = 'images/img-materiales/curso-'.$_POST['id_curso'].'/'.$_POST['idioma'].'/';
        $new_file_name = "img_materiales.".$ext;

        $exito = move_uploaded_file($_FILES['imageMateriales']['tmp_name'], $ruta_materiales.$new_file_name);

        if($exito){
            $query = "UPDATE curso_idioma SET img_materiales='".$ruta_materiales.$new_file_name."' WHERE id_curso=".$_POST['id_curso']." AND idioma='".$_POST['idioma']."'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Imagen de los materiales agregada correctamente.<br/>";
            }
        }else{
            $message = "Hubo error al modificar la imagen";
        }
    }
}

if(isset($_FILES['imageUniformes']['name']) && $_FILES['imageUniformes']['name'] != ''){
    if(!$_FILES['imageUniformes']['error']){
        if(file_exists($datos_curso['img_uniforme'])){
           unlink($datos_curso['img_uniforme']); 
        }

        $ext = getExtension($_FILES['imageUniformes']['name']);
        $ruta_uniformes = 'images/img-uniforme/curso-'.$_POST['id_curso'].'/'.$_POST['idioma'].'/';
        $new_file_name = "img_uniforme.".$ext;

        $exito = move_uploaded_file($_FILES['imageUniformes']['tmp_name'], $ruta_uniformes.$new_file_name);

        if($exito){
            $query = "UPDATE curso_idioma SET img_uniforme='".$ruta_uniformes.$new_file_name."' WHERE id_curso=".$_POST['id_curso']." AND idioma='".$_POST['idioma']."'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Imagen de uniforme agregada correctamente.<br/>";
            }
        }else{
            $message = "Hubo error al modificar la imagen";
        }
    }
}

header("Location: cursos.php?id_curso=".$_POST['id_curso']);

?>