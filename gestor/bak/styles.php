<?php
header("Content-type: text/css");

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

$datos_curso = getDatos($mysqli, $_GET['id_curso']);

$header_color = $datos_curso['color'];

?>
h1, h2, h3, h4 {
    color:<?=$header_color?>;
}

.btn.btn-primary{
	background-color:<?=$header_color?>;
}
