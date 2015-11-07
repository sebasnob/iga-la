<?php
header("Content-type: text/css");

include_once 'gestor/includes/db_connect.php';
include_once 'gestor/includes/functions.php';

if($_GET['cod_curso']){ 
    $query = $mysqli->query("SELECT color FROM cursos WHERE cod_curso=".$_GET['cod_curso']);
    $result = $query->fetch_assoc();
    $color_curso = "#".$result['color'];
}else{
    $color_curso = "#000000";
}

?>

#single_curso h2,h3{
    color:<?=$color_curso?>
}