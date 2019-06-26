<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$table="versiones_poa";
$urlRedirect="?opcion=versionarPOA";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;

// Prepare
$stmt = $dbh->prepare("UPDATE $table set cod_estado=2 where codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
