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
                guardarConsultaCurso($mysqli,$_POST['filial'], $_POST['email'], $_POST['nombre'], $_POST['phone'], $asunto, $_POST['tipo'], $_POST['message'], $_POST['cod_curso'], $coursecontact, $cod_comision, $cod_plan);
                $retorno = array("success" => true, "mensaje" => $lenguaje['consulta_enviada_'.$_SESSION['idioma_seleccionado']['cod_idioma']]);
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
            $retorno = "<tr>
                            <td>Comision</td>
                            <td>Inicio</td>
                            <td>Dias y Horarios</td>
                            <td>Matricula</td>
                            <td>Cuotas</td>
                            <td>Vigencia</td>
                            <td>Cupos</td>
                            <td>&nbsp;</td>
                        <tr>";
            $curso_cupo = getCursoConCupo($_POST['id_filial'], $_POST['cod_curso']);
            foreach($curso_cupo as $id=>$datos_curso){
                $retorno .="<tr>
                    <td>{$datos_curso['codigo']}</td>
                    <td>{$datos_curso['inicio_clases']}</td>";
                if(isset($datos_curso['horarios']) && is_array($datos_curso['horarios'])){
                    $dias = array("1"=>"Lunes", "2"=>"Martes", "3"=>"Miércoles", "4"=>"Jueves", "5"=>"Viernes", "6"=>"Sábado", "7"=>"Domingo");
                    $retorno .= "<td>";
                    foreach($datos_curso['horarios'] as $horarios){
                        $retorno .= $dias[$horarios['dia']]." de ".substr($horarios['horadesde'], 0, 5)." a ".substr($horarios['horahasta'], 0, 5)." hs.<br/>";
                    }
                    $retorno .= "</td>";
                }
                $retorno .= "<td>\${$datos_curso['valormatricula']}</td>";
                    if(isset($datos_curso['detalle_cuotas']) && is_array($datos_curso['detalle_cuotas'])){
                        $retorno .= "<td>";
                        foreach($datos_curso['detalle_cuotas'] as $cuotas){
                            $retorno .= "Cuotas ".$cuotas['cuota_inicio']." a ".$cuotas['cuota_fin']."&nbsp;&nbsp;<b>$".$cuotas['valor']."</b><br/>";
                        }
                        $retorno .= "</td>";
                    }
                $retorno .= "<td>{$datos_curso['fechavigencia']}</td>
                    <td>{$datos_curso['cupo']}</td>
                    <td>
                        <button type='button' data-toggle='collapse' data-target='#reserva-{$datos_curso['codigo']}' class='btn btn-sm accordion-toggle' onclick='javascript:ocultarDivConsulta({$datos_curso['codigo']})'>Reservar</button>
                        <br/><br/>
                        <button type='button' data-toggle='collapse' data-target='#consulta-{$datos_curso['codigo']}' class='btn btn-sm accordion-toggle' onclick='javascript:ocultarDivReserva({$datos_curso['codigo']})'>Consultar</button>
                    </td>
                </tr>
                <tr>
                    <td colspan='9' class='hiddenRow'>
                    <div class='accordian-body collapse' id='reserva-{$datos_curso['codigo']}'>";
                $retorno .= '<form id="form-reserva-'.$datos_curso['codigo'].'" name="form-reserva-'.$datos_curso['codigo'].'" method="post" action="#">
                                <input type="hidden" name="id_comision" value="'.$datos_curso['codigo'].'" />
                                <input type="hidden" name="id_filial" value="'.$_POST['id_filial'].'" />
                                <input type="hidden" name="id_plan" value="'.$datos_curso['id_plan'].'" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Dirección de Email" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required="required">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        *Su reserva caduca 48 horas después de haber realizado esta operación.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm" onclick="reservarCupo(\'form-reserva-'.$datos_curso['codigo'].'\', this)" data-loading-text="Reservando...">Reservar Lugar</button>
                                    <button type="button" data-toggle="collapse" data-target="#reserva-'.$datos_curso['codigo'].'" class="btn btn-sm accordion-toggle">Cerrar</button>
                                </div>
                                <div class="error text-center text-reserva-error"></div>
                            </form>';
                
                $retorno .="</div>
                    <div class='accordian-body collapse' id='consulta-{$datos_curso['codigo']}'>";
                $retorno .= '<form id="form-contacto-'.$datos_curso['codigo'].'" name="form-contacto-'.$datos_curso['codigo'].'" method="post" action="#">
                                <input type="hidden" name="id_comision" value="'.$datos_curso['codigo'].'" />
                                <input type="hidden" name="id_filial" value="'.$_POST['id_filial'].'" />
                                <input type="hidden" name="id_plan" value="'.$datos_curso['id_plan'].'" />
                                <input type="hidden" name="cod_curso" value="'.$_POST['cod_curso'].'" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Nombre" required="required" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" placeholder="Dirección de Email" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Teléfono" required="required">
                                </div>
                                <div class="form-group">
                                    <textarea name="mensaje" class="form-control" rows="4" placeholder="Ingrese su mensaje" required="required"></textarea>
                                </div>                        
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm" onclick="consultarCurso(\'form-contacto-'.$datos_curso['codigo'].'\', this)" data-loading-text="Consultando...">Consultar</button>
                                    <button type="button" data-toggle="collapse" data-target="#consulta-'.$datos_curso['codigo'].'" class="btn btn-sm accordion-toggle" >Cerrar</button>
                                </div>
                                <div class="error text-center text-consulta-error"></div>
                            </form>';
                
                $retorno .="</div>
                    </td>
                </tr>";
            }
        }else{
            
        }
        
        print($retorno);
    break;
    
    case "reserva_cupo":
        $result = array();
        if(isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['telefono']) && isset($_POST['id_comision']) && isset($_POST['id_filial']) && isset($_POST['id_plan'])){
            $result = reservaInscripcion($_POST['nombre'], $_POST['email'], $_POST['telefono'], $_POST['id_comision'], $_POST['id_filial'], $_POST['id_plan']);
        }else{
            $result = array("success"=>false, "error"=>"Faltan datos.");
        }
        
        print(json_encode($result));
        
    break;
}

?>
