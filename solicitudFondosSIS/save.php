<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

$cantidadFilas=$_POST["cantidad_filas"];
$fecha=$_POST["fecha"];
$observaciones=$_POST["observaciones"];

$urlRedirect="../index.php?opcion=listSolicitudFondosSIS";

session_start();

$codEstado="1";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

//INSERTAMOS LA CABECERA
$stmt = $dbh->prepare("INSERT INTO solicitud_fondos (cod_gestion, fecha, observaciones, created_at, created_by, cod_estado) VALUES (:cod_gestion, :fecha, :observaciones, :created_at, :created_by, :cod_estado)");
$stmt->bindParam(':cod_gestion', $globalGestion);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':observaciones', $observaciones);
$stmt->bindParam(':created_at', $fechaHoraActual);
$stmt->bindParam(':created_by', $globalUser);
$stmt->bindParam(':cod_estado', $codEstado);
$flagSuccess=$stmt->execute();	
//SACAMOS EL CODIGO PARA EL DETALLE
$lastId = $dbh->lastInsertId();


for ($i=1;$i<=$cantidadFilas;$i++){ 	    	
	$componente=$_POST["componente".$i];
	if($componente!=0 || $componente!=""){
		$stmt = $dbh->prepare("INSERT INTO solicitudfondos_detalle (codigo, cod_componente, monto) VALUES (:codigo, :cod_componente, :monto)");
		$codigoDetalle=$lastId;
		$codComponente=$_POST["componente".$i];
		$monto=$_POST["monto".$i];

		$stmt->bindParam(':codigo', $codigoDetalle);
		$stmt->bindParam(':cod_componente', $codComponente);
		$stmt->bindParam(':monto', $monto);

		$flagSuccess=$stmt->execute();	
	}
} 

if($flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
