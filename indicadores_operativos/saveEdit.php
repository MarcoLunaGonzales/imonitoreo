<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="objetivos";
$urlRedirect="../index.php?opcion=listObjetivos";

session_start();

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$perspectiva=$_POST["perspectiva"];
$descripcion=$_POST["descripcion"];
$hitos=$_POST["hito"]; 
$codEstado="1";
$codTipoObjetivo="1";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$fechaHoraActual=date("Y-m-d H:i:s");

// Prepare
$stmt = $dbh->prepare("UPDATE $table set nombre=:nombre, cod_perspectiva=:cod_perspectiva, descripcion=:descripcion,  modified_at=:modifiedAt, modified_by=:modifiedBy where codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':cod_perspectiva', $perspectiva);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':modifiedAt', $fechaHoraActual);
$stmt->bindParam(':modifiedBy', $globalUser);

$flagSuccess=$stmt->execute();

$flagSuccessDetail=true;

$stmtDel = $dbh->prepare("DELETE FROM objetivos_hitos where cod_objetivo=:cod_objetivo");
$stmtDel->bindParam(':cod_objetivo', $codigo);
$stmtDel->execute();

for ($i=0;$i<count($hitos);$i++){ 	    
	$stmtDetalle = $dbh->prepare("INSERT INTO objetivos_hitos (cod_objetivo, cod_hito) VALUES (:cod_objetivo, :cod_hito)");
	$stmtDetalle->bindParam(':cod_objetivo', $codigo);
	$stmtDetalle->bindParam(':cod_hito', $hitos[$i]);
	$flagSuccess2=$stmtDetalle->execute();
	if($flagSuccess2==false){
		$flagSuccessDetail=false;
	}
}

if($flagSuccessDetail==true && $flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
