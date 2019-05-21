<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="external_costs";
$urlRedirect="../index.php?opcion=listExternalCostsSIS";

$nombre=$_POST["nombre"];
$nombre=clean_string($nombre);
$name=$_POST["name"];
$name=clean_string($name);
$abreviatura=$_POST["abreviatura"];
$codEstado="1";

// Prepare
$sql="INSERT INTO $table (nombre, nombre_en, abreviatura, cod_estado) VALUES ('$nombre','$name','$abreviatura','$codEstado')";
//echo $sql;
$stmt = $dbh->prepare($sql);
$flagSuccess=$stmt->execute();

showAlertSuccessError($flagSuccess,$urlRedirect);

?>
