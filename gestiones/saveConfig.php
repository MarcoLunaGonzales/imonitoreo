<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="gestiones_datosadicionales";
$urlRedirect="../index.php?opcion=listGestiones";

$codigo=$_POST["codigo"];
$estado=$_POST["estado"];
$estadoPOA=$_POST["estado_poa"];


if($estado==1){
	$stmt = $dbh->prepare("UPDATE $table SET cod_estado=2");
	$flagSuccess1=$stmt->execute();	
}
//BORRAMOS
$stmt = $dbh->prepare("DELETE from $table where cod_gestion=:codigo");
$stmt->bindParam(':codigo', $codigo);
$flagSuccess1=$stmt->execute();

$stmt = $dbh->prepare("INSERT INTO $table (cod_gestion, cod_estado, cod_estadopoa) VALUES (:cod_gestion, :cod_estado, :cod_estadopoa)");
// Bind
$stmt->bindParam(':cod_gestion', $codigo);
$stmt->bindParam(':cod_estado', $estado);
$stmt->bindParam(':cod_estadopoa', $estadoPOA);
$flagSuccess2=$stmt->execute();
showAlertSuccessError($flagSuccess2,$urlRedirect);

?>
