<?php
header("Content-type: text/css");

include_once 'gestor/includes/db_connect.php';
include_once 'gestor/includes/functions.php';

$datos_home = getDatosHome($mysqli);

if($_GET['cod_curso']){ 
    $query = $mysqli->query("SELECT color FROM cursos WHERE cod_curso=".$_GET['cod_curso']);
    $result = $query->fetch_assoc();
    $color_curso = "#".$result['color'];
}else{
    $color_curso = "#000000";
}

?>

.main-nav, 
.service-icon, 
.progress-bar.progress-bar-primary, 
.single-table.featured, 
.btn.btn-primary, 
.twitter-icon .fa-twitter, 
.twitter-left-control:hover, .twitter-right-control:hover, 
.post-icon, 
.entry-header .date:after, 
.btn-loadmore:hover, 
.btn-submit,
#footer, 
.caption .btn-start:hover, 
.left-control:hover, 
.right-control:hover, 
.folio-overview a:hover{
    background-color:<?=$datos_home['menu_color']?>;
}

.navbar-left li a{
    color:<?=$datos_home['fuente_color']?>;
}

.navbar-right li a{
    color:<?=$datos_home['fuente_color']?>;
}

#single_curso h2,h3{
    color:<?=$color_curso?>
}