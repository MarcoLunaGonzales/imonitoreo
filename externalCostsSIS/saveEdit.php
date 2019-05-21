<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="external_costs";
$urlRedirect="../index.php?opcion=listExternalCostsSIS";

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$nombre=clean_string($nombre);
$nombreEn=$_POST["name"];
$nombreEn=clean_string($nombreEn);
$abreviatura=$_POST["abreviatura"];
$codEstado="1";

// Prepare
$stmt = $dbh->prepare("UPDATE $table set nombre=:nombre, nombre_en=:name, abreviatura=:abreviatura where codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':name', $nombreEn);
$stmt->bindParam(':abreviatura', $abreviatura);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>