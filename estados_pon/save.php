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
$codTipoEstadoPON=$_POST["tipoestado"];
$codEstado="1";


$codigoInsert=getCodigoEstadoPON();
// Prepare
$sql="INSERT INTO $table (codigo, nombre, abreviatura, porcentaje, cod_estado, cod_tipoestadopon) VALUES ('$codigoInsert','$nombre','$abreviatura','$porcentaje','$codEstado','$codTipoEstadoPON')";
echo $sql;
$stmt = $dbh->prepare($sql);
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':porcentaje', $porcentaje);
$stmt->bindParam(':cod_estado', $codEstado);
$stmt->bindParam(':cod_tipoestadopon', $codTipoEstadoPON);

$flagSuccess=$stmt->execute();

//showAlertSuccessError($flagSuccess,$urlRedirect);

?>
