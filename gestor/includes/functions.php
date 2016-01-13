<?php
include_once 'psl-config.php';
include_once 'db_connect.php';
include_once 'webservice/wsc_sistema.php';
include_once 'webservice/webServices.php';
 
function getDatosCurso($mysqli, $cod_curso, $id_idioma='', $id_filial=''){
    $query1 = "SELECT cfi.id, cfi.estado FROM curso_filial_idioma as cfi 
            WHERE 
                cfi.cod_curso=".$cod_curso." 
            AND 
                cfi.id_filial=".$id_filial." 
            AND 
                cfi.id_idioma=".$id_idioma;
    $qry_cpi = $mysqli->query($query1);
    $res_cpif = $qry_cpi->fetch_assoc();
    
    if($qry_cpi->num_rows > 0){
        $query2 = "select * from curso_datos WHERE id_cfi=".$res_cpif['id'];
        $qry_datos = $mysqli->query($query2);
        $datos_curso = $qry_datos->fetch_assoc();
        $datos_curso['estado'] = $res_cpif['estado'];
        if($qry_datos)$qry_datos->free();
        
        $query3 = "select * from malla_curricular WHERE id_curso_filial_idioma = " . $res_cpif['id'];
        $qry_malla = $mysqli->query($query3);
        $datos_curso['malla_curricular'] = array();
        while ($datos_malla = $qry_malla->fetch_assoc())
        {
            $datos_curso['malla_curricular'][] = $datos_malla;
        }
        if($qry_malla)$qry_malla->free();
        
        $query4 = "SELECT color FROM cursos WHERE cod_curso = ".$cod_curso;
        $qry_color = $mysqli->query($query4);
        $color = $qry_color->fetch_assoc();
        $datos_curso['color'] = $color['color'];
        if($qry_color)$qry_color->free();
        
        return $datos_curso;
    }else{
        return "No existen datos para la filial e idiomas seleccionados.";
    }
    if($qry_cpi)$qry_cpi->free();
    
    /*$cabecera = getCabecera($mysqli, $id_curso, $id_pais, $id_idioma);
    
    $query = "SELECT url_uniforme, url_material, desc_uniforme, desc_material, duracion, plan_estudio FROM curso_datos WHERE id_curso_pais_idioma=".$cabecera['id']." AND id_filial=".$id_filial;
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    
    return $respuesta;*/
}

function getIdiomas($mysqli, $id_idioma = false, $id_pais = false)
{
    $cond = ' WHERE 1 = 1';
    
    if($id_idioma && !$id_pais)
    {
        $cond .= ' AND id = ' . $id_idioma;
    }
    
    if($id_pais && !$id_idioma)
    {
        $cond .= ' AND id IN (select id_idioma from pais_idioma WHERE id_pais = ' . $id_pais . ')';
    }
    
    $query = "SELECT id, idioma, cod_idioma FROM idiomas {$cond}";
    $resultado = $mysqli->query($query);
    $idiomas = array();
    while($respuesta = $resultado->fetch_assoc())
    {
        $idiomas[] = $respuesta;
    }
    if($resultado)$resultado->free();
    
    return $idiomas;
}

function getCursos($mysqli, $cod_curso = '')
{
    $cond = ' WHERE activo=1 ';
    
    if(isset($cod_curso) && $cod_curso != ''){
        $cond .= ' AND cod_curso = '.$cod_curso.' ';
    }

    $resultado = $mysqli->query("SELECT * FROM cursos {$cond} ORDER BY nombre_es");
    $cursos = array();

    while($respuesta = $resultado->fetch_assoc())
    {
        $cursos[] = $respuesta;
    }
    if($resultado)$resultado->free();
    
    return $cursos;
}

/*function getCursoPais($mysqli, $cod_curso=''){
    $cond = '';
    if(isset($cod_curso) && $cod_curso != ''){
	$cond = ' WHERE cp.cod_curso='.$cod_curso;
    }
    $cursos_paises = array();
    $result = $mysqli->query("SELECT p.id, p.pais FROM curso_pais as cp INNER JOIN paises as p ON p.id=cp.id_pais ".$cond);
    while($c_p = $result->fetch_assoc()){
	$cursos_paises[] = array('id'=>$c_p['id'], 'pais'=>$c_p['pais']);
    }
    if($result)$result->free();
    
    return $cursos_paises;
}*/


function getPais($mysqli, $cod_pais){
    $query = "SELECT id, pais, cod_pais, flag FROM paises WHERE cod_pais='".$cod_pais."'";
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    if($resultado)$resultado->free();
    
    return $respuesta;
}

function getPaises($mysqli){
    $paises = array();
    $result = $mysqli->query("SELECT id, pais, cod_pais, flag FROM paises");
    while($pais = $result->fetch_assoc()){
	$paises[] = array('id'=>$pais['id'],'pais'=>$pais['pais'],'cod_pais'=>$pais['cod_pais'], 'flag'=>$pais['flag']);
    }
    return $paises;
}

function getAuspiciantes($mysqli, $cod_pais = false){
    $auspiciantes = array();
    $query = "SELECT id, nombre, url_img, cod_pais, link FROM auspiciantes";
    
    if($cod_pais)
    {
        $query .= " WHERE cod_pais = " . $cod_pais;
    }
    
    $result = $mysqli->query($query);
    while($auspiciante = $result->fetch_assoc())
    {
	$auspiciantes[] = array('id'=>$auspiciante['id'],'nombre'=>$auspiciante['nombre'], 'url_img'=>$auspiciante['url_img'],'cod_pais'=>json_decode($auspiciante['cod_pais']), 'link'=>$auspiciante['link']);
    }
    return $auspiciantes;
}

function getIdiomasPais($mysqli, $id_pais=''){
    $cond='';
    if(isset($id_pais) && $id_pais != ''){
        $cond = ' WHERE id_pais='.$id_pais;
    }
    $idiomas_pais = array();
    $result = $mysqli->query("SELECT i.id, i.idioma FROM pais_idioma as pi INNER JOIN idiomas as i ON i.id=pi.id_idioma {$cond}");
    while($idioma = $result->fetch_assoc()){
	$idiomas_pais[] = array('id'=>$idioma['id'],'idioma'=>$idioma['idioma']);
    }
    return $idiomas_pais;
}

function getProvincias($mysqli, $id_pais=''){
    $cond = '';
    if(isset($id_pais) && $id_pais != ''){
        $cond .= ' WHERE id_pais='.$id_pais;
    }
    
    $provincias = array();
    $query = "SELECT p.id, p.nombre FROM filiales as f INNER JOIN provincias AS p ON p.id=f.id_provincia {$cond} GROUP BY p.id ORDER BY p.nombre";
    //$query = "SELECT id, nombre FROM provincias ".$cond;
    $result = $mysqli->query($query);
    while($prov = $result->fetch_assoc()){
	$provincias[] = array('id'=>$prov['id'],'nombre'=>$prov['nombre']);
    }
    return $provincias;
}

function getProvinciaFromFilial($mysqli, $id_filial){
    $query = "SELECT id_provincia FROM filiales WHERE id={$id_filial}";
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    if($resultado)$resultado->free();
    
    return $respuesta;
}

function getFiliales($mysqli, $id_provincia='', $id_pais=''){
    $cond = '';
    if(isset($id_provincia) && $id_provincia != ''){
        $cond .= ' WHERE id_provincia='.$id_provincia;
    }
    
    $filiales = array();
    $result = $mysqli->query("SELECT id, nombre, id_localidad FROM filiales {$cond}");
    while($filial = $result->fetch_assoc()){
	$filiales[] = array('id'=>$filial['id'],'nombre'=>$filial['nombre'],'id_localidad'=>$filial['id_localidad']);
    }
    return $filiales;
}

/*function setChanges($mysqli, $id_curso, $color){
    $resultado = $mysqli->query("UPDATE cursos SET color='".$color."' WHERE id = ".$id_curso);
    if($resultado){
		return true;
	}else{
		return false;
	}
	$resultado->free();
}*/

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],$cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}


function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function detectCountry($mysqli, $cod_pais=''){
    /*$url = "http://ipinfo.io/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);*/
    
    //Con esta opcion almaceno el resultado en una variable
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //session_start();
    
    if(isset($cod_pais) && $cod_pais != ''){
        $pais = $cod_pais;
    }else{
        // Usamos la API de GEO plugin + mas el header TTP_X_FORWARDED_FOR
        $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.getClientIP()));
        $pais = $data['geoplugin_countryCode'];
    }
    
    if($pais)
    {
        //$resp = json_decode(curl_exec($ch));
        $cod_pais = $pais; //$resp->country;
        $query = "SELECT id, pais, flag FROM paises WHERE cod_pais='{$cod_pais}'";
        
        $result = $mysqli->query($query);
        $tablaPaisdatos = $result->fetch_assoc();
        
        $tablaPais = array('id'=>$tablaPaisdatos['id'], 'cod_pais'=>$cod_pais, 'pais'=>$tablaPaisdatos['pais'],'flag'=>$tablaPaisdatos['flag']);
        
        if($cod_pais != 'us'){
            $query2 = "SELECT id, idioma, cod_idioma FROM idiomas WHERE idiomas.id = (select id_idioma from pais_idioma where pais_idioma.id_pais = {$tablaPaisdatos['id']})";
            $result2 = $mysqli->query($query2);
            $idioma = $result2->fetch_assoc();
            $idioma_sel = $idioma['idioma'];
        }else{
            $idioma = array("id"=>"2", "idioma"=>"Ingles", "cod_idioma"=>"IN");
            $idioma_sel = "Ingles";
        }
        
        $_SESSION['pais'] = array('id'=>$tablaPais['id'],
                                  'cod_pais'=>$tablaPais['cod_pais'], 
                                  'pais'=>$tablaPais['pais'],
                                  'flag'=>$tablaPais['flag'],
                                  'idioma'=>$idioma_sel,
                                  'cod_idioma'=>$idioma['cod_idioma'],
                                  'id_idioma'=>$idioma['id']);
    }
    else
    {
        $_SESSION['pais'] = array('pais'=>'Argentina','cod_pais'=>"AR", 'idioma'=>'ES', 'flag'=>'images/flags/ar.png', 'id_idioma'=>'1', 'cod_idioma'=>'ES', 'id'=>'1');
        $_SESSION['ciudad'] = 'Rosario';
    }
    //curl_close($ch);
}

function getClientIP(){

     if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
            return  $_SERVER["HTTP_X_FORWARDED_FOR"];  
        }else if (array_key_exists('REMOTE_ADDR', $_SERVER)) { 
            return $_SERVER["REMOTE_ADDR"]; 
        }else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            return $_SERVER["HTTP_CLIENT_IP"]; 
        } 

        return '';

    }

function getImagenesGrilla($mysqli, $idioma = false, $id_pais = false, $habilitado_filtro = 3, $id_curso_filtro = false)
{
    $query = "SELECT * FROM grilla WHERE 1 = 1"; 
    
    if($habilitado_filtro != 3)
    {
        $query .= " AND grilla.habilitado = '{$habilitado_filtro}'";
    }
    if($idioma)
    {
        $query .= " AND grilla.idioma = '{$idioma}' ";
    }
    if($id_curso_filtro)
    {
        $query .= " AND grilla.cod_curso='{$id_curso_filtro}'";
    }
    
    $query .= " order by grilla.prioridad, grilla.idioma";
//    die($query);
    $result = $mysqli->query($query);
    
    $retorno = array();
    if($result->num_rows > 0)
    {
        while($grilla = $result->fetch_assoc())
        {
            $arrayPaises = json_decode($grilla['id_pais']);
            if(!$id_pais)
            {    
                $retorno[] = array( 'id'=>$grilla['id'],
                                'img_url'=>$grilla['img_url'],
                                'thumb_url'=>$grilla['thumb_url'],
                                'id_curso'=>$grilla['cod_curso'],
                                'prioridad'=>$grilla['prioridad'],
                                'idioma'=>$grilla['idioma'],
                                'id_pais'=> $arrayPaises,
                                'titulo'=>$grilla['titulo'],
                                'desc'=>$grilla['descripcion'],
                                'habilitado'=>$grilla['habilitado']);
            }
            else if(in_array($id_pais, $arrayPaises))
            {
                $retorno[] = array( 'id'=>$grilla['id'],
                                'img_url'=>$grilla['img_url'],
                                'thumb_url'=>$grilla['thumb_url'],
                                'id_curso'=>$grilla['cod_curso'],
                                'prioridad'=>$grilla['prioridad'],
                                'idioma'=>$grilla['idioma'],
                                'id_pais'=> $arrayPaises,
                                'titulo'=>$grilla['titulo'],
                                'desc'=>$grilla['descripcion'],
                                'habilitado'=>$grilla['habilitado']);
            }
        }
        return $retorno;
    }
    else
    {
        return false;
    }
}

function ws_insertPaises($mysqli){
    $message = '';
    $fp = fopen("../ws/paises.json","r");
    $linea= fgets($fp);

    $array_paises = json_decode($linea);

    foreach ($array_paises as $id=>$value){
        $query_sel = "SELECT id, pais FROM paises WHERE id={$value->id} AND pais='{$value->pais}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){
            $query_ins = "INSERT INTO paises SET id={$value->id}, pais='{$value->pais}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar el pais {$value->pais}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto el pais {$value->pais}<br/>";
            }
        }else{
            $message.= "<br/>Error - Ya existe el pais {$value->pais} con id {$value->id}<br/>";
        }
    }
    return $message;
}

function ws_insertProvincias($mysqli){
    /*$message = '';
    $fp_prov = fopen("../ws/provincias.json","r");
    $linea_prov = fgets($fp_prov);

    $array_prov = json_decode($linea_prov);*/
    
    $ws = new webServices();
    $array_prov = json_decode($ws->send('JSON_getProvincias'));

    foreach ($array_prov as $id=>$value){
        /*$query_sel = "SELECT id, nombre FROM provincias WHERE id={$value->id} AND nombre='{$value->nombre}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){*/
            $query_ins = "INSERT INTO provincias SET id={$value->id}, nombre='{$value->nombre}', id_pais={$value->pais}, codigo_estado='{$value->codigo_estado}', identificador_estado='{$value->identificador_estado}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar la provincia {$value->nombre}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto la provincia {$value->nombre}, pais: {$value->pais}<br/>";
            }
        /*}else{
            $message.= "<br/>Error - Ya existe la pronvincia {$value->nombre} con id {$value->id}<br/>";
        }*/
    }
    return $message;
}

function ws_insertLocalidades($mysqli){
    /*$message = '';
    $fp_loc = fopen("../ws/localidades.json","r");
    $linea_loc = fgets($fp_loc);

    $array_loc = json_decode($linea_loc);*/
    
    $ws = new webServices();
    $array_loc = json_decode($ws->send('JSON_getCiudades'));
    foreach ($array_loc as $id=>$value){
        /*$query_sel = "SELECT id, nombre FROM localidades WHERE id={$value->id} AND nombre='{$value->nombre}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){*/
            $query_ins = "INSERT INTO localidades SET id={$value->id}, departamento_id='{$value->departamento_id}', nombre='{$value->nombre}', id_provincia='{$value->provincia_id}', id_pais='{$value->pais}', codigo_municipio='{$value->codigo_municipio}', codigo_siafi='{$value->codigo_siafi}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar la localidad {$value->nombre}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto la localidad {$value->nombre}, prov: {$value->provincia_id}<br/>";
            }
        /*}else{
            $message.= "<br/>Error - Ya existe la localidad {$value->nombre} con id {$value->id}<br/>";
        }*/
    }
    return $message;
}

function ws_insertFiliales($mysqli){
    /*$message = '';
    $fp_filiales = fopen("../ws/filiales.json","r");
    $linea_filiales = fgets($fp_filiales);

    $array_filiales = json_decode($linea_filiales);*/
    
    $ws = new webServices();
    $array_filiales = json_decode($ws->send('JSON_getFiliales'));

    foreach ($array_filiales as $id=>$value){
        $res_prov = $mysqli->query("SELECT id_provincia FROM localidades WHERE id=".$value->id_localidad);
        if($res_prov){
            $prov = $res_prov->fetch_assoc();
        }else{
            $prov['id_provincia'] = 1111;
        }
        
        /*$query_sel = "SELECT id, nombre FROM filiales WHERE id={$value->codigo} AND nombre='{$value->nombre}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){*/
            $query_ins = "INSERT INTO filiales SET id={$value->codigo}, nombre='{$value->nombre}', id_localidad='{$value->id_localidad}', id_provincia='{$prov['id_provincia']}', domicilio='{$value->domicilio}', telefono='{$value->telefono}', telefono2='{$value->telefono2}', codigopostal='{$value->codigopostal}', email='{$value->email}', latitud='{$value->latitud}', longitud='{$value->longitud}', idioma='{$value->idioma}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar la filial {$value->nombre}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto la filial {$value->nombre}, prov: {$prov['id_provincia']}<br/>";
            }
        /*}else{
            $message.= "<br/>Error - Ya existe la filial {$value->nombre} con id {$value->id}<br/>";
        }*/
    }
    return $message;
}

function ws_insertCursos($mysqli,$cod_curso=""){
    $message = '';
    $ws = new webServices();
    $array_cursos = json_decode($ws->send('JSON_getCursos'));
    
    if(isset($cod_curso) && $cod_curso != ''){
        //print_r($array_cursos[22]);die();
        foreach ($array_cursos as $id=>$value){
            if($value->codigo == $cod_curso){
                $nombre_es = addslashes(trim($value->nombre_es));
                $nombre_portugues = addslashes(trim($value->nombre_portugues));
                $nombre_ingles = addslashes(trim($value->nombre_ingles));
                $descripcion = addslashes(trim($value->descripcion));
                $descripcion_por = addslashes(trim($value->descripcion_por));
                $descripcion_ing = addslashes(trim($value->descripcion_ing));
                $descripcion_corta_esp = addslashes(trim($value->descripcion_corta_esp));
                $descripcion_corta_por = addslashes(trim($value->descripcion_corta_por));
                $descripcion_corta_ing = addslashes(trim($value->descripcion_corta_ing));
                $descripcion_venta_esp = addslashes(trim($value->descripcion_venta_esp));
                $descripcion_venta_por = addslashes(trim($value->descripcion_venta_por));
                $descripcion_venta_ing = addslashes(trim($value->descripcion_venta_ing));
                $titulo_secundario_esp = addslashes(trim($value->titulo_secundario_esp));
                $titulo_secundario_por = addslashes(trim($value->titulo_secundario_por));
                $titulo_secundario_ing = addslashes(trim($value->titulo_secundario_ing));
                $query_ins = "INSERT INTO cursos (cod_curso, nombre_es, nombre_portugues, nombre_ingles, horas, meses, anios, color, logo, descripcion, descripcion_por, descripcion_ing, descripcion_corta_esp, descripcion_corta_por, descripcion_corta_ing, aniopertenece, activo, descripcion_venta_esp, descripcion_venta_por, descripcion_venta_ing, titulo_secundario_esp, titulo_secundario_por, titulo_secundario_ing, codfranquicia, id_subcategoria, id_categoria, tags) VALUES ('{$value->codigo}', '{$nombre_es}','{$nombre_portugues}','{$nombre_ingles}','{$value->canthoras}','{$value->cantmeses}','{$value->cantanios}','{$value->color}','{$value->logo}','{$descripcion}','{$descripcion_por}','{$descripcion_ing}','{$descripcion_corta_esp}','{$descripcion_corta_por}','{$descripcion_corta_ing}','{$value->aniopertenece}','{$value->activo}','{$descripcion_venta_esp}','{$descripcion_venta_por}','{$descripcion_venta_ing}','{$titulo_secundario_esp}','{$titulo_secundario_por}','{$titulo_secundario_ing}','{$value->codfranquicia}','{$value->id_subcategoria}','{$value->id_categoria}','{$value->tags}')";
                //echo $query_ins;
                $result_ins = $mysqli->query($query_ins);
                if(!$result_ins){
                    $message.= "<br/>Error - al insertar el curso {$value->nombre_es}<br/>";
                }else{
                    $message.= "<br/>Correcto - Se inserto el curso {$value->nombre_es}";
                }
            }
        }
    }else{
        foreach ($array_cursos as $id=>$value){
            if($value->activo == 1){
                $query_sel = "SELECT cod_curso, nombre_es FROM cursos WHERE cod_curso={$value->codigo}";
                $result_sel = $mysqli->query($query_sel);
                if($result_sel->num_rows == 0){
                    $nombre_es = addslashes(trim($value->nombre_es));
                    $nombre_portugues = addslashes(trim($value->nombre_portugues));
                    $nombre_ingles = addslashes(trim($value->nombre_ingles));
                    $descripcion = addslashes(trim($value->descripcion));
                    $descripcion_por = addslashes(trim($value->descripcion_por));
                    $descripcion_ing = addslashes(trim($value->descripcion_ing));
                    $descripcion_corta_esp = addslashes(trim($value->descripcion_corta_esp));
                    $descripcion_corta_por = addslashes(trim($value->descripcion_corta_por));
                    $descripcion_corta_ing = addslashes(trim($value->descripcion_corta_ing));
                    $descripcion_venta_esp = addslashes(trim($value->descripcion_venta_esp));
                    $descripcion_venta_por = addslashes(trim($value->descripcion_venta_por));
                    $descripcion_venta_ing = addslashes(trim($value->descripcion_venta_ing));
                    $titulo_secundario_esp = addslashes(trim($value->titulo_secundario_esp));
                    $titulo_secundario_por = addslashes(trim($value->titulo_secundario_por));
                    $titulo_secundario_ing = addslashes(trim($value->titulo_secundario_ing));
                    $query_ins = "INSERT INTO cursos (cod_curso, nombre_es, nombre_portugues, nombre_ingles, horas, meses, anios, color, logo, descripcion, descripcion_por, descripcion_ing, descripcion_corta_esp, descripcion_corta_por, descripcion_corta_ing, aniopertenece, activo, descripcion_venta_esp, descripcion_venta_por, descripcion_venta_ing, titulo_secundario_esp, titulo_secundario_por, titulo_secundario_ing, codfranquicia, id_subcategoria, id_categoria, tags) VALUES ('{$value->codigo}', '{$nombre_es}','{$nombre_portugues}','{$nombre_ingles}','{$value->canthoras}','{$value->cantmeses}','{$value->cantanios}','{$value->color}','{$value->logo}','{$descripcion}','{$descripcion_por}','{$descripcion_ing}','{$descripcion_corta_esp}','{$descripcion_corta_por}','{$descripcion_corta_ing}','{$value->aniopertenece}','{$value->activo}','{$descripcion_venta_esp}','{$descripcion_venta_por}','{$descripcion_venta_ing}','{$titulo_secundario_esp}','{$titulo_secundario_por}','{$titulo_secundario_ing}','{$value->codfranquicia}','{$value->id_subcategoria}','{$value->id_categoria}','{$value->tags}')";
                    //echo $query_ins;
                    $result_ins = $mysqli->query($query_ins);
                    if(!$result_ins){
                        $message.= "<br/>Error - al insertar el curso {$value->nombre_es}<br/>";
                    }else{
                        $message.= "<br/>Correcto - Se inserto el curso {$value->nombre_es}";
                    }
                }else{
                    $message.= "<br/>Error - Ya existe el curso {$value->nombre_es} con id {$value->codigo}<br/>";
                }
            }
        }
    }
    return $message;
}


function ws_insertFilialIdioma($mysqli, $cod_curso=""){
    $message = '';
    $array_cursos = getCursos($mysqli, $cod_curso);
    foreach ($array_cursos as $id_cursos=>$value_cursos){
	$array_fiales = getFiliales($mysqli);
	foreach($array_fiales as $id_filial=>$value_filial){
	    $array_idiomas = getIdiomas($mysqli);
	    foreach($array_idiomas as $id_idioma=>$value_idioma){
		/*$query_sel = "SELECT id  FROM curso_filial_idioma WHERE cod_curso='{$value_cursos['cod_curso']}' AND id_filial='{$value_filial['id']}' AND id_idioma='{$value_idioma['id']}'";
		$result_sel = $mysqli->query($query_sel);
		if($result_sel->num_rows == 0){*/
		    $query_ins = "INSERT INTO curso_filial_idioma SET cod_curso='{$value_cursos['cod_curso']}',id_filial='{$value_filial['id']}',id_idioma='{$value_idioma['id']}',estado=1";
		    $result_ins = $mysqli->query($query_ins);
		    if(!$result_ins){
			$message.= "<br/>Error - al insertar el registro Curso {$value_cursos['nombre_es']} | {$value_filial['nombre']} | {$value_idioma['idioma']}<br/>";
		    }else{
			$message.= "<br/>Correcto - Se inserto el curso {$value_cursos['nombre_es']} <br/>";
		    }
		/*}else{
		    $message .= "Ya existe el curso {$value_cursos['nombre_es']} en la filial {$value_filial['nombre']} para el idioma {$value_idioma['idioma']} <br/>";
		}*/
	    }
	}
    }
    return $message;
}


function ws_insertDatosCursos($mysqli, $cod_curso=""){
    $message = '';
    $cond = '';
    if(isset($cod_curso) && $cod_curso != ''){
        $cond.= ' WHERE cod_curso='.$cod_curso.' ';
    }
    $query = 'SELECT id, cod_curso, id_filial, id_idioma, estado FROM curso_filial_idioma '.$cond;
    $result_sel = $mysqli->query($query);
    while($cfi = $result_sel->fetch_assoc()){
        $curso = getCursos($mysqli, $cfi['cod_curso']);
        /*$result = $mysqli->query("SELECT id FROM curso_datos WHERE id_cfi=".$cfi['id']);
        if($result->num_rows == 0){*/
    	    switch($cfi['id_idioma']){
    		//Ingles
    		case "2":
    		    $nombre = addslashes(trim($curso[0]['nombre_ingles']));
    		    $descripcion = addslashes(trim($curso[0]['descripcion_ing']));
    		break;
    		
    		//Portuges
    		case "3":
    		    $nombre = addslashes(trim($curso[0]['nombre_portugues']));
    		    $descripcion = addslashes(trim($curso[0]['descripcion_por']));
    		break;
    		
    		//Español
    		default:
    		     $nombre = addslashes(trim($curso[0]['nombre_es']));
    		     $descripcion = addslashes(trim($curso[0]['descripcion']));
    		break;
    	    }
            $query_ins = "INSERT INTO curso_datos SET id_cfi='{$cfi['id']}', nombre='{$nombre}', descripcion='{$descripcion}', horas='{$curso[0]['horas']}', meses='{$curso[0]['meses']}', anios='{$curso[0]['anios']}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar {$cfi['id']}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto {$cfi['id']}";
            }
        /*}else{
            $message.= "<br/>Error - Ya existe {$cfi['id']}<br/>";
        }*/
    }
    return $message;
}

function getCursosDatos($mysqli, $id_curso, $id_pais, $cod_idioma, $nombre_defecto, $duracion_defecto, $descripcion_defecto)
{
    $query = "SELECT id FROM idiomas WHERE cod_idioma = '{$cod_idioma}'";
    $result = $mysqli->query($query);
    $id_idioma = $result->fetch_assoc();

    $query2 = "SELECT min(id) FROM filiales WHERE id_provincia IN (select id from provincias where provincias.id_pais = {$id_pais})";
    $result = $mysqli->query($query2);
    
    $curso_datos = array('url_cabecera'=>'images/cabecera_defecto.jpg', 'nombre'=>$nombre_defecto, 'duracion'=>$duracion_defecto, 'descripcion'=>$descripcion_defecto, 'url_uniforme'=>'', 'url_material'=>'');
    if($result)
    {
        $id_filial = $result->fetch_assoc();
    
        $query3 = "SELECT id FROM curso_filial_idioma WHERE cod_curso = '{$id_curso}' AND id_filial = {$id_filial['min(id)']} AND id_idioma = {$id_idioma['id']} AND estado = 1";
        $result = $mysqli->query($query3);
        
        if($result)
        {    
            $id_curso_filial_idioma = $result->fetch_assoc();

            $query4 = "SELECT * FROM curso_datos WHERE id_cfi = '{$id_curso_filial_idioma['id']}'";
            $result = $mysqli->query($query4);
            $curso_datos = $result->fetch_assoc();
        }
    } 
    
    return $curso_datos;
}

function cambiarPais($cod_pais, $mysqli){
    $query = "SELECT id, cod_pais, pais, flag FROM paises WHERE cod_pais='{$cod_pais}'";

    $result = $mysqli->query($query);
    $tablaPaisdatos = $result->fetch_assoc();
        
    $tablaPais = array('id'=>$tablaPaisdatos['id'], 'cod_pais'=>$tablaPaisdatos['cod_pais'], 'pais'=>$tablaPaisdatos['pais'],'flag'=>$tablaPaisdatos['flag']);
        
    $query2 = "SELECT id, idioma, cod_idioma FROM idiomas WHERE idiomas.id = (select min(id_idioma) from pais_idioma where pais_idioma.id_pais = {$tablaPaisdatos['id']})";
        
    $result2 = $mysqli->query($query2);
    $idioma = $result2->fetch_assoc();
    
    session_start();
    $_SESSION['pais'] = array('id'=>$tablaPais['id'], 
                                'cod_pais'=>$tablaPais['cod_pais'], 
                                  'pais'=>$tablaPais['pais'],
                                  'flag'=>$tablaPais['flag'],
                                  'idioma'=>$idioma['idioma'],
                                  'cod_idioma'=>$idioma['cod_idioma'],
                                  'id_idioma'=>$idioma['id']);
    
    $_SESSION['idioma_seleccionado']['cod_idioma'] = $idioma['cod_idioma'];
    $_SESSION['idioma_seleccionado']['idioma'] = $idioma['idioma'];
    $_SESSION['idioma_seleccionado']['id_idioma'] = $idioma['id'];
    if(isset($_SESSION['id_filial'])){ unset($_SESSION['id_filial']);}
    
    echo 'ok';
}


function cambiarProvincia($cod_provincia, $mysqli){
    $query = "SELECT id, nombre FROM filiales WHERE id_provincia='{$cod_provincia}'";
    $result = $mysqli->query($query);
    
    while($tablaFiliales = $result->fetch_assoc())
    {
        $filiales[] = array('id'=>$tablaFiliales['id'], 'nombre'=>$tablaFiliales['nombre']);
    }
    echo json_encode($filiales);
}

function cambiarIdioma($cod_idioma, $mysqli)
{
    $query = "SELECT * FROM idiomas WHERE cod_idioma='{$cod_idioma}'";

    $result = $mysqli->query($query);
    $tablaIdiomas = $result->fetch_assoc();
        
    session_start();
    $_SESSION['idioma_seleccionado']['cod_idioma'] = $cod_idioma;
    $_SESSION['idioma_seleccionado']['idioma'] = $tablaIdiomas['idioma'];
    $_SESSION['idioma_seleccionado']['id_idioma'] = $tablaIdiomas['id'];
    echo 'ok';
}

function getFilial($id_filial, $mysqli)
{
    $result = $mysqli->query("SELECT * FROM filiales WHERE filiales.id = {$id_filial}");
 
    $filial = $result->fetch_assoc();
            
    return $filial;
}

function getSlider($mysqli, $id_pais = false, $cod_idioma = false)
{
    $query = "SELECT * FROM slider";
    
    $result = $mysqli->query($query);
    $sliders = array();
    
    if($result)
    {
        while($slider = $result->fetch_assoc())
        {
            $arrayPais = json_decode($slider['id_pais']);
            $arrayIdioma = json_decode($slider['cod_idioma']);
            if($id_pais)
            {
                if(in_array($id_pais, $arrayPais))
                {
                    if($cod_idioma)
                    {
                        if(in_array($cod_idioma, $arrayIdioma))
                        {
                            $sliders[] = array('id'=>$slider['id'],'alt'=>$slider['alt'], 'url'=>$slider['url'], 'link'=>$slider['link'], 'thumb'=>$slider['url_thumb'], 'id_pais'=>$arrayPais, 'cod_idioma'=>$arrayIdioma, 'background'=>$slider['background']);
                        }
                    }
                    else
                    {
                        $sliders[] = array('id'=>$slider['id'],'alt'=>$slider['alt'], 'url'=>$slider['url'], 'link'=>$slider['link'], 'thumb'=>$slider['url_thumb'], 'id_pais'=>$arrayPais, 'cod_idioma'=>$arrayIdioma, 'background'=>$slider['background']);
                    }
                }
            }
            else
            {
                if($cod_idioma)
                {
                    if(in_array($cod_idioma, $arrayIdioma))
                    {
                        $sliders[] = array('id'=>$slider['id'],'alt'=>$slider['alt'], 'url'=>$slider['url'], 'link'=>$slider['link'], 'thumb'=>$slider['url_thumb'], 'id_pais'=>$arrayPais, 'cod_idioma'=>$arrayIdioma, 'background'=>$slider['background']);
                    }
                }
                else
                {
                    $sliders[] = array('id'=>$slider['id'],'alt'=>$slider['alt'], 'url'=>$slider['url'], 'link'=>$slider['link'], 'thumb'=>$slider['url_thumb'], 'id_pais'=>$arrayPais, 'cod_idioma'=>$arrayIdioma, 'background'=>$slider['background']);
                }
            }
        }
    }
    return $sliders;
}

//controlador para cambiar idioma - lo pongo aca a falta de un lugar mejor
if(isset($_POST['cambiarPais']))
{
    cambiarPais($_POST['cod_pais'], $mysqli);
}

if(isset($_POST['cambiarIdioma']))
{
    cambiarIdioma($_POST['cod_idioma'], $mysqli);
}

if(isset($_POST['cambiarProvincia']))
{
    cambiarProvincia($_POST['cod_provincia'], $mysqli);
}

if(isset($_POST['filialSeleccionada']))
{
    $return = getFilial($_POST['cod_filial'], $mysqli);
    echo json_encode($return);
}

function getNovedades($mysqli, $id_pais=false, $id_idioma=false, $maximo = false, $estado = false, $categoria = false, $palabra = false, $fecha = false, $id_novedad=false){
    $cond = ' WHERE 1 = 1';
    $novedades = array();
    
    if($estado){
        $cond .= ' AND estado = 1 ';
    }
    
    if($id_idioma)
    {
        $cond .= " AND id_idioma={$id_idioma} ";
    }
    
    if($categoria)
    {
        $cond .= " AND categoria = {$categoria} ";
    }
    if($palabra)
    {
        $cond .= " AND (descripcion like '%{$palabra}%' or titulo like '%{$palabra}%')";
    }
    if($fecha)
    {
        $cond .= " AND fecha BETWEEN DATE_SUB('{$fecha}',INTERVAL 5 DAY) AND DATE_ADD('{$fecha}',INTERVAL 5 DAY)";
    }
    
    if($id_novedad)
    {
        $cond .= " AND id <> {$id_novedad} ";
    }
    
    $query = "SELECT * FROM novedades {$cond} ORDER BY categoria ASC, fecha DESC";
    
    if($maximo)
    {
        $query .= " LIMIT {$maximo}";
    }
    
    $resultado = $mysqli->query($query);
    
    while($new = $resultado->fetch_assoc())
    {
        $arrPaises = json_decode($new['id_pais']);
    
        if(!$id_pais)
        {
            $novedades[] = array('id'=>$new['id'],
                              'imagen'=>$new['imagen'],
                              'imagen2'=>$new['imagen2'],
                              'imagen3'=>$new['imagen3'],
                              'titulo'=>$new['titulo'],
                              'descripcion'=>$new['descripcion'],
                              'fecha'=>$new['fecha'],
                              'link'=>$new['link'],
                              'estado'=>$new['estado'],
                              'autor'=>$new['autor'],
                              'id_pais'=>  $arrPaises,
                              'id_idioma'=>$new['id_idioma'],
                              'categoria'=>$new['categoria']);
        }  
        else if(in_array($id_pais, $arrPaises))
        {
            $novedades[] = array('id'=>$new['id'],
                              'imagen'=>$new['imagen'],
                              'imagen2'=>$new['imagen2'],
                              'imagen3'=>$new['imagen3'],
                              'titulo'=>$new['titulo'],
                              'descripcion'=>$new['descripcion'],
                              'fecha'=>$new['fecha'],
                              'link'=>$new['link'],
                              'estado'=>$new['estado'],
                              'autor'=>$new['autor'],
                              'id_pais'=>  $arrPaises,
                              'id_idioma'=>$new['id_idioma'],
                              'categoria'=>$new['categoria']);
        }
    }
    
    if($resultado)$resultado->free();

    return $novedades;
}

function getNovedad($mysqli, $id_novedad, $id_pais=false, $id_idioma=false){
    $cond = " WHERE id={$id_novedad}";
    
    if($id_idioma){
        $cond .= " AND id_idioma={$id_idioma}";
    }

    $query = "SELECT * FROM novedades {$cond}";
    $resultado = $mysqli->query($query);
    
    while($new = $resultado->fetch_assoc())
    {
        $arrPaises = json_decode($new['id_pais']);
    
        if(!$id_pais)
        {
            $novedades = array('id'=>$new['id'],
                              'imagen'=>$new['imagen'],
                              'imagen2'=>$new['imagen2'],
                              'imagen3'=>$new['imagen3'],
                              'titulo'=>$new['titulo'],
                              'descripcion'=>$new['descripcion'],
                              'fecha'=>$new['fecha'],
                              'link'=>$new['link'],
                              'estado'=>$new['estado'],
                              'autor'=>$new['autor'],
                              'id_pais'=>  $arrPaises,
                              'id_idioma'=>$new['id_idioma'],
                              'categoria'=>$new['categoria']);
        }  
        else if(in_array($id_pais, $arrPaises))
        {
            $novedades = array('id'=>$new['id'],
                              'imagen'=>$new['imagen'],
                              'imagen2'=>$new['imagen2'],
                              'imagen3'=>$new['imagen3'],
                              'titulo'=>$new['titulo'],
                              'descripcion'=>$new['descripcion'],
                              'fecha'=>$new['fecha'],
                              'link'=>$new['link'],
                              'estado'=>$new['estado'],
                              'autor'=>$new['autor'],
                              'id_pais'=>  $arrPaises,
                              'id_idioma'=>$new['id_idioma'],
                              'categoria'=>$new['categoria']);
        }
    }
    
    if($resultado)$resultado->free();

    return $novedades;
}

function getNovedadesHome($mysqli, $id_pais=false, $id_idioma='1', $limit='3'){
    $cond = '';
    $novedades = array();
    
    $resultado = $mysqli->query("SELECT id, imagen, imagen2, imagen3, titulo, descripcion, DATE_FORMAT(`fecha`,'%d-%m-%Y') as fecha, estado, id_pais, id_idioma FROM novedades WHERE estado=1 AND id_idioma={$id_idioma} ORDER BY id DESC limit {$limit}");
    if($resultado->num_rows > 0){
        while($respuesta = $resultado->fetch_assoc())
        {
            die(var_dump($respuesta));
            $novedades[] = $respuesta;
        }
    }
    if($resultado)$resultado->free();
    
    return $novedades;
}

function getTotalNovedades($mysqli){
    $resultado = $mysqli->query("SELECT count(*) AS total FROM novedades");
    $total_novedades = $resultado->fetch_assoc();
    if($resultado)$resultado->free();
    
    return $total_novedades['total'];
}

function getTiposCursos($mysqli, $id_padre=''){
    $tipos_cursos = array();
    if(isset($id_padre) && $id_padre != ''){
        $resultado = $mysqli->query("SELECT id, nombre_es, nombre_in, nombre_pt, padre FROM tipos WHERE padre={$id_padre}");
        if($resultado->num_rows > 0){
            while($respuesta = $resultado->fetch_assoc())
            {
                $tipos_cursos[] = $respuesta;
            }
        }else{
            $tipos_cursos = array();
        }
        if($resultado)$resultado->free();
    }else{
        $resultado = $mysqli->query("SELECT id, nombre_es, nombre_in, nombre_pt, padre FROM tipos WHERE padre=0");
        if($resultado->num_rows > 0){
            while($respuesta = $resultado->fetch_assoc())
            {
                $tipos_cursos[] = $respuesta;
            }
        }else{
            $tipos_cursos = array();
        }
        if($resultado)$resultado->free();
    }
    
    return $tipos_cursos;
}

function getTipoCurso($mysqli, $id_tipo){
    $resultado = $mysqli->query("SELECT nombre_es, nombre_in, nombre_pt, padre FROM tipos WHERE id={$id_tipo}");
    if($resultado->num_rows > 0){
        $tipo = $resultado->fetch_assoc();
    }else{
        $tipo = array();
    }
    if($resultado)$resultado->free();
    
    return $tipo;
}

function getTiposAsignados($mysqli, $cod_curso){
    $tipos = array();
    if(isset($cod_curso)){
        $resultado = $mysqli->query("SELECT id_tipo FROM curso_tipo WHERE cod_curso='{$cod_curso}' AND estado=1");
        if($resultado->num_rows > 0){
            while($respuesta = $resultado->fetch_assoc())
            {
                $tipos[] = $respuesta['id_tipo'];
            }
        }else{
            $tipos = array();
        }
        if($resultado)$resultado->free();
    }
    
    return $tipos;
}

function guardarConsultaCurso($mysqli,$filial,$email,$nombre,$phone,$asunto,$cod_tipo_asunto,$message,$cod_curso="",$coursecontact="",$cod_comision="",$cod_plan=""){
    $html = $message;
    if($cod_tipo_asunto == 3){
        $tipo_asunto = 'curso';
    }else{
        $tipo_asunto = 'asunto';
        $cod_curso="";
    }
    $param = array(
	"codigo" => -1,
	"asunto" => $asunto,
	"tipo_asunto" => $tipo_asunto,
	"cod_curso_asunto" => $cod_tipo_asunto,
	"cod_filial" => $filial,
	"destacar" => 0,
	"estado" => "pendiente",
	"fechahora" => date("Y-m-d H:i:s"),
	"generado_por_filial" => 0,
	"mail" => $email,
	"nombre" => $nombre,
	"notificar" => 1,
	"respuesta_automatica_enviada" => 0,
	"telefono" => $phone,
	"html_respuesta" => $html
    );
    
    if(isset($cod_curso) && $cod_curso != ''){
        $curso = getCursos($mysqli, $cod_curso);
        switch($_SESSION['idioma_seleccionado']['cod_idioma']){
            case "ES":
                $param['asunto'] = $curso[0]['nombre_es'];
            break;

            case "POR":
                $param['asunto'] = $curso[0]['nombre_portugues'];
            break;

            case "IN":
                $param['asunto'] = $curso[0]['nombre_ingles'];
            break;
        }
    }
    
    if (isset($coursecontact) && $coursecontact != ''){
        $param['agregar_reserva'] = "true";
        $param['cod_comision'] = $cod_comision;
        $param['cod_plan'] = $cod_plan;
    }

    $wsc = new wsc_sistema("sincronizar_consulta_web", $param);
    $respuesta = $wsc->exec(WSC_RETURN_ARRAY);
    if (is_array($respuesta) && isset($respuesta['success']) && $respuesta['success'] == "success"){
            $result = array("success" => true, "data" => $param);
    } else if ($wsc->isError()){
            $result = array("success" => false, "error" => $wsc->getError());
    } else {
            $result = array("success" => false, "Error" => $wsc->getResponse());
    }

    return $result;
}

function reservaInscripcion($nombre, $email, $telefono, $id_comision, $id_filial, $id_plan){
    $param = array(
            "nombre" => $nombre,
            "email" => $email,
            "telefono" => $telefono,
            "id_comision" => $id_comision,
            "id_filial" => $id_filial,
            "id_plan" => $id_plan
        );
    $wsc = new wsc_sistema("sincronizar_reservas_inscripciones_web", $param);
    $respuesta = $wsc->exec(WSC_RETURN_ARRAY);
    if (is_array($respuesta)){
        if (isset($respuesta['success']) && $respuesta['success'] == "success"){
            $result = array("success" => true, "data" => $param, "error" => "Reserva registrada con éxito, nos estaremos comunicando a la brevedad.");
        } else {
            $result = array("success" => false, "error" => $respuesta['error']);
        }
    } else if ($wsc->isError()){
        $result = array("success" => false, "error" => $wsc->getError());
    } else {
        $result = array("success" => false, "error" => $wsc->getResponse());
    }
    
    return $result;
}

function getMallaCurricular($mysqli, $id_cfi)
{
    $resultado = $mysqli->query("SELECT * FROM malla_curricular WHERE id_curso_filial_idioma = {$id_cfi} ORDER BY cuatrimestre");
    
    if($resultado->num_rows > 0)
    {
        while($respuesta = $resultado->fetch_assoc())
        {
            $malla[] = $respuesta;
        }
    }
    else
    {
        $malla = array();
    }
    
    if($resultado)$resultado->free();
        
    return $malla;
}

/*function getCursoConCupo($id_filial, $cod_curso){
    $webservice = new webServices();
    $str_cupos = $webservice->send("JSON_getCursosConCupo");
    $cupos = json_decode($str_cupos,true);

    $curso_cupo = array();
    if(count($cupos) > 0){
        foreach($cupos[$id_filial] as $id=>$datos){
            if($datos['codigocurso'] == $cod_curso){
                $curso_cupo[] = $datos;
            }
        }
    }
    return $curso_cupo;
}*/

function getCursoConCupo($id_filial, $cod_curso) {
    $cfile = 'cache/cupos.json';
    // si ya esta el cache revisamos | agregar check de fecha y luego leemos
    if (file_exists($cfile)) {
        error_log("La última modificación de $cfile fue: ".date("F d Y H:i:s.", filectime($cfile)), 0);
        $str_cupos = file_get_contents($cfile);
    } else {
        $webservice = new webServices();
        $str_cupos = $webservice->send("JSON_getCursosConCupo");
        if (file_put_contents('cache/cupos.json', $str_cupos)) {
            error_log("¡Se escribio el cache de comision con cupo!", 0);
        } else {
            error_log("¡Error al escribir el cache de comisiones con cupo!", 0);
        }
    }

    $cupos = json_decode($str_cupos, true);
    $curso_cupo = array();

    if (count($cupos) > 0) {
        if (is_array($cupos[$id_filial])) {
            foreach($cupos[$id_filial] as $id => $datos) {
                if ($datos['codigocurso'] == $cod_curso) {
                    $curso_cupo[] = $datos;
                }
            }
        } else {
            echo "No hay comisiones con Cupos Disponibles para esta filial";
        }
    }
    return $curso_cupo;
}


function getCursosCortos($mysqli, $cod_curso = false, $pais = false)
{
    $cursosCortos = array();
    $query = "SELECT * FROM cursos_cortos WHERE 1 = 1 ";
    
    if($cod_curso)
    {
        $query .= " AND cod_curso = " . $cod_curso;
    }
    
    $query .= " ORDER BY categoria";
    
    $result = $mysqli->query($query);
    while($curso_corto = $result->fetch_assoc())
    {
        $arrPaises = json_decode($curso_corto['pais']);
        
        if(!$pais){
        $cursosCortos[] = array('cod_curso'=>$curso_corto['cod_curso'],
                                'nombre_ES'=>$curso_corto['nombre_ES'], 
                                'nombre_IN'=>$curso_corto['nombre_IN'], 
                                'nombre_POR'=>$curso_corto['nombre_POR'], 
                                'categoria'=>$curso_corto['categoria'],
                                'pais'=>$arrPaises); 
        }else if(in_array($pais, $arrPaises)){
            $cursosCortos[] = array('cod_curso'=>$curso_corto['cod_curso'],
                                'nombre_ES'=>$curso_corto['nombre_ES'], 
                                'nombre_IN'=>$curso_corto['nombre_IN'], 
                                'nombre_POR'=>$curso_corto['nombre_POR'], 
                                'categoria'=>$curso_corto['categoria'],
                                'pais'=>$arrPaises);
        }
    }
    return $cursosCortos;
}

function getCategoriasCursosCortos($mysqli)
{
    $categoriasCursosCortos = array();
    $query = "SELECT * FROM categorias_cursos_cortos";
    
    $result = $mysqli->query($query);
    
    while($cat = $result->fetch_assoc())
    {
        $categoriasCursosCortos[$cat['id']] = $cat;
    }
    
    return $categoriasCursosCortos;
}

function getCategoriasNovedades($mysqli, $id = false)
{
    $categoriasNovedades = array();
    $query = "SELECT * FROM novedades_categorias";
    
    if($id)
    {
        $query .= " WHERE id = " . $id;
    }
    
    $result = $mysqli->query($query);
    while($categoriaNovedad = $result->fetch_assoc())
    {
	$categoriasNovedades[] = array('id'=>$categoriaNovedad['id'],
                                       'nombre_ES'=>$categoriaNovedad['nombre_ES'],
                                       'nombre_IN'=>$categoriaNovedad['nombre_IN'],
                                       'nombre_POR'=>$categoriaNovedad['nombre_POR']); 
    }
    return $categoriasNovedades;
}
?>
