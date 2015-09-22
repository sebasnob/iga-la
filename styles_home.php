<?php
header("Content-type: text/css");

include_once 'gestor/includes/db_connect.php';
include_once 'gestor/includes/functions.php';

$datos_home = getDatosHome($mysqli);

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