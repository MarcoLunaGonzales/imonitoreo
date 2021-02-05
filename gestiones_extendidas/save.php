<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="gestiones_extendidas";
$urlRedirect="../index.php?opcion=listGestionesExtendidas";

$gestion=$_POST["gestion"];
$gestion_inicio=nameGestion($_POST["gestion_inicio"]);
$gestion_final=nameGestion($_POST["gestion_final"]);
$mes_inicio=$_POST["mes_inicio"];
$mes_final=$_POST["mes_final"];

$stmt = $dbh->prepare("INSERT INTO $table (id_gestion, anio_inicio, mes_inicio,anio_final,mes_final) VALUES (:id_gestion, :anio_inicio, :mes_inicio, :anio_final, :mes_final)");
// Bind
$stmt->bindParam(':id_gestion', $gestion);
$stmt->bindParam(':anio_inicio', $gestion_inicio);
$stmt->bindParam(':anio_final', $gestion_final);
$stmt->bindParam(':mes_inicio', $mes_inicio);
$stmt->bindParam(':mes_final', $mes_final);
$flagSuccess2=$stmt->execute();
showAlertSuccessError($flagSuccess2,$urlRedirect);

?>
