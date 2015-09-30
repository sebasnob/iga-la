<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

$insert = ws_insertPaises($mysqli);

print($insert);