<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

$cod_curso = "";
if(isset($_GET['cod_curso']) && $_GET['cod_curso'] != ''){
    $cod_curso = $_GET['cod_curso'];
}

$insert = ws_insertCursos($mysqli, $cod_curso);

print($insert);