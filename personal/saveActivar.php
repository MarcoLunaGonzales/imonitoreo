<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$table="personal_datosadicionales";
$urlRedirect="?opcion=listPersonal";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;
$cod_estado="1";

$sqlDel="DELETE from $table where cod_personal=$codigo";
//echo $sqlDel;
$stmt = $dbh->prepare($sqlDel);
$flagSuccess=$stmt->execute();

$stmt = $dbh->prepare("INSERT INTO $table (cod_personal, cod_estado) VALUES (:cod_personal, :cod_estado)");
$stmt->bindParam(':cod_personal', $codigo);
$stmt->bindParam(':cod_estado', $cod_estado);
$flagSuccess2=$stmt->execute();

showAlertSuccessError($flagSuccess,$urlRedirect);

?>
