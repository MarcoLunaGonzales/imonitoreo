<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="cargos_funciones";
$urlRedirect="../index.php?opcion=listCargos";

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$peso=$_POST["peso"];
$codEstado="1";

$sql="SELECT (IFNULL(max(cod_funcion)+1,1)) as orden from cargos_funciones c";
$stmt = $dbh->prepare($sql);
//echo $sql;
$stmt->execute();
$codigoX=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoX=$row['orden'];
}

// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (cod_cargo, cod_funcion, nombre_funcion, peso, cod_estado) VALUES (:cod_cargo, :cod_funcion, :nombre, :peso, :cod_estado)");
// Bind
$stmt->bindParam(':cod_cargo', $codigo);
$stmt->bindParam(':cod_funcion', $codigoX);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':peso', $peso);
$stmt->bindParam(':cod_estado', $codEstado);

$flagSuccess=$stmt->execute();
showAlertSuccessError($flagSuccess,$urlRedirect);

?>
