<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="componentessis";
$urlRedirect="../index.php?opcion=listComponentesSIS";

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$partida=$_POST["partida"];
$nivel=$_POST["nivel"];
$padre=$_POST["padre"];
$codEstado="1";
$personal=$_POST["cod_personal"];

// Prepare
$stmt = $dbh->prepare("UPDATE $table SET nombre=:nombre, abreviatura=:abreviatura, nivel=:nivel, cod_padre=:cod_padre, partida=:partida, cod_personal=:cod_personal WHERE codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':nivel', $nivel);
$stmt->bindParam(':partida', $partida);
$stmt->bindParam(':cod_padre', $padre);
$stmt->bindParam(':cod_personal', $personal);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>