<?php
    
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/resizeImage.php';

if(isset($_POST['edicion_curso_grupo'])){
    //##### MODIFICACION DE SLIDER #####//
    if(isset($_FILES['imageSlider']['name']) && $_FILES['imageSlider']['name'] != ''){
        if(!$_FILES['imageSlider']['error']){
            $filiales = $_POST['filial'];
            foreach($filiales as $id=>$value){

                if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/')){
                    mkdir('../images/slider/'.$_POST['cod_curso'].'/');
                }
                
                if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/')){
                    mkdir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/');
                }
                
                $idioma = getIdiomas($mysqli, $_POST['idioma_curso']);
                if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/')){
                    mkdir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/');
                }
                
                $ruta_slider = '../images/slider/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/';
                
                $ext = getExtension($_FILES['imageSlider']['name']);

                $new_file_name = "slider-".$_POST['cod_curso'].".".$ext;
                
                if(file_exists($ruta_slider.$new_file_name)){
                    unlink($ruta_slider.$new_file_name);
                }

                $exito = move_uploaded_file($_FILES['imageSlider']['tmp_name'], $ruta_slider.$new_file_name);

                if($exito){
                        $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['paises_curso']}'";
                        $result_sel = $mysqli->query($query_sel);
                        $cfi = $result_sel->fetch_assoc();
                        
                        $query = "UPDATE curso_datos SET url_cabecera='".$ruta_slider.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
echo $cfi['id'];                        
                        $result = $mysqli->query($query);
                        if($result){
                                $message = "<br/>Imagen modificada correctamente.<br/>";
                        }
                }else{
                        $message = "Hubo un error al subir la imagen";
                }
            }
        }
    }
    //##### FIN MODIFICACION DE SLIDER #####//
    
    
    //##### INICIO MODIFICACION DE IMAGEN DE MATERIALES #####//
    if(isset($_FILES['imageMateriales']['name']) && $_FILES['imageMateriales']['name'] != ''){
        if(!$_FILES['imageMateriales']['error']){
            $filiales = $_POST['filial'];
            foreach($filiales as $id=>$value){

                if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/')){
                    mkdir('../images/materiales/'.$_POST['cod_curso'].'/');
                }
                
                if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/')){
                    mkdir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/');
                }
                
                $idioma = getIdiomas($mysqli, $_POST['idioma_curso']);
                if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/')){
                    mkdir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/');
                }
                
                $ruta_materiales = '../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/';
                
                $ext = getExtension($_FILES['imageMateriales']['name']);

                $new_file_name = "materiales.".$ext;
                
                if(file_exists($ruta_materiales.$new_file_name)){
                    unlink($ruta_materiales.$new_file_name);
                }

                $exito = move_uploaded_file($_FILES['imageMateriales']['tmp_name'], $ruta_materiales.$new_file_name);

                if($exito){
                        $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['paises_curso']}'";
                        $result_sel = $mysqli->query($query_sel);
                        $cfi = $result_sel->fetch_assoc();
                        
                        $query = "UPDATE curso_datos SET url_material='".$ruta_materiales.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
echo $cfi['id'];                        
                        $result = $mysqli->query($query);
                        if($result){
                                $message = "<br/>Imagen modificada correctamente.<br/>";
                        }
                }else{
                        $message = "Hubo un error al subir la imagen";
                }
            }
        }
    }
    //###### FIN MODIFICACION DE IMAGEN DE MATERIALES #####//
    
    
    
    
}

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
                    
                    $ruta = substr($ruta, 3);
                    $ruta_thumb = substr($ruta_thumb, 3);
                    
                    $query = "INSERT INTO grilla (cols, img_url, thumb_url, prioridad, cod_curso, habilitado, idioma, pais) VALUES ({$_POST['cols']}, '{$ruta}','{$ruta_thumb}', {$_POST['prioridad']},'{$_POST['id_curso']}',{$_POST['habilitado']}, '{$_POST['idioma']}', {$_POST['pais']})";
                    $mysqli->query($query);
                            
                }
            }
            //if there is an error...
            else
            {
                //set that to be the returned message
                $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
            }
        }
        
        header('Location: grilla_edit.php');
        exit;
    }
    elseif(isset($_POST['edicion_grilla_editar']))
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
                    
                    $ruta = substr($ruta, 3);
                    $ruta_thumb = substr($ruta_thumb, 3);
                    
                    $query = "UPDATE grilla "
                            . "SET cols = {$_POST['cols']}, "
                            . "img_url = '{$ruta}', "
                            . "thumb_url = '{$ruta_thumb}', "
                            . "prioridad = {$_POST['prioridad']}, "
                            . "cod_curso = {$_POST['id_curso']}, "
                            . "habilitado = {$_POST['habilitado']}, "
                            . "idioma = '{$_POST['idioma']}', "
                            . "id_pais = {$_POST['pais']} WHERE grilla.id = {$_POST['id_img_grilla']}";
                    $mysqli->query($query);
                }
            }
        }
        else
        {
            $query = "UPDATE grilla "
                            . "SET cols = {$_POST['cols']}, "
                            . "prioridad = {$_POST['prioridad']}, "
                            . "cod_curso = {$_POST['id_curso']}, "
                            . "habilitado = {$_POST['habilitado']}, "
                            . "idioma = '{$_POST['idioma']}', "
                            . "id_pais = {$_POST['pais']} WHERE grilla.id = {$_POST['id_img_grilla']}";
            $mysqli->query($query);
        }
    }
}

if(isset($_POST['edicion_home'])){
    if(isset($_POST['url_video']) && $_POST['url_video'] != ''){
        $query = "UPDATE home SET url_video='".$_POST['url_video']."'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>El video se modifico correctamente.<br/>";
        }
    }
    
    if(isset($_POST['titulo']) && $_POST['titulo'] != ''){
        switch($_POST['idioma']){
            case 'IN':
                    $query = "UPDATE home SET titulo_in='".$_POST['titulo']."'";
                break;
            case 'POR':
                    $query = "UPDATE home SET titulo_por='".$_POST['titulo']."'";
                break;
            default: 
                   $query = "UPDATE home SET titulo_es='".$_POST['titulo']."'"; 
                break;
        }
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>El texto se modifico correctamente.<br/>";
        }
    }
    
    if(isset($_POST['subtitulo']) && $_POST['subtitulo'] != ''){
        switch($_POST['idioma']){
            case 'IN':
                    $query = "UPDATE home SET subtitulo_in='".$_POST['subtitulo']."'";
                break;
            case 'POR':
                    $query = "UPDATE home SET subtitulo_por='".$_POST['subtitulo']."'";
                break;
            default: 
                   $query = "UPDATE home SET subtitulo_es='".$_POST['subtitulo']."'"; 
                break;
        }
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>El texto se modifico correctamente.<br/>";
        }
    }
    
    if(isset($_POST['chose_color_fondo']) && $_POST['chose_color_fondo'] != ''){
        $query = "UPDATE home SET menu_color='".$_POST['chose_color_fondo']."'";
        $result = $mysqli->query($query);
    }
    
    if(isset($_POST['chose_color_fuente']) && $_POST['chose_color_fuente'] != ''){
        $query = "UPDATE home SET fuente_color='".$_POST['chose_color_fuente']."'";
        $result = $mysqli->query($query);
    }
    
    header("Location: home_edit.php?idioma=".$_POST['idioma']);
}

if(isset($_POST['edicion_grilla_editar']))
{
    $id_img_grilla = $_POST['id_img_grilla'];
    if(isset($_GET['borrar']))
    {
        $result = $mysqli->query("SELECT grilla.img_url, grilla.thumb_url FROM grilla WHERE grilla.id = {$id_img_grilla}");

        $retorno = $result->fetch_assoc();

        if(file_exists("../".$retorno['img_url']))
        {
            unlink("../".$retorno['img_url']);
        }
        if(file_exists("../".$retorno['thumb_url']))
        {
            unlink("../".$retorno['thumb_url']);
        }

        $mysqli->query("DELETE FROM grilla WHERE grilla.id = " . $id_img_grilla);
        header('Location: grilla_edit.php');
        exit;
    }
    else
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

                    $ruta = substr($ruta, 3);
                    $ruta_thumb = substr($ruta_thumb, 3);

                    $query = "UPDATE grilla SET rows = {$_POST['rows']}, cols = {$_POST['cols']}, img_url = '{$ruta}', thumb_url = '{$ruta_thumb}', prioridad = {$_POST['prioridad']}, id_curso = '{$_POST['id_curso']}', habilitado = {$_POST['habilitado']}, idioma = '{$_POST['idioma']}' WHERE grilla.id = {$id_img_grilla}";
                }
            }
        }
        else
        {
            $query = "UPDATE grilla SET rows = {$_POST['rows']}, cols = {$_POST['cols']}, prioridad = {$_POST['prioridad']}, id_curso = '{$_POST['id_curso']}', habilitado = {$_POST['habilitado']}, idioma = '{$_POST['idioma']}' WHERE grilla.id = {$id_img_grilla}";
        }

        $mysqli->query($query);
        header('Location: grilla_edit.php');
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
