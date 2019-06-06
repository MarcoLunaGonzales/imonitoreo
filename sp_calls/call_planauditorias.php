<?php
set_time_limit(0);
require_once '../conexionExtIbnorca.php';
require_once '../conexion.php';

$dbhExterno = new ConexionExterno();
$dbh = new Conexion();

echo "<h3>Hora Inicio Proceso PlanAuditorias: " . date("Y-m-d H:i:s")."</h3>";

$sql = 'CALL Cubo_PlanAuditoria()';
$query = $dbhExterno->query($sql);
$query -> setFetchMode(PDO::FETCH_ASSOC);

$insert_str="";
$indice=1;

$sqlDelete = 'delete from ext_planauditorias';
$stmtDelete = $dbh->prepare($sqlDelete);
$flagSuccess=$stmtDelete->execute();

while($resp = $query->fetch()){
	$idServicio=$resp['idservicio'];
	$idOficina=$resp['idoficina'];
	$idCliente=$resp['IdCliente'];
	$codigoServicio=$resp['Codigo'];
	$gestion=$resp['Gestion'];
	$estado=$resp['d_estadoServicio'];
	$fechaEmision=$resp['FechaEmision'];
	$fechaValidez=$resp['FechaValido'];;
	$fechaPlanificada=$resp['FechaPlanificada'];
	$estadoPlanificacion=$resp['d_estadoPlan'];
	$fechaRealizada=$resp['FechaRealizada'];
	$fechaConclusion=$resp['FechaConclusion'];
	$idCertServicio=$resp['IdCertificadoServicios'];

	$insert_str .= "('$indice','$idServicio','$idOficina','$idCliente','$codigoServicio','$gestion','$estado','$fechaEmision','$fechaValidez','$fechaPlanificada','$estadoPlanificacion','$fechaRealizada','$fechaConclusion','$idCertServicio'),";	

	$indice++;

	//echo $idServicio." ".$idOficina." ".$idCliente." ".$gestion." ".$estado." ".$fechaEmision." ".$fechaValidez." ".$fechaPlanificada." ".$estadoPlanificacion." ".$fechaRealizada." ".$fechaConclusion." ".$idCertServicio."<br>";
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_planauditorias (codigo, id_servicio, id_oficina, id_cliente, codigoservicio, gestion, estado_servicio, fecha_emision, fecha_validez, fecha_planificada, estado_planificacion, fecha_realizada, fecha_conclusion, id_certificadoservicio) 
	values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();

echo "<h3>Hora Fin Proceso Auditorias: " . date("Y-m-d H:i:s")."</h3>";


?>