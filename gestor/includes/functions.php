<?php
include_once 'psl-config.php';
 
function getDatos($mysqli, $id_curso, $idioma='ES'){
    $query = "SELECT c.color,cd.titulo,cd.img_cabecera,cd.img_materiales,cd.img_uniforme,ci.id FROM cursos as c INNER JOIN curso_idioma as ci ON ci.id_curso=c.id INNER JOIN curso_datos as cd ON cd.id_curso_idioma=ci.id WHERE ci.idioma='".$idioma."' AND ci.id_curso=".$id_curso;
    $resultado = $mysqli->query($query);
    $respuesta = $resultado->fetch_assoc();
    $resultado->free();
    
    return $respuesta;
}

function getIdiomas($mysqli){
    $resultado = $mysqli->query("SELECT * FROM idiomas");
    $idiomas = array();
    while($respuesta = $resultado->fetch_assoc()){
        $idiomas[] = $respuesta;
    }
    $resultado->free();
    
    return $idiomas;
}

function getCursos($mysqli, $idioma='ES'){
    $resultado = $mysqli->query("SELECT ci.id,cd.titulo FROM curso_idioma as ci INNER JOIN curso_datos as cd ON cd.id_curso_idioma=ci.id WHERE ci.idioma='ES'");
    $cursos = array();
    while($respuesta = $resultado->fetch_assoc()){
        $cursos[] = $respuesta;
    }
    $resultado->free();
    
    return $cursos;
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
    return json_encode($paises);
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
        
        $result = $mysqli->query("SELECT flag FROM paises WHERE cod_pais='".$resp->{'country_code'}."'");
        $flag = $result->fetch_assoc();
        
        $_SESSION['pais'] = array('cod_pais'=>$resp->{'country_code'}, 'flag'=>$flag['flag']);
        //$_SESSION['ciudad'] = $resp->{'city'};
    }else{
        $_SESSION['pais'] = array('cod_pais'=>"AR", 'flag'=>"images/flags/ar.png");
    }
    curl_close($ch);
}

function getImagenesGrilla()
{
    //TODO crear select por prioridad
    $retorno[] = array("id"=>"1","rows"=>"1", "cols"=>"6", "img_url"=>"images/portfolio/7.jpg", "id_curso"=>"1");
    $retorno[] = array("id"=>"2","rows"=>"1", "cols"=>"3", "img_url"=>"images/portfolio/2.jpg", "id_curso"=>"2");
    $retorno[] = array("id"=>"3","rows"=>"1", "cols"=>"3", "img_url"=>"images/portfolio/5.jpg", "id_curso"=>"3");
    $retorno[] = array("id"=>"4","rows"=>"1", "cols"=>"3", "img_url"=>"images/portfolio/3.jpg", "id_curso"=>"4");
    $retorno[] = array("id"=>"4","rows"=>"1", "cols"=>"6", "img_url"=>"images/portfolio/7.jpg", "id_curso"=>"4");
    $retorno[] = array("id"=>"4","rows"=>"1", "cols"=>"3", "img_url"=>"images/portfolio/3.jpg", "id_curso"=>"4");
    return $retorno;
}

?>