<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="estados_pon";
$urlRedirect="../index.php?opcion=listEstadosPON";

$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$porcentaje=$_POST["porcentaje"];
$codEstado="1";

// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, abreviatura, porcentaje, cod_estado) VALUES (:nombre, :abreviatura, :porcentaje, :cod_estado)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':porcentaje', $porcentaje);
$stmt->bindParam(':cod_estado', $codEstado);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
