<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="estados_pon";
$urlRedirect="../index.php?opcion=listEstadosPON";

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$porcentaje=$_POST["porcentaje"];
$codEstado="1";

$stmt = $dbh->prepare("UPDATE $table set nombre=:nombre, abreviatura=:abreviatura, porcentaje=:porcentaje where codigo=:codigo");
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':porcentaje', $porcentaje);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
