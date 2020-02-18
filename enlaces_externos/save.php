<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once 'configModule.php';

$dbh = new Conexion();

$nombre=$_POST["nombre"];
$enlace=$_POST["enlace"];
$codEstado="1";

echo $nombre." ".$abreviatura." ".$table;
// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, enlace, cod_estado) VALUES (:nombre, :enlace, :cod_estado)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':enlace', $enlace);
$stmt->bindParam(':cod_estado', $codEstado);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlList);

?>
