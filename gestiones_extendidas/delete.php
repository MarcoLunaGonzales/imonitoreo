<?php
require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="gestiones_extendidas";
$urlRedirect="../index.php?opcion=listGestionesExtendidas";

$gestion=$_GET["id_gestion"];

$stmt = $dbh->prepare("DELETE FROM $table where id_gestion=$gestion");
$flagSuccess2=$stmt->execute();
showAlertSuccessError($flagSuccess2,$urlRedirect);

?>
