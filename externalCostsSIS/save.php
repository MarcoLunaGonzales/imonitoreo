<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';


session_start();

$dbh = new Conexion();

$table="external_costs";
$urlRedirect="../index.php?opcion=listExternalCostsSIS";

$nombre=$_POST["nombre"];
$nombre=clean_string($nombre);
$name=$_POST["name"];
$name=clean_string($name);
$abreviatura=$_POST["abreviatura"];
$codEstado="1";
$globalGestion=$_SESSION["globalGestion"];
$cod_proyecto=$_SESSION["globalProyecto"];


// Prepare
$sql="INSERT INTO $table (nombre, nombre_en, abreviatura, cod_estado, cod_gestion,cod_proyecto) VALUES ('$nombre','$name','$abreviatura','$codEstado','$globalGestion',$cod_proyecto)";
//echo $sql;
$stmt = $dbh->prepare($sql);
$flagSuccess=$stmt->execute();

showAlertSuccessError($flagSuccess,$urlRedirect);

?>
