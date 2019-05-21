<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="tipos_seguimiento";
$urlRedirect="../index.php?opcion=listTiposSeg";

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$abreviatura=$_POST["abreviatura"];
$codEstado="1";

// Prepare
$stmt = $dbh->prepare("UPDATE $table set nombre=:nombre, abreviatura=:abreviatura where codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':abreviatura', $abreviatura);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>