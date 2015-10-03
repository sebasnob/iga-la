<?php
session_start();
include_once 'gestor/includes/db_connect.php';
include_once 'gestor/includes/functions.php';

if(!$_SESSION){
    //detectCountry($mysqli);
    $_SESSION['pais'] = array('cod_pais'=>"AR", 'idioma'=>'ES');
}

$paises = getPaises($mysqli);
$datos_home = getDatosHome($mysqli);
?>



