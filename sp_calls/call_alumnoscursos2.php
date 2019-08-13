<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

set_time_limit(0);
require_once '../conexionExtIbnorca.php';
require_once '../conexion.php';
$dbhExterno = new ConexionExterno();
$dbh = new Conexion();

echo "<h3>Hora Inicio Proceso Alumnos Cursos: " . date("Y-m-d H:i:s")."</h3>";


$sql = 'CALL cubo_alumno_Curso()';
$query = $dbhExterno->query($sql);
$query -> setFetchMode(PDO::FETCH_ASSOC);

$insert_str="";
$indice=1;

$sqlDelete = 'delete from ext_alumnos_cursos';
$stmtDelete = $dbh->prepare($sqlDelete);
$flagSuccess=$stmtDelete->execute();

while($resp = $query->fetch()){
	$IdCurso=$resp['IdCurso'];
	$Curso_gestion=$resp['Curso_gestion'];
	$d_oficina=$resp['d_oficina'];
	$d_Programa=$resp['d_Programa'];
	$d_Tipo=$resp['d_Tipo'];
	$d_empresa=$resp['d_empresa'];
	$d_aprobacion=$resp['d_aprobacion'];
	$Nombre_Curso=$resp['Nombre_Curso'];
	$Curso_CantModulos=$resp['Curso_CantModulos'];
	$Estado=$resp['Estado'];
	$Cod_Curso=$resp['Cod_Curso'];
	$CiAlumno=$resp['CiAlumno'];
	$d_alumno=$resp['d_alumno'];
	$IdModulo=$resp['IdModulo'];
	$FechaInicio=$resp['FechaInicio'];
	$FechaFin=$resp['FechaFin'];
	$NroModulo=$resp['NroModulo'];
	$fechaNacimiento=$resp['fechaNacimiento'];

	$insert_str .= "('$IdCurso','$Curso_gestion','$d_oficina','$d_Programa','$d_Tipo','$d_empresa','$d_aprobacion','$Nombre_Curso','$Curso_CantModulos','$Estado','$Cod_Curso','$CiAlumno','$d_alumno','$IdModulo','$FechaInicio','$FechaFin','$NroModulo','$fechaNacimiento'),";	

	if($indice%800d==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_alumnos_cursos (idcurso, curso_gestion, d_oficina, d_programa, d_tipo, d_empresa, d_aprobacion, nombre_curso, curso_cantmodulos, estado, cod_curso, cialumno, d_alumno, idmodulo, fechainicio, fechafin, nromodulo, fechanacimiento) 
			values ".$insert_str.";";
		//echo $sqlInserta;
		echo "INSERT TUPLAS $indice";
		$stmtInsert=$dbh->prepare($sqlInserta);
		$stmtInsert->execute();
		$insert_str="";
	}
	$indice++;
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_alumnos_cursos (idcurso, curso_gestion, d_oficina, d_programa, d_tipo, d_empresa, d_aprobacion, nombre_curso, curso_cantmodulos, estado, cod_curso, cialumno, d_alumno, idmodulo, fechainicio, fechafin, nromodulo, fechanacimiento) 
	values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();

echo "<h3>Hora Fin Proceso Alumnos Cursos: " . date("Y-m-d H:i:s")."</h3>";
?>