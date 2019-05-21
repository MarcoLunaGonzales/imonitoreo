<?php
set_time_limit(0);
require_once '../conexionExtIbnorca.php';
require_once '../conexion.php';
$dbhExterno = new ConexionExterno();
$dbh = new Conexion();

echo "<h3>Hora Inicio Proceso Cursos: " . date("Y-m-d H:i:s")."</h3>";


$sql = 'CALL cubo_cursos2()';
$query = $dbhExterno->query($sql);
$query -> setFetchMode(PDO::FETCH_ASSOC);

$insert_str="";
$indice=1;

$sqlDelete = 'delete from ext_cursos';
$stmtDelete = $dbh->prepare($sqlDelete);
$flagSuccess=$stmtDelete->execute();

while($resp = $query->fetch()){
	$gestion=$resp['gestion'];
	$idOficina=$resp['IdOficina'];
	$idPrograma=$resp['IdPrograma'];
	$estado=$resp['Estado'];
	$fechaInicio=$resp['FechaInicio'];
	$fechaFin=$resp['FechaFin'];

	$insert_str .= "('$indice','$gestion','$idOficina','$idPrograma','$estado','$fechaInicio','$fechaFin'),";	

	if($indice%1000==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, estado, fecha_inicio, fecha_fin) 
			values ".$insert_str.";";
		//echo $sqlInserta;
		$stmtInsert=$dbh->prepare($sqlInserta);
		$stmtInsert->execute();
		$insert_str="";
	}
	$indice++;
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, estado, fecha_inicio, fecha_fin) 
	values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();

echo "<h3>Hora Fin Proceso Cursos: " . date("Y-m-d H:i:s")."</h3>";
?>