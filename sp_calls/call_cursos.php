<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

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
	$sigla=$resp['Sigla'];
	$codigoCurso=$resp['Codigo'];
	$tipo=$resp['tipo'];
	$nombreCurso=$resp['nombre_curso'];
	$cantidadModulos=$resp['CantidadModulos'];
	$estado=$resp['Estado'];
	$costoModulo=$resp['costoModulo'];
	$empresa=$resp['empresa'];
	$nroModulo=$resp['NroModulo'];
	$tema=$resp['tema'];
	$fechaInicio=$resp['FechaInicio'];
	$fechaFin=$resp['FechaFin'];
	$dDocente=$resp['d_Docente'];
	$cargaHoraria=$resp['CargaHoraria'];
	$alumnosModulo=$resp['AlumnosModulo'];


	$insert_str .= "('$indice','$gestion','$idOficina','$idPrograma','$sigla','$codigoCurso','$cargaHoraria','$tipo','$nombreCurso','$cantidadModulos','$estado','$costoModulo','$empresa','$nroModulo','$tema','$fechaInicio','$fechaFin','$dDocente','$alumnosModulo'),";	

	if($indice%50==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, sigla, codigocurso, carga_horaria, tipo, nombre_curso, cantidad_modulos, estado, costo_modulo, empresa, nro_modulo, tema, fecha_inicio, fecha_fin, docente, alumnos_modulo) 
			values ".$insert_str.";";
		echo $sqlInserta;
		$stmtInsert=$dbh->prepare($sqlInserta);
		$stmtInsert->execute();
		$insert_str="";
	}
	$indice++;
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, sigla, codigocurso, carga_horaria, tipo, nombre_curso, cantidad_modulos, estado, costo_modulo, empresa, nro_modulo, tema, fecha_inicio, fecha_fin, docente, alumnos_modulo) 
	values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();

echo "<h3>Hora Fin Proceso Cursos: " . date("Y-m-d H:i:s")."</h3>";
?>