<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="personal_datosadicionales";
$urlRedirect="../index.php?opcion=listPersonal";

$codigo=$_POST["codigo"];
$perfil=$_POST["perfil"];
$cargo=$_POST["cargo"];
$nombreusuario=$_POST["nombreusuario"];
$contrasena=$_POST["contrasena"];
$usuariopon=$_POST["usuariopon"];
$cod_estado="1";

//BORRAMOS
$stmt = $dbh->prepare("DELETE from $table where cod_personal=:codigo");
$stmt->bindParam(':codigo', $codigo);
$flagSuccess1=$stmt->execute();

$stmt = $dbh->prepare("INSERT INTO $table (cod_personal, cod_estado, perfil, usuario, contrasena, cod_cargo, usuario_pon) VALUES (:cod_personal, :cod_estado, :perfil, :usuario, :contrasena, :cargo, :usuario_pon)");
// Bind
$stmt->bindParam(':cod_personal', $codigo);
$stmt->bindParam(':cod_estado', $cod_estado);
$stmt->bindParam(':perfil', $perfil);
$stmt->bindParam(':usuario', $nombreusuario);
$stmt->bindParam(':contrasena', $contrasena);
$stmt->bindParam(':cargo', $cargo);
$stmt->bindParam(':usuario_pon', $usuariopon);

$flagSuccess2=$stmt->execute();
showAlertSuccessError($flagSuccess2,$urlRedirect);

?>
