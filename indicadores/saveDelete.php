<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$codigo=$codigo;
$codigoObjetivo=$codigo_objetivo;

$table="indicadores";
$urlRedirect="?opcion=listIndicadores&codigo=$codigoObjetivo";



// Prepare
$stmt = $dbh->prepare("UPDATE $table set cod_estado=2 where codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>