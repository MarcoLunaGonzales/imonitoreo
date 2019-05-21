<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listFechasRegistro";
$anio=$_POST["anio"];
$mes=$_POST["mes"];

$fecha_inicio=$_POST["fecha_inicio"];
$fecha_fin=$_POST["fecha_fin"];

$stmt = $dbh->prepare("UPDATE fechas_registroejecucion set fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin where anio=:anio and mes=:mes");
$stmt->bindParam(':fecha_inicio', $fecha_inicio);
$stmt->bindParam(':fecha_fin', $fecha_fin);
$stmt->bindParam(':anio', $anio);
$stmt->bindParam(':mes', $mes);

$flagSuccess=$stmt->execute();
showAlertSuccessError(true,$urlRedirect);	

?>
