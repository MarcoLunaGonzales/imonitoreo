<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$table="gestiones_datosadicionales";
$urlRedirect="?opcion=listGestiones";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;

$stmt = $dbh->prepare("UPDATE $table set cod_estado=2");
$flagSuccess=$stmt->execute();

$stmt = $dbh->prepare("DELETE $table where cod_gestion='$codigo'");
$flagSuccess=$stmt->execute();

$stmt = $dbh->prepare("UPDATE $table set cod_estado=2 where codigo='$codigo'");
$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
