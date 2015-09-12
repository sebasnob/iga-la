<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<?php
$query_pais = "SELECT * FROM paises";
$res_pasies = $mysqli->query($query_pais);
while($pais=$res_pasies->fetch_assoc()){
?>
<h2><?=$pais['pais']?></h2>
<hr/>
<?php
	$query_prov = "SELECT * FROM provincias WHERE cod_pais='".$pais['cod_pais']."'";
	$res_provincias = $mysqli->query($query_prov);
	while($prov=$res_provincias->fetch_assoc()){
?>
		<h3><?=$prov['provincia']?></h3>
<?php
		$query_filial = "SELECT * FROM filiales WHERE id_provincia=".$prov['id'];
		$res_filiales = $mysqli->query($query_filial);
		while($filial=$res_filiales->fetch_assoc()){
?>
			<b><?=$filial['filial']?></b><br/>
<?php
			$query_curso = "SELECT * FROM cursos WHERE id_filial=".$filial['id'];
			$res_cursos = $mysqli->query($query_curso);
			while($curso=$res_cursos->fetch_assoc()){
?>
				<a href="cursos.php?id_curso=<?=$curso['id']?>"><?=$curso['nombre']?></a><br/>
<?php
			}
		}
	}
}
?>
</body>
</html>