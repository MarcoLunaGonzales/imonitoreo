<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="versiones_poa";
$urlRedirect="../index.php?opcion=versionarPOA";

$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$fecha=$_POST["fecha"];
$codEstado="1";

// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, abreviatura, fecha, cod_estado) VALUES (:nombre, :abreviatura, :fecha, :cod_estado)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':cod_estado', $codEstado);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
