<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="unidades_organizacionales";
$urlRedirect="../index.php?opcion=listUnidadOrg";

$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$codEstado="1";

// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, abreviatura, cod_estado) VALUES (:nombre, :abreviatura, :cod_estado)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':cod_estado', $codEstado);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
