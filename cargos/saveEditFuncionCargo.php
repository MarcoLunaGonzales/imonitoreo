<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="cargos_funciones";
$urlRedirect="../index.php?opcion=listCargos";

$codigoFuncion=$_POST["codigo_funcion"];
$codigoCargo=$_POST["codigo_cargo"];
$nombre=$_POST["nombre"];
$peso=$_POST["peso"];
$codEstado="1";

// Prepare
$stmt = $dbh->prepare("UPDATE $table SET nombre_funcion=:nombre_funcion, peso=:peso WHERE cod_funcion=:cod_funcion");
// Bind
$stmt->bindParam(':nombre_funcion', $nombre);
$stmt->bindParam(':peso', $peso);
$stmt->bindParam(':cod_funcion', $codigoFuncion);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
