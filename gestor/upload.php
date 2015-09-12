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
		if(unlink($datos_curso['img_materiales'])){
			$ext = getExtension($_FILES['imageMateriales']['name']);
			
			$new_file_name = "mat-curso-".$datos_curso['id'];
		
			$exito = move_uploaded_file($_FILES['imageMateriales']['tmp_name'], 'images/img-materiales/'.$new_file_name.".".$ext);
			
			if($exito){
				$query = "UPDATE cursos SET img_materiales='images/img-materiales/".$new_file_name.".".$ext."' WHERE id=".$_POST['id_curso'];
				$result = $mysqli->query($query);
				if($result){
					$message = "<br/>Imagen de los materiales agregada correctamente.<br/>";
				}
			}else{
				$message = "Hubo error al modificar la imagen";
			}
		}else{
			$message = "No se pudo eliminar la imagen anterior.";
		}
	}
}

if(isset($_FILES['imageUniformes']['name']) && $_FILES['imageUniformes']['name'] != ''){
	if(!$_FILES['imageUniformes']['error']){
		if(unlink($datos_curso['img_uniforme'])){
			$ext = getExtension($_FILES['imageUniformes']['name']);
			
			$new_file_name = "unif-curso-".$datos_curso['id'];
		
			$exito = move_uploaded_file($_FILES['imageUniformes']['tmp_name'], 'images/img-uniforme/'.$new_file_name.".".$ext);
			
			if($exito){
				$query = "UPDATE cursos SET img_uniforme='images/img-uniforme/".$new_file_name.".".$ext."' WHERE id=".$_POST['id_curso'];
				$result = $mysqli->query($query);
				if($result){
					$message = "<br/>Imagen de uniforme agregada correctamente.<br/>";
				}
			}else{
				$message = "Hubo error al modificar la imagen";
			}
		}else{
			$message = "No se pudo eliminar la imagen anterior.";
		}
	}
}

header("Location: cursos.php?id_curso=".$_POST['id_curso']);

?>