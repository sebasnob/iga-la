<?php
    
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(isset($_POST['edicion_curso'])){

    $datos_curso = getDatos($mysqli, $_POST['id_curso'],$_POST['idioma']);

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
            
            $ruta_slider = '../images/slider/'.$_POST['id_curso'].'/'.$_POST['idioma'].'/';
            
            if(!is_dir($ruta_slider)){
                mkdir($ruta_slider);
            }

            $ext = getExtension($_FILES['imageSlider']['name']);
            
            $new_file_name = "slider-".$_POST['id_curso'].".".$ext;

            $exito = move_uploaded_file($_FILES['imageSlider']['tmp_name'], $ruta_slider.$new_file_name);

            if($exito){
                    $query = "UPDATE curso_datos as cd INNER JOIN curso_idioma as ci ON ci.id=cd.id_curso_idioma SET cd.img_cabecera='".$ruta_slider.$new_file_name."' WHERE ci.id_curso=".$_POST['id_curso']." AND ci.idioma='".$_POST['idioma']."'";
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
            $ext = getExtension($_FILES['imageMateriales']['name']);
            $ruta_materiales = '../images/materiales/'.$_POST['id_curso'].'/'.$_POST['idioma'].'/';
            $new_file_name = "materiales.".$ext;
            
            if(file_exists($datos_curso['img_materiales'])){
                unlink($datos_curso['img_materiales']);
            }

            if(!is_dir($ruta_materiales)){
                mkdir($ruta_materiales);
            }

            $exito = move_uploaded_file($_FILES['imageMateriales']['tmp_name'], $ruta_materiales.$new_file_name);

            if($exito){
                $query = "UPDATE curso_datos as cd INNER JOIN curso_idioma as ci ON ci.id=cd.id_curso_idioma SET cd.img_materiales='".$ruta_materiales.$new_file_name."' WHERE ci.id_curso=".$_POST['id_curso']." AND ci.idioma='".$_POST['idioma']."'";
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
            $ext = getExtension($_FILES['imageUniformes']['name']);
            $ruta_uniformes = '../images/uniformes/'.$_POST['id_curso'].'/'.$_POST['idioma'].'/';
            $new_file_name = "uniforme.".$ext;
            
            if(file_exists($datos_curso['img_uniforme'])){
               unlink($datos_curso['img_uniforme']); 
            }

            if(!is_dir($ruta_uniformes)){
                mkdir($ruta_uniformes);
            }

            $exito = move_uploaded_file($_FILES['imageUniformes']['tmp_name'], $ruta_uniformes.$new_file_name);

            if($exito){
                $query = "UPDATE curso_datos as cd INNER JOIN curso_idioma as ci ON ci.id=cd.id_curso_idioma SET cd.img_uniforme='".$ruta_uniformes.$new_file_name."' WHERE ci.id_curso=".$_POST['id_curso']." AND ci.idioma='".$_POST['idioma']."'";
                $result = $mysqli->query($query);
                if($result){
                        $message = "<br/>Imagen de uniforme agregada correctamente.<br/>";
                }
            }else{
                $message = "Hubo error al modificar la imagen";
            }
        }
    }

    header("Location: cursos.php?id_curso=".$_POST['id_curso']."&idioma=".$_POST['idioma']);
    
}    

if(isset($_POST['edicion_grilla']))
{
    if(isset($_POST['edicion_grilla_nueva']))
    {
        if(isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '')
        {
            //if no errors...
            if(!$_FILES['photo']['error'])
            {
                $valid_file = true;
                //now is the time to modify the future file name and validate the file
                $new_file_name = strtolower($_FILES['photo']['name']); //rename file
                if($_FILES['photo']['size'] > (6144000)) //can't be larger than 6 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                }
                    
                $pos = strpos($_FILES['photo']['type'], "image");
                if ($pos === FALSE)
                {
                    $valid_file = false;
                    $message = 'Oops!  El archivo no es una imagen.';
                }
                //if the file has passed the test
                if($valid_file)
                {
                    //move it to where we want it to be
                    $ruta = '../images/grilla/'.$new_file_name;
                    //ruta de los thumbs
                    $ruta_thumb = '../images/grilla/thumb/'.$new_file_name;

                    move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
                    
                    //creo el thumb
                    $newThumb = new resize($ruta);
                    $newThumb->resizeImage(150,632,"landscape");
                    $exito = $newThumb->saveImage($ruta_thumb);
                            
                    $stmt = $mysqli->prepare("INSERT INTO grilla (rows, cols, img_url, thumb_url, prioridad, id_curso, habilitado) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('rows', $_POST['rows']);
                    $stmt->bind_param('cols', $_POST['cols']);
                    $stmt->bind_param('img_url', $ruta);
                    $stmt->bind_param('thumb_url', $ruta_thumb);
                    $stmt->bind_param('prioridad', $_POST['prioridad']);
                    $stmt->bind_param('id_curso', $_POST['id_curso']);
                    $stmt->bind_param('habilitado', $_POST['habilitado']);
                    $stmt->execute();
                            
                }
            }
            //if there is an error...
            else
            {
                //set that to be the returned message
                $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
            }
        }
        
        header('Location: admin.php');
        exit;
    }
    
}
    
//Funcion auxiliar para determinar la extension de un archivo
function getExtension($str)
{
    $i = strrpos($str,".");
    if (!$i)
    { 
        return "";
    }

    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    
    return $ext;
}
    
?>