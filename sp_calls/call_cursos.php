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

	if($indice%100==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, sigla, codigocurso, carga_horaria, tipo, nombre_curso, cantidad_modulos, estado, costo_modulo, empresa, nro_modulo, tema, fecha_inicio, fecha_fin, docente, alumnos_modulo) 
			values ".$insert_str.";";
		//echo $sqlInserta;
		echo "INSERTANDO.... Tuplas -> $indice <br>";
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



/*
$sql = "SELECT year(fecha_factura) as gestion, 5 as IdOficina, cd.IdPrograma as IdPrograma, ' ' as Sigla, cd.codigo_curso as Codigo,
0 as carga_horaria, '' as tipo, cd.Nombre as nombre_curso, 0 as CantidadModulos, '' as Estado, 0 as costoModulo,
df.nombrecliente as empresa, cd.NroModulo as NroModulo, cd.NombreModulo as tema, cd.FechaInicio as FechaInicio, cd.FechaFin as FechaFin, 
'' as d_Docente, 0 as CargaHoraria, 0 as AlumnosModulo, cd.NombrePrograma as nombre_programa, df.fecha_factura as fecha_factura, df.importe_bruto, df.importe_neto
  from bdifinanciero.v_detallefacturas df, bdifinanciero.v_cursosdetalles cd
where df.codigo_nivel2=cd.IdCurso and df.cod_claservicio=cd.IdModulo and df.fecha_factura>='2020-07-01' and df.area='SEC' ";
$query = $dbh->query($sql);
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
	$nombrePrograma=$resp['nombre_programa'];
	$fechaFactura=$resp['fecha_factura'];
	$importeBruto=$resp['importe_bruto'];
	$importeNeto=$resp['importe_neto'];


	$insert_str .= "('$indice','$gestion','$idOficina','$idPrograma','$sigla','$codigoCurso','$cargaHoraria','$tipo','$nombreCurso','$cantidadModulos','$estado','$costoModulo','$empresa','$nroModulo','$tema','$fechaInicio','$fechaFin','$dDocente','$alumnosModulo','$nombrePrograma','$fechaFactura','$importeBruto','$importeNeto'),";	

	if($indice%2==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, sigla, codigocurso, carga_horaria, tipo, nombre_curso, cantidad_modulos, estado, costo_modulo, empresa, nro_modulo, tema, fecha_inicio, fecha_fin, docente, alumnos_modulo, nombre_programa, fecha_factura, importe_bruto, importe_neto) 
			values ".$insert_str.";";
		echo $sqlInserta;
		$stmtInsert=$dbh->prepare($sqlInserta);
		$stmtInsert->execute();
		$insert_str="";
	}
	$indice++;
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_cursos (codigo, gestion, id_oficina, id_programa, sigla, codigocurso, carga_horaria, tipo, nombre_curso, cantidad_modulos, estado, costo_modulo, empresa, nro_modulo, tema, fecha_inicio, fecha_fin, docente, alumnos_modulo, nombre_programa, fecha_factura, importe_bruto, importe_neto) 
	values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();
*/

echo "<h3>Hora Fin Proceso Cursos: " . date("Y-m-d H:i:s")."</h3>";
?>