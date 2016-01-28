<?php

session_start();

include_once 'includes/db_connect.php';

include_once 'includes/functions.php';

include_once 'includes/lenguaje.php';



error_reporting(E_ALL ^ E_NOTICE);



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

                $filiales_2['options'][]=$row;

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

        $cod_comision="";

        $cod_plan="";

        $coursecontact="";

        if(isset($_POST['tipo']) && $_POST['tipo'] != 0){

            if($_POST['tipo'] == '3'){

                $asunto = $lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']];

                if($_POST['coursecontact']){

                    $cod_comision = $_POST['id_comision'];

                    $cod_plan = $_POST['id_plan'];

                    $coursecontact = "true";

                }

            }else{

                $asunto = $lenguaje['atencion_alumno_'.$_SESSION['idioma_seleccionado']['cod_idioma']];

            }



            if(isset($_POST['filial']) && isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['phone']) && $_POST['phone'] != '' && isset($_POST['message']) && $_POST['message'] != ''){

                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

                    //if(filter_var($_POST['phone'], FILTER_VALIDATE_INT)){

                        if(isset($_POST['g-recaptcha-response'])){

                            if($_POST['g-recaptcha-response'] != ''){

                                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfcUBQTAAAAAFSH6B9p7l8p6-rm2aJO4Ij-PqhJ&response=".$_POST['g-recaptcha-response']);

                                $response = json_decode($response, true);

                                if($response["success"] === true){

                                    guardarConsultaCurso($mysqli,$_POST['filial'], $_POST['email'], $_POST['nombre'], $_POST['phone'], $asunto, $_POST['tipo'], $_POST['message'], $_POST['cod_curso'], $coursecontact, $cod_comision, $cod_plan);

                                    $retorno = array("success" => true, "mensaje" => $lenguaje['consulta_enviada_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                                }else{

                                    $retorno = array("success" => false, "mensaje" => $lenguaje['captcha_no_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                                }

                            }else{

                                $retorno = array("success" => false, "mensaje" => $lenguaje['captcha_no_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                            }

                        }else{

                            if(isset($_POST['recaptcha']) && $_POST['recaptcha'] != ''){

                                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfcUBQTAAAAAFSH6B9p7l8p6-rm2aJO4Ij-PqhJ&response=".$_POST['recaptcha']);

                                $response = json_decode($response, true);

                                if($response["success"] === true){

                                    guardarConsultaCurso($mysqli,$_POST['filial'], $_POST['email'], $_POST['nombre'], $_POST['phone'], $asunto, $_POST['tipo'], $_POST['message'], $_POST['cod_curso'], $coursecontact, $cod_comision, $cod_plan);

                                    $retorno = array("success" => true, "mensaje" => $lenguaje['consulta_enviada_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                                }else{

                                    $retorno = array("success" => false, "mensaje" => $lenguaje['captcha_no_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                                }

                            }else{

                                $retorno = array("success" => false, "mensaje" => $lenguaje['captcha_no_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                            }

                        }

                    /*}else{

                        $retorno = array("success" => false, "mensaje" => $lenguaje['tel_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                    } */

                }else{

                    $retorno = array("success" => false, "mensaje" => $lenguaje['mail_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                }

            }else{

                $retorno = array("success" => false, "mensaje" => $lenguaje['faltan_datos_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

            }

        }else{

            $retorno = array("success" => false, "mensaje" => $lenguaje['seleccion_opcion_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

        }

        print(json_encode($retorno));

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

                $retorno['id'] = $mysqli->insert_id;

                $retorno['cuatrimestre'] = $_POST['cuatrimestre'];

                $retorno['materia'] = $_POST['materia'];



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



    case "get_cursos_con_cupo":

        if(isset($_POST['id_filial']) && $_POST['id_filial'] != '' && isset($_POST['cod_curso']) && $_POST['cod_curso'] != ''){

            $cod_pais = "ar";

            switch($_SESSION['pais']['cod_pais']){

                case "BR":

                    $cod_pais = "br";

                break;

                case "UR":

                    $cod_pais = "uy";

                break;

                case "PR":

                    $cod_pais = "py";

                break;

                case "BO":

                    $cod_pais = "bo";

                break;

                case "PA":

                    $cod_pais = "pa";

                break;

                case "US":

                    $cod_pais = "us";

                break;

            }



            $curso_cupo = getCursoConCupo($_POST['id_filial'], $_POST['cod_curso']);

            if(count($curso_cupo) > 0)
            {
                $texto = $lenguaje['planilla_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                $head = "<tr><th colspan='9' class='text-center'>{$texto}</th></tr>";
                
                $retorno = "<tr>

                                <th>".$lenguaje['malla_fecha_in_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</th>

                                <th>".$lenguaje['malla_horarios_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</th>

                                <th>".$lenguaje['malla_matricula_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</th>

                            </tr>";

                foreach($curso_cupo as $id=>$datos_curso){

                    // Obtenemos las vacantes reales de la comision

                    $vacante = $datos_curso['cupo'] - $datos_curso['inscriptos'];
                    $fechaInicio = ' - ';
                    if($datos_curso['inicio_clases'] != '' && $datos_curso['inicio_clases'] != '1969-12-31')
                    {
                        $fechaInicio = $datos_curso['inicio_clases'];
                        if($cod_pais != "us")
                        {
                            $fechaInicio = date("d/m/Y", strtotime($datos_curso['inicio_clases']));
                        }
                    }
                    $retorno .="<tr>


                        <td>{$fechaInicio}</td>";

                    if(isset($datos_curso['horarios']) && is_array($datos_curso['horarios'])){

                        $dias = array(

                            "1"=>$lenguaje['lunes_'.$_SESSION['idioma_seleccionado']['cod_idioma']],

                            "2"=>$lenguaje['martes_'.$_SESSION['idioma_seleccionado']['cod_idioma']],

                            "3"=>$lenguaje['miercoles_'.$_SESSION['idioma_seleccionado']['cod_idioma']],

                            "4"=>$lenguaje['jueves_'.$_SESSION['idioma_seleccionado']['cod_idioma']],

                            "5"=>$lenguaje['viernes_'.$_SESSION['idioma_seleccionado']['cod_idioma']],

                            "6"=>$lenguaje['sabado_'.$_SESSION['idioma_seleccionado']['cod_idioma']],

                            "7"=>$lenguaje['domingo_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);



                        $retorno .= "<td>";

                        foreach($datos_curso['horarios'] as $horarios){

                            $retorno .= $dias[$horarios['dia']]." de ".substr($horarios['horadesde'], 0, 5)." a ".substr($horarios['horahasta'], 0, 5)." hs.<br/>";

                        }

                        $retorno .= "</td>";

                    }

                    $retorno .= "<td>\${$datos_curso['valormatricula']}</td>";
                    
                    $retorno .= "<tr>
                                    <th>".$lenguaje['malla_cuotas_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</th>

                                    <th>".$lenguaje['malla_vigencia_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</th>

                                    <th>".$lenguaje['malla_cupos_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</th>

                                <tr>";

                        if(isset($datos_curso['detalle_cuotas']) && is_array($datos_curso['detalle_cuotas'])){

                            $retorno .= "<td>";

                            foreach($datos_curso['detalle_cuotas'] as $cuotas){

                                $retorno .= $lenguaje['malla_cuotas_'.$_SESSION['idioma_seleccionado']['cod_idioma']]." ".$cuotas['cuota_inicio'].$lenguaje['a_'.$_SESSION['idioma_seleccionado']['cod_idioma']].$cuotas['cuota_fin']." <b> $".$cuotas['valor']."</b><br/><br/>";

                            }

                            $retorno .= "</td>";

                        }
                    $fechaVigencia = ' - ';
                    if($datos_curso['fechavigencia'] != '' && $datos_curso['fechavigencia'] != '1969-12-31')
                    {
                        $fechaVigencia = $datos_curso['fechavigencia'];
                        if($cod_pais != "us")
                        {
                            $fechaVigencia = date("d/m/Y", strtotime($datos_curso['fechavigencia']));
                        }
                    }    
                    $retorno .= "<td>{$fechaVigencia}</td>

                        <td>{$vacante}</td>

                    </tr>
                    <tr>
                        <td colspan=3>

                            <button type='button' data-toggle='collapse' data-target='#reserva-{$datos_curso['codigo']}' class='btn btn-success' onclick='javascript:ocultarDivConsulta({$datos_curso['codigo']})'>".$lenguaje['malla_boton_reserva_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</button>

                            <button type='button' data-toggle='collapse' data-target='#consulta-{$datos_curso['codigo']}' class='btn btn-info' onclick='javascript:ocultarDivReserva({$datos_curso['codigo']})'>".$lenguaje['malla_boton_consulta_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</button>

                        </td>
                    </tr>
                    <tr>

                        <td colspan='9' class='hiddenRow'>
                        
                        <div class='accordian-body collapse' id='reserva-{$datos_curso['codigo']}'>
                        <div class='text-center'><h4>".$lenguaje['enviar_reserva_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</h4><br></div>";
                        

                    $retorno .= '<form id="form-reserva-'.$datos_curso['codigo'].'" name="form-reserva-'.$datos_curso['codigo'].'" method="post" action="#">

                                    <input type="hidden" name="id_comision" value="'.$datos_curso['codigo'].'" />

                                    <input type="hidden" name="id_filial" value="'.$_POST['id_filial'].'" />

                                    <input type="hidden" name="id_plan" value="'.$datos_curso['id_plan'].'" />

                                    <div class="row">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="text" name="name" id="name" class="form-control" placeholder="'.$lenguaje['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required" />

                                            </div>

                                            <div class="form-group">

                                                <input type="email" name="email" id="email" class="form-control" placeholder="'.$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required" />

                                            </div>

                                            <div class="form-group">

                                                <input type="tel" id="telefono-'.$datos_curso['codigo'].'" name="telefono" class="form-control" required="required" />

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            '.$lenguaje['reserva_curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'

                                            <br/>

                                            <br/>

                                            <div class="recaptcha" id="captcha-reserva-'.$datos_curso['codigo'].'"></div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <button type="button" class="btn btn-sm" onclick="reservarCupo(\'form-reserva-'.$datos_curso['codigo'].'\', this, \'error-'.$datos_curso['codigo'].'\')" data-loading-text="'.$lenguaje['enviando_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'">'.$lenguaje['malla_boton_reserva_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'</button>

                                        <button type="button" data-toggle="collapse" data-target="#reserva-'.$datos_curso['codigo'].'" class="btn btn-sm">'.$lenguaje['boton_cerrar_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'</button>

                                        &nbsp;&nbsp;<span id="error-'.$datos_curso['codigo'].'" class="error text-center text-consulta-error"></span>

                                        <br/>

                                    </div>

                                </form>';



                    $retorno .="</div>

                        <div class='accordian-body collapse' id='consulta-{$datos_curso['codigo']}'>
                            <div class='text-center'><h4>".$lenguaje['enviar_consulta_'.$_SESSION['idioma_seleccionado']['cod_idioma']]."</h4><br></div>";
                    $retorno .= '<form id="form-contacto-'.$datos_curso['codigo'].'" name="form-contacto-'.$datos_curso['codigo'].'" method="post" action="#">

                                    <input type="hidden" name="id_comision" value="'.$datos_curso['codigo'].'" />

                                    <input type="hidden" name="id_filial" value="'.$_POST['id_filial'].'" />

                                    <input type="hidden" name="id_plan" value="'.$datos_curso['id_plan'].'" />

                                    <input type="hidden" name="cod_curso" value="'.$_POST['cod_curso'].'" />

                                    <div class="row">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="text" name="name" class="form-control" placeholder="'.$lenguaje['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required" />

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="text" name="email" class="form-control" placeholder="'.$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <input type="tel" name="phone" id="phone-'.$datos_curso['codigo'].'" class="form-control" required="required" />

                                    </div>

                                    <div class="form-group">

                                        <textarea name="mensaje" class="form-control" rows="4" placeholder="'.$lenguaje['mensaje_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required"></textarea>

                                    </div>

                                    <div class="form-group">

                                        <div class="recaptcha" id="captcha-consulta-'.$datos_curso['codigo'].'"></div><br/><br/>

                                        <button type="button" class="btn btn-sm" onclick="consultarCurso(\'form-contacto-'.$datos_curso['codigo'].'\', this, true, \'error-cons-'.$datos_curso['codigo'].'\')" data-loading-text="'.$lenguaje['enviando_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'">'.$lenguaje['malla_boton_consulta_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'</button>

                                        <button type="button" data-toggle="collapse" data-target="#consulta-'.$datos_curso['codigo'].'" class="btn btn-sm" >'.$lenguaje['boton_cerrar_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'</button>

                                        &nbsp;&nbsp;<span id="error-cons-'.$datos_curso['codigo'].'" class="error text-center text-consulta-error"></span>

                                    </div>

                                </form>

                                <script>

                                    $("#telefono-'.$datos_curso['codigo'].'").intlTelInput({

                                        onlyCountries: ["ar", "br", "uy", "py", "bo", "pa", "us"],

                                        preferredCountries: [],

                                        utilsScript: "js/phoneValidation/utils.js"

                                    });

                                    $("#telefono-'.$datos_curso['codigo'].'").intlTelInput("setCountry", "'.$_SESSION['pais']['cod_pais'].'");



                                    $("#phone-'.$datos_curso['codigo'].'").intlTelInput({

                                        onlyCountries: ["ar", "br", "uy", "py", "bo", "pa", "us"],

                                        preferredCountries: [],

                                        utilsScript: "js/phoneValidation/utils.js"

                                    });

                                    $("#phone-'.$datos_curso['codigo'].'").intlTelInput("setCountry", "'.$_SESSION['pais']['cod_pais'].'");

                                </script>';



                    $retorno .="</div>

                        </td>

                    </tr>";

                }

                $retorno .= '<script>

                    var CaptchaCallback = function(){

                        $(".recaptcha").each(function(index, val) {

                            grecaptcha.render(val.id, {"sitekey" : "6LfcUBQTAAAAAA6cg2CaCnnZzxbxNnIOawZwo2KJ"});

                        });

                    };

                </script>

                <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>

                ';

            }else{
                
                $texto = $lenguaje['contacto_'.$_SESSION['pais']['cod_pais'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                $head = "<tr><th colspan='9' class='text-center'>{$texto}</th></tr>";
                
                $retorno .= '<tr>

                            <td>

                            <form id="form-contacto" name="form-contacto" method="post" action="#">

                                    <input type="hidden" name="id_comision" value="0" />

                                    <input type="hidden" name="id_filial" value="'.$_POST['id_filial'].'" />

                                    <input type="hidden" name="id_plan" value="0" />

                                    <input type="hidden" name="cod_curso" value="'.$_POST['cod_curso'].'" />

                                    <div class="row">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="text" name="name" class="form-control" placeholder="'.$lenguaje['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required" />

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <input type="text" name="email" class="form-control" placeholder="'.$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required" />

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <input type="tel" name="phone" id="phone" class="form-control" required="required" />

                                    </div>

                                    <div class="form-group">

                                        <textarea name="mensaje" class="form-control" rows="4" placeholder="'.$lenguaje['mensaje_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'" required="required"></textarea>

                                    </div>

                                    <div class="form-group">

                                        <div class="recaptcha" id="captcha-consulta-sin-cupo"></div><br/><br/>

                                        <button type="button" class="btn btn-sm" onclick="consultarCurso(\'form-contacto\', this, false, \'error\')" data-loading-text="'.$lenguaje['enviando_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'">'.$lenguaje['malla_boton_consulta_'.$_SESSION['idioma_seleccionado']['cod_idioma']].'</button>

                                        &nbsp;&nbsp;<span id="error" class="error text-center text-consulta-error"></span>

                                    </div>

                                </form>

                            </td>

                        </tr>

                        <script>

                            $("#phone").intlTelInput({

                                onlyCountries: ["ar", "br", "uy", "py", "bo", "pa", "us"],

                                preferredCountries: [],

                                utilsScript: "js/phoneValidation/utils.js"

                            });



                            $("#phone").intlTelInput("setCountry", "'.$_SESSION['pais']['cod_pais'].'");



                            var CaptchaCallback = function(){

                                grecaptcha.render("captcha-consulta-sin-cupo", {"sitekey" : "6LfcUBQTAAAAAA6cg2CaCnnZzxbxNnIOawZwo2KJ"});

                            };

                        </script>

                        <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>

                        ';

            }

        }

        $respuesta = array("tabla"=>$retorno, "head"=>$head);
        echo(json_encode($respuesta));

    break;



    case "reserva_cupo":

        $result = array();

        if(isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['email']) && isset($_POST['telefono']) && $_POST['telefono'] != '' && isset($_POST['id_comision']) && isset($_POST['id_filial']) && isset($_POST['id_plan'])){

            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

                if(isset($_POST['recaptcha']) && $_POST['recaptcha'] != ''){

                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfcUBQTAAAAAFSH6B9p7l8p6-rm2aJO4Ij-PqhJ&response=".$_POST['recaptcha']);

                    $response = json_decode($response, true);

                    if($response["success"] === true){

                        reservaInscripcion($_POST['nombre'], $_POST['email'], $_POST['telefono'], $_POST['id_comision'], $_POST['id_filial'], $_POST['id_plan']);

                        $retorno = array("success" => true, "mensaje" => $lenguaje['consulta_enviada_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                    }else{

                        $retorno = array("success" => false, "mensaje" => $lenguaje['captcha_no_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                    }

                }else{

                    $retorno = array("success" => false, "mensaje" => $lenguaje['captcha_no_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

                }

            }else{

                $retorno = array("success" => false, "mensaje" => $lenguaje['mail_valido_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

            }

        }else{

            $retorno = array("success" => false, "mensaje" => $lenguaje['faltan_datos_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);

        }



        print(json_encode($retorno));

    break;

}



?>


