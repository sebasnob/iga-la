<?php
include_once 'psl-config.php';
 
function getDatosCurso($mysqli, $cod_curso, $id_pais='', $id_idioma='', $id_filial=''){
    $query1 = "SELECT cpif.id FROM `curso_pais_idioma_filial` as cpif 
                INNER JOIN pais_idioma as pi on pi.id=cpif.id_pais_idioma 
            WHERE 
                cpif.cod_curso=".$cod_curso." 
            AND 
                cpif.id_filial=".$id_filial." 
            AND 
                pi.id_pais=".$id_pais." 
            AND 
                pi.id_idioma=".$id_idioma;
    $qry_cpi = $mysqli->query($query1);
    $res_cpif = $qry_cpi->fetch_assoc();
    
    if($qry_cpi->num_rows > 0){
        $query2 = "select * from curso_datos WHERE id_cpif=".$res_cpif['id'];
        $qry_datos = $mysqli->query($query2);
        $datos_curso = $qry_datos->fetch_assoc();
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
        $cond=' WHERE id_idioma='.$id_idioma;
    }
    $resultado = $mysqli->query("SELECT id, idioma, cod_idioma FROM idiomas $cond");
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

function getCursos($mysqli, $cod_curso=''){
    $cond='';
    if(isset($cod_curso) && $cod_curso != ''){
        $cond = ' WHERE id='.$cod_curso;
    }
    $resultado = $mysqli->query("SELECT cod_curso, nombre_es, color FROM cursos $cond");
    $cursos = array();
    while($respuesta = $resultado->fetch_assoc()){
        $cursos[] = $respuesta;
    }
    $resultado->free();
    
    return $cursos;
}

function getFilialesCurso($mysqli, $cod_curso, $id_pais='', $id_provincia=''){
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
}

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
	$paises[] = array('id'=>$pais['id'],'pais'=>$pais['pais'],'cod_pais'=>$pais['cod_pais'],'flag'=>$pais['flag']);
    }
    return $paises;
}

function getIdiomasPais($mysqli, $id_pais){
    $idiomas_pais = array();
    $result = $mysqli->query("SELECT i.id, i.idioma FROM pais_idioma as pi INNER JOIN idiomas as i ON i.id=pi.id_idioma WHERE id_pais=".$id_pais);
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
    $result = $mysqli->query("SELECT id, provincia FROM provincias ".$cond);
    while($prov = $result->fetch_assoc()){
	$provincias[] = array('id'=>$prov['id'],'provincia'=>$prov['provincia']);
    }
    return $provincias;
}

function getFiliales($mysqli,$id_pais='1'){
    $filiales = array();
    $result = $mysqli->query("SELECT id, filial, id_provincia FROM filiales");
    while($filial = $result->fetch_assoc()){
	$filiales[] = array('id'=>$filial['id'],'filial'=>$filial['filial'],'id_provincia'=>$filial['id_provincia']);
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
    session_start(); // Start the PHP session 
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
    //$myIp = $_SERVER['REMOTE_ADDR'];
    $myIp = "190.2.100.6";

    $url = "http://www.telize.com/geoip/".$myIp;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //Con esta opcion almaceno el resultado en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if(curl_exec($ch)){
        $resp = json_decode(curl_exec($ch));
        
        $result = $mysqli->query("SELECT flag,idioma FROM paises WHERE cod_pais='".$resp->{'country_code'}."'");
        $datos_pais = $result->fetch_assoc();
        
        $_SESSION['pais'] = array('cod_pais'=>$resp->{'country_code'}, 'flag'=>$datos_pais['flag'], 'idioma'=>$datos_pais['idioma']);
        //$_SESSION['ciudad'] = $resp->{'city'};
    }else{
        $_SESSION['pais'] = array('cod_pais'=>"AR", 'flag'=>"images/flags/ar.png", 'idioma'=>'ES');
    }
    curl_close($ch);
}

function getImagenesGrilla($mysqli, $idioma = 'es')
{
    //TODO crear select por prioridad
    $result = $mysqli->query("SELECT * FROM grilla WHERE grilla.habilitado = 1 AND grilla.idioma = '{$idioma}' order by grilla.prioridad");
    while($grilla = $result->fetch_assoc())
    {
	$retorno[] = array( 'id'=>$grilla['id'],
                            'rows'=>$grilla['rows'],
                            'cols'=>$grilla['cols'],
                            'img_url'=>$grilla['img_url'],
                            'thumb_url'=>$grilla['thumb_url'],
                            'cod_curso'=>$grilla['cod_curso'],
                            'prioridad'=>$grilla['prioridad'],
                            'idioma'=>$grilla['idioma'],
                            'habilitado'=>$grilla['habilitado']);
    }
//           die(var_dump($retorno)); 
//    $retorno[] = array("id"=>"1","rows"=>"1", "cols"=>"6", "img_url"=>"images/grilla/7.jpg", "id_curso"=>"1");
    return $retorno;
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

?>
