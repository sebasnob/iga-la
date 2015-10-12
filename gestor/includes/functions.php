<?php
include_once 'psl-config.php';
include_once 'db_connect.php';
 
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
        $qry_datos->free();
        
        return $datos_curso;
    }else{
        return "No existen datos para la filial e idiomas seleccionados.";
    }
    $qry_cpi->free();
    
    /*$cabecera = getCabecera($mysqli, $id_curso, $id_pais, $id_idioma);
    
    $query = "SELECT url_uniforme, url_material, desc_uniforme, desc_material, duracion, plan_estudio FROM curso_datos WHERE id_curso_pais_idioma=".$cabecera['id']." AND id_filial=".$id_filial;
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    
    return $respuesta;*/
}

function getIdiomas($mysqli, $id_idioma=''){
    $cond='';
    if(isset($id_idioma) && $id_idioma != ''){
        $cond=' WHERE id='.$id_idioma;
    }
    $resultado = $mysqli->query("SELECT id, idioma, cod_idioma FROM idiomas {$cond}");
    $idiomas = array();
    while($respuesta = $resultado->fetch_assoc()){
        $idiomas[] = $respuesta;
    }
    $resultado->free();
    
    return $idiomas;
}

/*function getPaisIdioma($mysqli, $id_pais, $id_idioma){
    $qry = $mysqli->query("SELECT id FROM pais_idioma WHERE id_pais=".$id_pais." AND id_idioma=".$id_idioma);
    $pais_idioma = $qry->fetch_assoc();
    $qry->free();
    
    return $pais_idioma;
}

function getCurso($mysqli, $id_curso){
    $query = "SELECT nombre, color FROM cursos WHERE id=".$id_curso;
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    $resultado->free();
    
    return $respuesta;
}*/

function getCursos($mysqli, $cod_curso = '')
{
    $cond = '';
    
    if(isset($cod_curso) && $cod_curso != ''){
        $cond = ' WHERE cod_curso = '.$cod_curso;
    }
    
    $resultado = $mysqli->query("SELECT * FROM cursos {$cond} ORDER BY nombre_es");
    $cursos = array();

    while($respuesta = $resultado->fetch_assoc())
    {
        $cursos[] = $respuesta;
    }
    $resultado->free();
    
    return $cursos;
}

/*function getFilialesCurso($mysqli, $cod_curso, $id_pais='', $id_provincia=''){
    $cond='';
    $inner='';
    if(isset($id_pais) && $id_pais != ''){
        $inner .= ' INNER JOIN pais_idioma as pi ON pi.id=cpif.id_pais_idioma '
                . ' INNER JOIN paises as p ON p.id=pi.id_pais';
        $cond .= ' AND p.id='.$id_pais;
    }
    
    if(isset($id_provincia) && $id_provincia != ''){
        $cond .= ' AND f.id_provincia='.$id_provincia;
    }
    
    $query = "SELECT f.id, f.nombre FROM curso_pais_idioma_filial as cpif INNER JOIN filiales as f ON f.id=cpif.id_filial ".$inner." WHERE cpif.cod_curso=".$cod_curso. " ".$cond;
    $resultado = $mysqli->query($query);
    $filiales = array();
    while($respuesta = $resultado->fetch_assoc()){
        $filiales[] = $respuesta;
    }
    $resultado->free();
    
    return $filiales;
}*/

function getCursoPais($mysqli, $cod_curso=''){
    $cond = '';
    if(isset($cod_curso) && $cod_curso != ''){
	$cond = ' WHERE cp.cod_curso='.$cod_curso;
    }
    $cursos_paises = array();
    $result = $mysqli->query("SELECT p.id, p.pais FROM curso_pais as cp INNER JOIN paises as p ON p.id=cp.id_pais ".$cond);
    while($c_p = $result->fetch_assoc()){
	$cursos_paises[] = array('id'=>$c_p['id'], 'pais'=>$c_p['pais']);
    }
    $result->free();
    
    return $cursos_paises;
}


function getPais($mysqli, $cod_pais){
    $query = "SELECT id, pais, cod_pais, flag FROM paises WHERE cod_pais='".$cod_pais."'";
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    $resultado->free();
    
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
    $query = "SELECT id, nombre FROM provincias ".$cond;
    $result = $mysqli->query($query);
    while($prov = $result->fetch_assoc()){
	$provincias[] = array('id'=>$prov['id'],'nombre'=>$prov['nombre']);
    }
    return $provincias;
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

function getDatosHome($mysqli){
    $query = "SELECT id, url_video, titulo_es, titulo_in, titulo_por, subtitulo_es, subtitulo_por, subtitulo_in, menu_color, fuente_color FROM home";
    $resultado = $mysqli->query($query);
    $datos_home = $resultado->fetch_assoc();
    $resultado->free();
	
    return $datos_home;
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

function detectCountry($mysqli){
//    $myIp = $_SERVER['REMOTE_ADDR'];
    $myIp = "190.2.100.6";

//    die(var_dump($myIp));
    
    $url = "http://ipinfo.io/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //Con esta opcion almaceno el resultado en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //session_start();
    if(curl_exec($ch))
    {
        $resp = json_decode(curl_exec($ch));
        $cod_pais = $resp->country;
        $query = "SELECT id, pais, flag FROM paises WHERE cod_pais='{$cod_pais}'";
        
        $result = $mysqli->query($query);
        $tablaPaisdatos = $result->fetch_assoc();
        
        $tablaPais = array('id'=>$tablaPaisdatos['id'], 'cod_pais'=>$cod_pais, 'pais'=>$tablaPaisdatos['pais'],'flag'=>$tablaPaisdatos['flag']);
        
        $query2 = "SELECT idioma, cod_idioma FROM idiomas WHERE idiomas.id = (select id_idioma from pais_idioma where pais_idioma.id_pais = {$tablaPaisdatos['id']})";
        $result2 = $mysqli->query($query2);
        $idioma = $result2->fetch_assoc();
        $_SESSION['pais'] = array('id'=>$tablaPais['id'],
                                  'cod_pais'=>$tablaPais['cod_pais'], 
                                  'pais'=>$tablaPais['pais'],
                                  'flag'=>$tablaPais['flag'],
                                  'idioma'=>$idioma['idioma'],
                                  'cod_idioma'=>$idioma['cod_idioma']);
        
//        $_SESSION['ciudad'] = $resp->{'city'};
    }
    else
    {
        $_SESSION['pais'] = array('pais'=>'Argentina','cod_pais'=>"AR", 'idioma'=>'ES', 'flag'=>'images/flags/ar.png');
        $_SESSION['ciudad'] = 'Rosario';
    }
    curl_close($ch);
}

function getImagenesGrilla($mysqli, $idioma = 'ES', $id_pais='1')
{
    //TODO crear select por prioridad
    $result = $mysqli->query("SELECT * FROM grilla WHERE grilla.habilitado = 1 AND grilla.idioma = '{$idioma}' AND id_pais='{$id_pais}' order by grilla.prioridad");
    if($result->num_rows > 0){
        while($grilla = $result->fetch_assoc())
        {
            $retorno[] = array( 'id'=>$grilla['id'],
                                'cols'=>$grilla['cols'],
                                'img_url'=>$grilla['img_url'],
                                'thumb_url'=>$grilla['thumb_url'],
                                'id_curso'=>$grilla['cod_curso'],
                                'prioridad'=>$grilla['prioridad'],
                                'idioma'=>$grilla['idioma'],
                                'id_pais'=>$grilla['id_pais'],
                                'habilitado'=>$grilla['habilitado']);
        }
        return $retorno;
    }else{
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
    $message = '';
    $fp_prov = fopen("../ws/provincias.json","r");
    $linea_prov = fgets($fp_prov);

    $array_prov = json_decode($linea_prov);

    foreach ($array_prov as $id=>$value){
        $query_sel = "SELECT id, nombre FROM provincias WHERE id={$value->id} AND nombre='{$value->nombre}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){
            $query_ins = "INSERT INTO provincias SET id={$value->id}, nombre='{$value->nombre}', id_pais={$value->pais}, codigo_estado='{$value->codigo_estado}', identificador_estado='{$value->identificador_estado}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar la provincia {$value->nombre}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto la provincia {$value->nombre}, pais: {$value->pais}<br/>";
            }
        }else{
            $message.= "<br/>Error - Ya existe la pronvincia {$value->nombre} con id {$value->id}<br/>";
        }
    }
    return $message;
}

function ws_insertLocalidades($mysqli){
    $message = '';
    $fp_loc = fopen("../ws/localidades.json","r");
    $linea_loc = fgets($fp_loc);

    $array_loc = json_decode($linea_loc);

    foreach ($array_loc as $id=>$value){
        $query_sel = "SELECT id, nombre FROM localidades WHERE id={$value->id} AND nombre='{$value->nombre}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){
            $query_ins = "INSERT INTO localidades SET id={$value->id}, departamento_id='{$value->departamento_id}', nombre='{$value->nombre}', id_provincia='{$value->provincia_id}', id_pais='{$value->pais}', codigo_municipio='{$value->codigo_municipio}', codigo_siafi='{$value->codigo_siafi}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar la localidad {$value->nombre}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto la localidad {$value->nombre}, prov: {$value->provincia_id}<br/>";
            }
        }else{
            $message.= "<br/>Error - Ya existe la localidad {$value->nombre} con id {$value->id}<br/>";
        }
    }
    return $message;
}

function ws_insertFiliales($mysqli){
    $message = '';
    $fp_filiales = fopen("../ws/filiales.json","r");
    $linea_filiales = fgets($fp_filiales);

    $array_filiales = json_decode($linea_filiales);

    foreach ($array_filiales as $id=>$value){
        $res_prov = $mysqli->query("SELECT id_provincia FROM localidades WHERE id=".$value->id_localidad);
        if($res_prov){
            $prov = $res_prov->fetch_assoc();
        }else{
            $prov['id_provincia'] = 1111;
        }
        
        $query_sel = "SELECT id, nombre FROM filiales WHERE id={$value->codigo} AND nombre='{$value->nombre}'";
        $result_sel = $mysqli->query($query_sel);
        if($result_sel->num_rows == 0){
            $query_ins = "INSERT INTO filiales SET id={$value->codigo}, nombre='{$value->nombre}', id_localidad='{$value->id_localidad}', id_provincia='{$prov['id_provincia']}', domicilio='{$value->domicilio}', telefono='{$value->telefono}', telefono2='{$value->telefono2}', codigopostal='{$value->codigopostal}', email='{$value->email}', latitud='{$value->latitud}', longitud='{$value->longitud}', idioma='{$value->idioma}'";
            $result_ins = $mysqli->query($query_ins);
            if(!$result_ins){
                $message.= "<br/>Error - al insertar la filial {$value->nombre}<br/>";
            }else{
                $message.= "<br/>Correcto - Se inserto la filial {$value->nombre}, prov: {$prov['id_provincia']}<br/>";
            }
        }else{
            $message.= "<br/>Error - Ya existe la filial {$value->nombre} con id {$value->id}<br/>";
        }
    }
    return $message;
}

function ws_insertCursos($mysqli){
    $message = '';
    $fp_cursos = fopen("../ws/cursos.json","r");
    $linea_cursos = fgets($fp_cursos);

    $array_cursos = json_decode($linea_cursos);

    foreach ($array_cursos as $id=>$value){
        $query_sel = "SELECT cod_curso, nombre_es FROM cursos WHERE cod_curso={$value->codigo} AND nombre_es='{$value->nombre_es}'";
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
    return $message;
}


function ws_insertFilialIdioma($mysqli){
    $message = '';
    $array_cursos = getCursos($mysqli);
    foreach ($array_cursos as $id_cursos=>$value_cursos){
	$array_fiales = getFiliales($mysqli);
	foreach($array_fiales as $id_filial=>$value_filial){
	    $array_idiomas = getIdiomas($mysqli);
	    foreach($array_idiomas as $id_idioma=>$value_idioma){
		$query_sel = "SELECT id  FROM curso_filial_idioma WHERE cod_curso='{$value_cursos['cod_curso']}' AND id_filial='{$value_filial['id']}' AND id_idioma='{$value_idioma['id']}'";
		$result_sel = $mysqli->query($query_sel);
		if($result_sel->num_rows == 0){
		    $query_ins = "INSERT INTO curso_filial_idioma SET cod_curso='{$value_cursos['cod_curso']}',id_filial='{$value_filial['id']}',id_idioma='{$value_idioma['id']}',estado=1";
		    $result_ins = $mysqli->query($query_ins);
		    if(!$result_ins){
			$message.= "<br/>Error - al insertar el registro Curso {$value_cursos['nombre_es']} | {$value_filial['nombre']} | {$value_idioma['idioma']}<br/>";
		    }else{
			$message.= "<br/>Correcto - Se inserto el curso {$value_cursos['nombre_es']} <br/>";
		    }
		}else{
		    $message .= "Ya existe el curso {$value_cursos['nombre_es']} en la filial {$value_filial['nombre']} para el idioma {$value_idioma['idioma']} <br/>";
		}
	    }
	}
    }
    return $message;
}


function ws_insertDatosCursos($mysqli){
    $message = '';
    $query = 'SELECT id, cod_curso, id_filial, id_idioma, estado FROM curso_filial_idioma';
    $result_sel = $mysqli->query($query);
    while($cfi = $result_sel->fetch_assoc()){
        $curso = getCursos($mysqli, $cfi['cod_curso']);
        $result = $mysqli->query("SELECT id FROM curso_datos WHERE id_cfi=".$cfi['id']);
        if($result->num_rows == 0){
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
        }else{
            $message.= "<br/>Error - Ya existe {$cfi['id']}<br/>";
        }
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
        
    $query2 = "SELECT idioma, cod_idioma FROM idiomas WHERE idiomas.id = (select id_idioma from pais_idioma where pais_idioma.id_pais = {$tablaPaisdatos['id']})";
        
    $result2 = $mysqli->query($query2);
    $idioma = $result2->fetch_assoc();
    
    session_start();
    $_SESSION['pais'] = array('id'=>$tablaPais['id'], 
                                'cod_pais'=>$tablaPais['cod_pais'], 
                                  'pais'=>$tablaPais['pais'],
                                  'flag'=>$tablaPais['flag'],
                                  'idioma'=>$idioma['idioma'],
                                  'cod_idioma'=>$idioma['cod_idioma']);
    
    $_SESSION['idioma_seleccionado']['cod_idioma'] = $idioma['cod_idioma'];
    $_SESSION['idioma_seleccionado']['idioma'] = $idioma['idioma'];
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
    
    if($id_pais)
    {
        $query .= " WHERE id_pais = {$id_pais}";
    }
    
    if($cod_idioma)
    {
        if($id_pais)
        {
            $query .= " AND cod_idioma = '{$cod_idioma}'";
        }
        else
        {
            $query .= " WHERE cod_idioma = '{$cod_idioma}'";
        }
    }

    $result = $mysqli->query($query);
    $sliders = '';
    if($result)
    {
        while($slider = $result->fetch_assoc())
        {
            $sliders[] = array('id'=>$slider['id'],'alt'=>$slider['alt'], 'url'=>$slider['url'], 'link'=>$slider['link'], 'thumb'=>$slider['url_thumb'], 'cod_idioma'=>$slider['cod_idioma'], 'id_pais'=>$slider['id_pais']);
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

function getNovedades($mysqli, $id_pais='', $id_idioma=''){
    $cond = '';
    
    if(isset($id_pais) && $id_pais != '' && isset($id_idioma) && $id_idioma != ''){
        $cond .= ' WHERE id_pais={$id_pais} AND id_idioma={$id_idioma}';
    }
    
    $resultado = $mysqli->query("SELECT id, titulo, DATE_FORMAT(`fecha`,'%d-%m-%Y') as fecha, estado, id_pais, id_idioma FROM novedades {$cond}");
    $novedades = array();

    while($respuesta = $resultado->fetch_assoc())
    {
        $novedades[] = $respuesta;
    }
    $resultado->free();
    
    return $novedades;
}

function getNovedad($mysqli, $id_novedad){
    $resultado = $mysqli->query("SELECT id, titulo, imagen, descripcion, link, DATE_FORMAT(`fecha`,'%d-%m-%Y') as fecha, estado, id_pais, id_idioma FROM novedades WHERE id={$id_novedad}");
    if($resultado->num_rows > 0){
        $novedad = $resultado->fetch_assoc();
    }else{
        $novedad = array();
    }
    $resultado->free();
    
    return $novedad;
}

function getTotalNovedades($mysqli){
    $resultado = $mysqli->query("SELECT count(*) AS total FROM novedades");
    $total_novedades = $resultado->fetch_assoc();
    $resultado->free();
    
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
        $resultado->free();
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
        $resultado->free();
    }
    
    return $tipos_cursos;
}

?>
