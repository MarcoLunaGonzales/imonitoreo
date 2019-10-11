<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

session_start();

$dbh = new Conexion();

$table="componentessis";
$urlRedirect="../index.php?opcion=listComponentesSIS";

$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$partida=$_POST["partida"];
$nivel=$_POST["nivel"];
$padre=$_POST["padre"];
$codEstado="1";
$personal=$_POST["cod_personal"];
$globalGestion=$_SESSION["globalGestion"];

// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, abreviatura, nivel, cod_padre, partida, cod_estado, cod_personal, cod_gestion) VALUES (:nombre, :abreviatura, :nivel, :cod_padre, :partida, :cod_estado, :cod_personal, :cod_gestion)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':nivel', $nivel);
$stmt->bindParam(':partida', $partida);
$stmt->bindParam(':cod_padre', $padre);
$stmt->bindParam(':cod_estado', $codEstado);
$stmt->bindParam(':cod_personal', $personal);
$stmt->bindParam(':cod_gestion', $globalGestion);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
