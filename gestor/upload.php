<?php
    
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/resizeImage.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

if($logged == 'out'){
    header("Location: login.php");
    exit();
}

if(isset($_POST['edicion_curso_grupo'])){
    //##### MODIFICACION DE SLIDER #####//
    if(isset($_FILES['imageSlider']['name']) && $_FILES['imageSlider']['name'] != ''){
        if(!$_FILES['imageSlider']['error']){
            if(move_uploaded_file($_FILES['imageSlider']['tmp_name'], '../images/slider/tmp/'.$_FILES['imageSlider']['name'])){
                $idioma = getIdiomas($mysqli, $_POST['idioma_curso']);
                $ext = getExtension($_FILES['imageSlider']['name']);
                $filiales = $_POST['filial'];
                foreach($filiales as $id=>$value){

                    if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/')){
                        mkdir('../images/slider/'.$_POST['cod_curso'].'/');
                    }

                    if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/')){
                        mkdir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/');
                    }

                    if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/')){
                        mkdir('../images/slider/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/');
                    }

                    $ruta_slider = 'images/slider/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/';

                    $new_file_name = "slider-".$_POST['cod_curso'].".".$ext;

                    if(file_exists("../".$ruta_slider.$new_file_name)){
                        unlink("../".$ruta_slider.$new_file_name);
                    }
                    
                    if(copy('../images/slider/tmp/'.$_FILES['imageSlider']['name'], "../".$ruta_slider.$new_file_name)){
                            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
                            $result_sel = $mysqli->query($query_sel);
                            $cfi = $result_sel->fetch_assoc();

                            $query = "UPDATE curso_datos SET url_cabecera='".$ruta_slider.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
                            $result = $mysqli->query($query);
                            if($result){
                                    $message = "<br/>Imagen modificada correctamente.<br/>";
                            }
                    }else{
                            $message = "Hubo un error al subir la imagen";
                    }
                }
                unlink('../images/slider/tmp/'.$_FILES['imageSlider']['name']);
            }else{
                $message = "Hubo un problema al generar la imagen temporal";
            }
        }
    }
    //##### FIN MODIFICACION DE SLIDER #####//
    
    
    //##### INICIO MODIFICACION DE IMAGEN DE MATERIALES #####//
    if(isset($_FILES['imageMateriales']['name']) && $_FILES['imageMateriales']['name'] != ''){
        if(!$_FILES['imageMateriales']['error']){
            if(move_uploaded_file($_FILES['imageMateriales']['tmp_name'], '../images/materiales/tmp/'.$_FILES['imageMateriales']['name'])){
                $idioma = getIdiomas($mysqli, $_POST['idioma_curso']);
                $ext = getExtension($_FILES['imageMateriales']['name']);
                $filiales = $_POST['filial'];
                foreach($filiales as $id=>$value){

                    if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/')){
                        mkdir('../images/materiales/'.$_POST['cod_curso'].'/');
                    }

                    if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/')){
                        mkdir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/');
                    }

                    if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/')){
                        mkdir('../images/materiales/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/');
                    }

                    $ruta_materiales = 'images/materiales/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/';

                    $new_file_name = "materiales.".$ext;

                    if(file_exists("../".$ruta_materiales.$new_file_name)){
                        unlink("../".$ruta_materiales.$new_file_name);
                    }
                    
                    if(copy('../images/materiales/tmp/'.$_FILES['imageMateriales']['name'], "../".$ruta_materiales.$new_file_name)){
                            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
                            $result_sel = $mysqli->query($query_sel);
                            $cfi = $result_sel->fetch_assoc();

                            $query = "UPDATE curso_datos SET url_material='".$ruta_materiales.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
                            $result = $mysqli->query($query);
                            if($result){
                                    $message = "<br/>Imagen modificada correctamente.<br/>";
                            }
                    }else{
                            $message = "Hubo un error al subir la imagen";
                    }
                }
                unlink('../images/materiales/tmp/'.$_FILES['imageMateriales']['name']);
            }else{
                $message = "Hubo un problema al generar la imagen temporal";
            }
        }
    }
    //###### FIN MODIFICACION DE IMAGEN DE MATERIALES #####//
    
    
    //##### INICIO MODIFICACION DE IMAGEN DE UNIFORMES #####//
    if(isset($_FILES['imageUniformes']['name']) && $_FILES['imageUniformes']['name'] != ''){
        if(!$_FILES['imageUniformes']['error']){
            if(move_uploaded_file($_FILES['imageUniformes']['tmp_name'], '../images/uniformes/tmp/'.$_FILES['imageUniformes']['name'])){
                $idioma = getIdiomas($mysqli, $_POST['idioma_curso']);
                $ext = getExtension($_FILES['imageUniformes']['name']);
                $filiales = $_POST['filial'];
                foreach($filiales as $id=>$value){

                    if(!is_dir('../images/uniformes/'.$_POST['cod_curso'].'/')){
                        mkdir('../images/uniformes/'.$_POST['cod_curso'].'/');
                    }

                    if(!is_dir('../images/uniformes/'.$_POST['cod_curso'].'/'.$value.'/')){
                        mkdir('../images/uniformes/'.$_POST['cod_curso'].'/'.$value.'/');
                    }

                    if(!is_dir('../images/uniformes/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/')){
                        mkdir('../images/uniformes/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/');
                    }

                    $ruta_uniforme = 'images/uniformes/'.$_POST['cod_curso'].'/'.$value.'/'.$idioma[0]['cod_idioma'].'/';

                    $new_file_name = "uniforme.".$ext;

                    if(file_exists("../".$ruta_uniforme.$new_file_name)){
                        unlink("../".$ruta_uniforme.$new_file_name);
                    }
                    
                    if(copy('../images/uniformes/tmp/'.$_FILES['imageUniformes']['name'], "../".$ruta_uniforme.$new_file_name)){
                            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
                            $result_sel = $mysqli->query($query_sel);
                            $cfi = $result_sel->fetch_assoc();

                            $query = "UPDATE curso_datos SET url_uniforme='".$ruta_uniforme.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
                            $result = $mysqli->query($query);
                            if($result){
                                    $message = "<br/>Imagen modificada correctamente.<br/>";
                            }
                    }else{
                            $message = "Hubo un error al subir la imagen";
                    }
                }
                unlink('../images/uniformes/tmp/'.$_FILES['imageUniformes']['name']);
            }else{
                $message = "Hubo un problema al generar la imagen temporal";
            }
        }
    }
    //###### FIN MODIFICACION DE IMAGEN DE UNIFORMES #####//
    
    //### DURACION ###//
    if(isset($_POST['horas']) && $_POST['horas'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();

            $query = "UPDATE curso_datos SET horas='{$_POST['horas']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Horas modificadas correctamente.<br/>";
            }
        }
    }
    
    if(isset($_POST['meses']) && $_POST['meses'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();

            $query = "UPDATE curso_datos SET meses='{$_POST['meses']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Meses modificadas correctamente.<br/>";
            }
        }
    }
    
    if(isset($_POST['anios']) && $_POST['anios'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();

            $query = "UPDATE curso_datos SET anios='{$_POST['anios']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Años modificados correctamente.<br/>";
            }
        }
    }
    //### FIN EDICION DURACION ###//
    
    //### DESCRIPCION ###//
    if(isset($_POST['descripcion']) && $_POST['descripcion'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();

            $query = "UPDATE curso_datos SET descripcion='{$_POST['descripcion']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Descripcion del curso modificada correctamente.<br/>";
            }
        }
    }
    //### FIN EDICION DESCRIPCION ##//
    
    //### EDICION DESCRIPCION DE MATERIALES ###//
    if(isset($_POST['materiales_txt']) && $_POST['materiales_txt'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();

            $query = "UPDATE curso_datos SET desc_material='{$_POST['materiales_txt']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Descripcion de los materiales modificados correctamente.<br/>";
            }
        }
    }
    //### FINEDICION DESCRIPCION DE MATERIALES ###//
    
    
    //### EDICION DESCRIPCION DEL UNIFORME ###//
    if(isset($_POST['uniformes_txt']) && $_POST['uniformes_txt'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();

            $query = "UPDATE curso_datos SET desc_uniforme='{$_POST['uniformes_txt']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Descripcion del unforme modificado correctamente.<br/>";
            }
        }
    }
    //### FIN EDICION DESCRIPCION DEL UNIFORME ###//
    
    //### EDICION OBJETIVOS ###//
    if(isset($_POST['objetivos']) && $_POST['objetivos'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();
            
            $query = "UPDATE curso_datos SET objetivos='{$_POST['objetivos']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Objetivos modificados correctamente.<br/>";
            }
        }
    }
    //### FIN EDICION DESCRIPCION DE OBJETIVOS ###//
    
    //### EDICION ESTADO DE LOS CURSOS ###//
    if(isset($_POST['estado_curso']) && $_POST['estado_curso'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query = "UPDATE curso_filial_idioma SET estado='{$_POST['estado_curso']}' WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message .= "<br/>Estado modificados correctamente.<br/>";
            }
        }
    }
    //### FIN EDICION ESTADO DE LOS CURSOS ###//
    
    //### EDICION NOMBRE ###//
    if(isset($_POST['nombre_curso']) && $_POST['nombre_curso'] != ''){
        $filiales = $_POST['filial'];
        foreach($filiales as $id=>$value){
            $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$value}' AND id_idioma='{$_POST['idioma_curso']}'";
            $result_sel = $mysqli->query($query_sel);
            $cfi = $result_sel->fetch_assoc();
            
            $query = "UPDATE curso_datos SET nombre='{$_POST['nombre_curso']}' WHERE id_cfi='{$cfi['id']}'";
            $result = $mysqli->query($query);
            if($result){
                    $message = "<br/>Nombre modificado correctamente.<br/>";
            }
        }
    }
    //### FIN EDICION DE NOMBRE ###//
    
    header("Location: result.php?cod_curso={$_POST['cod_curso']}");
    exit;
}

if(isset($_POST['edicion_curso'])){

    $datos_curso = getDatosCurso($mysqli, $_POST['cod_curso'], $_POST['idioma_curso'], $_POST['filiales_curso']);
    $idioma = getIdiomas($mysqli, $_POST['idioma_curso']);
    $filial = $_POST['filiales_curso'];
    
    $message="";

    //##### MODIFICACION DE SLIDER #####//
    if(isset($_FILES['imageSlider']['name']) && $_FILES['imageSlider']['name'] != ''){
        if(!$_FILES['imageSlider']['error']){
            if(file_exists($datos_curso['url_cabecera'])){
                unlink($datos_curso['url_cabecera']);
            }
            
            if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/')){
                mkdir('../images/slider/'.$_POST['cod_curso'].'/');
            }

            if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/'.$filial.'/')){
                mkdir('../images/slider/'.$_POST['cod_curso'].'/'.$filial.'/');
            }

            if(!is_dir('../images/slider/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/')){
                mkdir('../images/slider/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/');
            }

            $ruta_slider = 'images/slider/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/';
            
            $ext = getExtension($_FILES['imageSlider']['name']);
            
            $new_file_name = "slider-".$_POST['cod_curso'].".".$ext;

            $exito = move_uploaded_file($_FILES['imageSlider']['tmp_name'], "../".$ruta_slider.$new_file_name);
            if($exito){
                    $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$filial}' AND id_idioma='{$_POST['idioma_curso']}'";
                    $result_sel = $mysqli->query($query_sel);
                    $cfi = $result_sel->fetch_assoc();
                    $query = "UPDATE curso_datos SET url_cabecera='".$ruta_slider.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
                    $result = $mysqli->query($query);
                    if($result){
                            $message = "<br/>Imagen del Slider agregada correctamente.<br/>";
                    }
            }else{
                    $message = "Hubo error al modificar la imagen";
            }
        }
    }
    //##### FIN MODIFICACION DE SLIDER #####//

    //### EDICION IMAGEN DE MATERIALES ###//
    if(isset($_FILES['imageMateriales']['name']) && $_FILES['imageMateriales']['name'] != ''){
        if(!$_FILES['imageMateriales']['error']){
            
            $ext = getExtension($_FILES['imageMateriales']['name']);
            $new_file_name = "materiales.".$ext;
            
            if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/')){
                mkdir('../images/materiales/'.$_POST['cod_curso'].'/');
            }

            if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/'.$filial.'/')){
                mkdir('../images/materiales/'.$_POST['cod_curso'].'/'.$filial.'/');
            }

            if(!is_dir('../images/materiales/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/')){
                mkdir('../images/materiales/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/');
            }

            $ruta_materiales = 'images/materiales/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/';
            if(file_exists($datos_curso['url_material'])){
                unlink($datos_curso['url_material']);
            }
            
            $exito = move_uploaded_file($_FILES['imageMateriales']['tmp_name'], "../".$ruta_materiales.$new_file_name);

            if($exito){
                $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$filial}' AND id_idioma='{$_POST['idioma_curso']}'";
                $result_sel = $mysqli->query($query_sel);
                $cfi = $result_sel->fetch_assoc();

                $query = "UPDATE curso_datos SET url_material='".$ruta_materiales.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
                $result = $mysqli->query($query);
                if($result){
                        $message = "<br/>Imagen de los materiales agregada correctamente.<br/>";
                }
            }else{
                $message = "Hubo error al modificar la imagen";
            }
        }
    }
    //#### FIN EDICION IMAGEN MATERIALES ###//
    
    
    //### EDICION DE IMAGEN DE UNIFORMES ###//
    if(isset($_FILES['imageUniformes']['name']) && $_FILES['imageUniformes']['name'] != ''){
        if(!$_FILES['imageUniformes']['error']){
            
            $ext = getExtension($_FILES['imageUniformes']['name']);
            $new_file_name = "uniforme.".$ext;
            
            if(!is_dir('../images/uniformes/'.$_POST['cod_curso'].'/')){
                mkdir('../images/uniformes/'.$_POST['cod_curso'].'/');
            }

            if(!is_dir('../images/uniformes/'.$_POST['cod_curso'].'/'.$filial.'/')){
                mkdir('../images/uniformes/'.$_POST['cod_curso'].'/'.$filial.'/');
            }

            if(!is_dir('../images/uniformes/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/')){
                mkdir('../images/uniformes/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/');
            }

            $ruta_uniforme = 'images/uniformes/'.$_POST['cod_curso'].'/'.$filial.'/'.$idioma[0]['cod_idioma'].'/';
            
            if(file_exists($datos_curso['url_uniforme'])){
               unlink($datos_curso['url_uniforme']); 
            }

            $exito = move_uploaded_file($_FILES['imageUniformes']['tmp_name'], "../".$ruta_uniforme.$new_file_name);

            if($exito){
                $query_sel = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$filial}' AND id_idioma='{$_POST['idioma_curso']}'";
                $result_sel = $mysqli->query($query_sel);
                $cfi = $result_sel->fetch_assoc();

                $query = "UPDATE curso_datos SET url_uniforme='".$ruta_uniforme.$new_file_name."' WHERE id_cfi='{$cfi['id']}'";
                $result = $mysqli->query($query);
                if($result){
                        $message = "<br/>Imagen de uniforme agregada correctamente.<br/>";
                }
            }else{
                $message = "Hubo error al modificar la imagen";
            }
        }
    }
    ///### FIN EDICION IMAGEN UNIFORMES ###///

    //#### COMIENZO EDICION DE TEXTOS ####//
    $query_sd = "SELECT id FROM curso_filial_idioma WHERE cod_curso='{$_POST['cod_curso']}' AND id_filial='{$filial}' AND id_idioma='{$_POST['idioma_curso']}'";
    $result_sd = $mysqli->query($query_sd);
    $cfi_sd = $result_sd->fetch_assoc();
    
    if(isset($_POST['nombre_curso']) && $_POST['nombre_curso'] != ''){
        $query = "UPDATE curso_datos SET nombre='{$_POST['nombre_curso']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>Nombre del curso modificada correctamente.<br/>";
        }
    }
    
    if(isset($_POST['descripcion']) && $_POST['descripcion'] != ''){
        $query = "UPDATE curso_datos SET descripcion='{$_POST['descripcion']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>Descripcion del curso modificada correctamente.<br/>";
        }
    }
    
    if(isset($_POST['materiales_txt']) && $_POST['materiales_txt'] != ''){
        $query = "UPDATE curso_datos SET desc_material='{$_POST['materiales_txt']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>Descripcion de los materiales modificados correctamente.<br/>";
        }
    }
    
    if(isset($_POST['uniformes_txt']) && $_POST['uniformes_txt'] != ''){
        $query = "UPDATE curso_datos SET desc_uniforme='{$_POST['uniformes_txt']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>Descripcion de los uniformes modificados correctamente.<br/>";
        }
    }
    
    if(isset($_POST['objetivos']) && $_POST['objetivos'] != ''){
        $query = "UPDATE curso_datos SET objetivos='{$_POST['objetivos']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>Objetivos modificados correctamente.<br/>";
        }
    }
    
    //### DURACION ###//
    if(isset($_POST['horas']) && $_POST['horas'] != ''){
        $query = "UPDATE curso_datos SET horas='{$_POST['horas']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
            $message = "<br/>Horas modificadas correctamente.<br/>";
        }
    }
    
    if(isset($_POST['meses']) && $_POST['meses'] != ''){
        $query = "UPDATE curso_datos SET meses='{$_POST['meses']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
                $message = "<br/>Meses modificadas correctamente.<br/>";
        }
    }
    
    if(isset($_POST['anios']) && $_POST['anios'] != ''){
        $query = "UPDATE curso_datos SET anios='{$_POST['anios']}' WHERE id_cfi='{$cfi_sd['id']}'";
        $result = $mysqli->query($query);
        if($result){
            $message = "<br/>Años modificados correctamente.<br/>";
        }
    }
    //### FIN EDICION DURACION ###//
    
    //#####  FIN EDICION DE TEXTOS  #####//
    
    header("Location: result.php?cod_curso={$_POST['cod_curso']}&id_idioma={$_POST['idioma_curso']}&id_filial={$filial}");
    exit;
    
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
                $Length = 10;
                $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                
                $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
                
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
                    $cod_pais = json_encode($_POST['pais']);
                    $query = "INSERT INTO grilla (img_url, thumb_url, prioridad, cod_curso, habilitado, idioma, id_pais, descripcion, titulo) VALUES ('{$ruta}','{$ruta_thumb}', {$_POST['prioridad']},'{$_POST['id_curso']}',{$_POST['habilitado']}, '{$_POST['idioma']}', '{$cod_pais}', '{$_POST['desc']}', '{$_POST['titulo']}')";
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
    }
    elseif(isset($_POST['edicion_grilla_editar']))
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
                    $Length = 10;
                    $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                
                    $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
                    
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

                        $arrayPais = json_encode($_POST['pais']);
                        
                        $query = "UPDATE grilla "
                                . "SET img_url = '{$ruta}', "
                                . "thumb_url = '{$ruta_thumb}', "
                                . "prioridad = {$_POST['prioridad']}, "
                                . "cod_curso = {$_POST['id_curso']}, "
                                . "habilitado = {$_POST['habilitado']}, "
                                . "idioma = '{$_POST['idioma']}', "
                                . "id_pais = '{$arrayPais}', "
                                . "titulo = '{$_POST['titulo']}', "
                                . "descripcion = '{$_POST['desc']}' WHERE grilla.id = {$_POST['id_img_grilla']}";
                        $mysqli->query($query);
                    }
                }
            }
            else
            {
                $arrayPais = json_encode($_POST['pais']);
                $query = "UPDATE grilla "
                                . "SET prioridad = {$_POST['prioridad']}, "
                                . "cod_curso = {$_POST['id_curso']}, "
                                . "habilitado = {$_POST['habilitado']}, "
                                . "idioma = '{$_POST['idioma']}', "
                                . "id_pais = '{$arrayPais}', "
                                . "titulo = '{$_POST['titulo']}', "
                                . "descripcion = '{$_POST['desc']}' WHERE grilla.id = {$_POST['id_img_grilla']}";
                                
                $mysqli->query($query);
            }
        }
    }
    header('Location: grilla_edit.php?accion=filtrar');
    exit;
}

if(isset($_POST['edicion_slider']))
{
    if(isset($_POST['edicion_slider_nueva']))
    {
        if(isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '')
        {
            //if no errors...
            if(!$_FILES['photo']['error'])
            {
                $valid_file = true;
                //now is the time to modify the future file name and validate the file

                $new_file_name = strtolower($_FILES['photo']['name']); //rename file
//                $Length = 10;
//                $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                
//                $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
                
                $new_file_name = str_replace(' ', '-', $new_file_name);
                
                
                if($_FILES['photo']['size'] > (12288000)) //can't be larger than 12 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                }
                
                if(!preg_match("/image/i", $_FILES['photo']['type']))
                {
                    $valid_file = false;
                    $message = 'Oops!  El archivo no es una imagen.';
                }
                //if the file has passed the test
                if($valid_file)
                {
                    //move it to where we want it to be
                    $ruta = '../images/slider/'.$new_file_name;
                    //ruta de los thumbs
                    $ruta_thumb = '../images/slider/thumb/'.$new_file_name;
                    $respuesta = move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
                    //creo el thumb
                    $newThumb = new resize($ruta);
                    $newThumb->resizeImage(150,632,"landscape");
                    $exito = $newThumb->saveImage($ruta_thumb);
                    
                    
                    
                    $ruta = substr($ruta, 3);
                    $ruta_thumb = substr($ruta_thumb, 3);
                    
                    $cod_pais = json_encode($_POST['pais']);
                    $cod_idioma = json_encode($_POST['idioma']);
                    
                    $query = "INSERT INTO slider (alt, url, url_thumb, link, id_pais, cod_idioma, background) VALUES ('{$_POST['alt']}', '{$ruta}','{$ruta_thumb}', '{$_POST['link']}','{$cod_pais}','{$cod_idioma}','{$_POST['background']}')";
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
    }
    elseif(isset($_POST['edicion_slider_editar']))
    {
        $id_img_slider = $_POST['id_img_slider'];
        if(isset($_GET['borrar']))
        {
            $result = $mysqli->query("SELECT slider.url, slider.url_thumb FROM slider WHERE slider.id = {$id_img_slider}");

            $retorno = $result->fetch_assoc();

            if(file_exists("../".$retorno['url']))
            {
                unlink("../".$retorno['url']);
            }
            if(file_exists("../".$retorno['url_thumb']))
            {
                unlink("../".$retorno['url_thumb']);
            }

            $mysqli->query("DELETE FROM slider WHERE slider.id = " . $id_img_slider);
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
                    $Length = 10;
                    $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                    $new_file_name =  $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
                    
                    if($_FILES['photo']['size'] > (12288000)) //can't be larger than 12 MB
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
                        $ruta = '../images/slider/'.$new_file_name;
                        //ruta de los thumbs
                        $ruta_thumb = '../images/slider/thumb/'.$new_file_name;

                        move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);

                        //creo el thumb
                        $newThumb = new resize($ruta);
                        $newThumb->resizeImage(150,632,"landscape");
                        $exito = $newThumb->saveImage($ruta_thumb);

                        $ruta = substr($ruta, 3);
                        $ruta_thumb = substr($ruta_thumb, 3);

                        //borro imagen anterior antes de insertar la nueva
                        $result = $mysqli->query("SELECT slider.url, slider.url_thumb FROM slider WHERE slider.id = {$_POST['id_img_slider']}");
                        $imagenAnterior = $result->fetch_assoc();

                        if(file_exists("../".$imagenAnterior['url']))
                        {
                            unlink("../".$imagenAnterior['url']);
                        }
                        if(file_exists("../".$imagenAnterior['url_thumb']))
                        {
                            unlink("../".$imagenAnterior['url_thumb']);
                        }
                        
                        $cod_pais = json_encode($_POST['pais']);
                        $cod_idioma = json_encode($_POST['idioma']);
                        
                        $query = "UPDATE slider "
                                . "SET alt = '{$_POST['alt']}', "
                                . "url = '{$ruta}', "
                                . "url_thumb = '{$ruta_thumb}', "
                                . "link = '{$_POST['link']}', "
                                . "id_pais = '{$cod_pais}', "
                                . "cod_idioma = '{$cod_idioma}', "
                                . "background = '{$_POST['background']}' "
                                . "WHERE slider.id = {$_POST['id_img_slider']}";
                                    
                        $mysqli->query($query);
                    }
                }
            }
            else
            {
                $cod_pais = json_encode($_POST['pais']);
                $cod_idioma = json_encode($_POST['idioma']);
                $query = "UPDATE slider "
                                . "SET alt = '{$_POST['alt']}', "
                                . "link = '{$_POST['link']}', "
                                . "id_pais = '{$cod_pais}', "
                                . "cod_idioma = '{$cod_idioma}', "
                                . "background = '{$_POST['background']}' "
                                . "WHERE slider.id = {$_POST['id_img_slider']}";
                $mysqli->query($query);
            }
        }    
    }
    header('Location: slider_edit.php');
    exit;
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
        header('Location: grilla_edit.php?accion=filtrar');
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
                $Length = 10;
                $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                
                $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
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
        header('Location: grilla_edit.php?accion=filtrar');
        exit;
    }
}

if(isset($_POST['edicion_noticia'])){
    $id_pais = json_encode($_POST['pais']);
    $id_idioma = $_POST['idioma'];
    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $descripcion = trim($_POST['descripcion']);
    $link = $_POST['link'];
    $fecha = date("Y-m-d",strtotime($_POST['fecha']));
    $estado = 1;
    $autor = $_SESSION['username'];
    if($_POST['accion'] == 'agregar'){
        $message = '';
        $result = 'ok';
        $insert_images = "";
        if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != ''){
            for($i=0; $i < count($_FILES['imagen']['name']); $i++){
                $new_file_name = strtolower($_FILES['imagen']['name'][$i]);
                $Length = 12;
                $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);

                if(!move_uploaded_file($_FILES['imagen']['tmp_name'][$i], '../images/novedades/'.$new_file_name)){
                    $message .= "Hubo un error al subir la imagen";
                    $result = 'error';
                }else{
                    if($i == 0){
                        $insert_images .= " imagen='{$new_file_name}', ";
                    }else{
                        $indice = $i + 1;
                        $insert_images .= " imagen{$indice}='{$new_file_name}', ";
                    }
                }
            }
            $query_ins = "INSERT INTO novedades SET {$insert_images} titulo='{$titulo}', descripcion='{$descripcion}', fecha='{$fecha}', link='{$link}', estado='{$estado}', autor='{$autor}', id_pais='{$id_pais}', id_idioma={$id_idioma}, categoria={$categoria}";
            $res_query = $mysqli->query($query_ins);
            if($res_query){
                $message .= "La novedad se agrego correctamente";
            }else{
                $message .= "Hubo un error al agregar la novedad";
                $result = 'error';
            }
        }else{
            $result = 'error';
        }
        header("Location: news_admin.php?result={$result}");
        exit();
    }else{
        //EDITAR
        $message = '';
        $result = 'ok';
        $edit_image = "";
        if(isset($_POST['id_novedad'])){
            if(isset($_POST['imagenBorrar2']) && $_POST['imagenBorrar2'] != ''){
                $query = $mysqli->query("SELECT imagen2 FROM novedades WHERE id={$_POST['id_novedad']}");
                $imagen2 = $query->fetch_assoc();
                $edit_image .= " imagen2='', ";
                if($imagen2['imagen2'] != ''){
                    if(file_exists("../images/novedades/".$imagen2['imagen2'])){
                        unlink("../images/novedades/".$imagen2['imagen2']);
                    }
                }
            }
            if(isset($_POST['imagenBorrar3']) && $_POST['imagenBorrar3'] != ''){
                $query = $mysqli->query("SELECT imagen3 FROM novedades WHERE id={$_POST['id_novedad']}");
                $imagen3 = $query->fetch_assoc();
                $edit_image .= " imagen3='', ";
                if($imagen3['imagen3'] != ''){
                    if(file_exists("../images/novedades/".$imagen3['imagen3'])){
                        unlink("../images/novedades/".$imagen3['imagen3']);
                    }
                }
            }
            if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != ''){
                for($i=0; $i < count($_FILES['imagen']['name']); $i++){
                    $new_file_name = strtolower($_FILES['imagen']['name'][$i]);
                    $Length = 12;
                    $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                    $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);

                    if(!move_uploaded_file($_FILES['imagen']['tmp_name'][$i], '../images/novedades/'.$new_file_name)){
                        $message .= "Hubo un error al subir la imagen";
                        $result = 'error1';
                    }else{
                        if($i == 0){
                            $edit_image .= " imagen='{$new_file_name}', ";
                        }else{
                            $j = $i+1;
                            $edit_image .= " imagen{$j}='{$new_file_name}', ";
                        }
                    }
                }
            }
            
            $query_ins = "UPDATE novedades SET {$edit_image} titulo='{$titulo}', descripcion='{$descripcion}', fecha='{$fecha}', link='{$link}', estado='{$estado}', autor='{$autor}', id_pais='{$id_pais}', id_idioma={$id_idioma}, categoria={$categoria} WHERE id={$_POST['id_novedad']}";
            $res_query = $mysqli->query($query_ins);
            if($res_query){
                $message .= "La novedad se edito correctamente";
            }else{
                $message .= "Hubo un error al editar la novedad";
                $result = 'error2';
            }
        }else{
            $message .= "No se encuentra la novedad seleccionada en la base de datos";
            $result = 'error3';
        }
        header("Location: news_admin.php?result={$result}&id={$_POST['id_novedad']}");
        exit();
    }
    echo $message;
}

if(isset($_POST['nuevoAuspiciante']))
{
    $query_ins = false;
    $nombre = $_POST['name'];
    $cod_pais = json_encode($_POST['pais']);
    $link = $_POST['link'];

    if(isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '')
    {
        //if no errors...
        if(!$_FILES['photo']['error'])
        {
            $valid_file = true;
            //now is the time to modify the future file name and validate the file
            $new_file_name = strtolower($_FILES['photo']['name']); //rename file
            $Length = 10;
            $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
                
            $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
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
                $ruta = '../images/auspiciantes/'.$new_file_name;
                move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
                    
                $ruta = substr($ruta, 3);
                $query_ins = "INSERT INTO auspiciantes (nombre, url_img, cod_pais, link) value ('{$nombre}', '{$ruta}', '{$cod_pais}', '{$link}')";
                $respuesta = $mysqli->query($query_ins);
                
                if($respuesta)
                {
                    header("Location: auspiciantes_edit.php?result=ok");
                    exit();
                }
                else
                {
                    header("Location: auspiciantes_edit.php?result=ko");
                    exit();
                }
            }
        }
    }
    exit();
}

if(isset($_GET['eliminarAuspiciante']))
{
    $result = $mysqli->query("SELECT url_img FROM auspiciantes WHERE id = {$_POST['id']}");

    $retorno = $result->fetch_assoc();

    if(file_exists("../".$retorno['url_img']))
    {
        unlink("../".$retorno['url_img']);
    }
    
    $query_del = 'DELETE FROM auspiciantes WHERE auspiciantes.id = ' . $_POST['id'];
    
    $respuesta = $mysqli->query($query_del);
                
    header("Location: auspiciantes_edit.php");
    exit();
}

if(isset($_GET['editarAuspiciante']))
{
    $nombre = $_POST['name'];
    $cod_pais = json_encode($_POST['pais']);
    $id_auspiciante = $_POST['id'];
    $link = $_POST['link'];
    
    if(isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '')
    {
        //if no errors...
        if(!$_FILES['photo']['error'])
        {
            $result = $mysqli->query("SELECT url_img FROM auspiciantes WHERE id = {$_POST['id']}");
            $retorno = $result->fetch_assoc();
            if(file_exists("../".$retorno['url_img']))
            {
                unlink("../".$retorno['url_img']);
            }
            
            //move it to where we want it to be
            $new_file_name = strtolower($_FILES['photo']['name']); //rename file
            $Length = 10;
            $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
            $new_file_name = $RandomString . "_" .  str_replace(' ', '-', $new_file_name);
            
            $ruta = '../images/auspiciantes/'.$new_file_name;
            move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
            $ruta = substr($ruta, 3);

            $mysqli->query("UPDATE auspiciantes SET url_img = '{$ruta}' WHERE id = {$_POST['id']}");
        }
    }
    
    $mysqli->query("UPDATE auspiciantes SET nombre = '{$nombre}', cod_pais = '{$cod_pais}', link = '{$link}' WHERE id = {$_POST['id']}");
    
    header("Location: auspiciantes_edit.php");
    exit();
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