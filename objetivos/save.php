<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="objetivos";
$urlRedirect="../index.php?opcion=listObjetivos";

session_start();

$nombre=$_POST["nombre"];
$perspectiva=$_POST["perspectiva"];
$abreviatura=$_POST["abreviatura"];
$descripcion=$_POST["descripcion"];
$hitos=$_POST["hito"]; 
$codEstado="1";
$codTipoObjetivo="1";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$fechaHoraActual=date("Y-m-d H:i:s");

// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, cod_perspectiva, abreviatura, cod_tipoobjetivo, descripcion, cod_gestion, cod_estado, created_at, created_by) VALUES (:nombre, :cod_perspectiva, :abreviatura, :cod_tipoobjetivo, :descripcion, :cod_gestion, :cod_estado, :createdAt, :createdBy)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':cod_perspectiva', $perspectiva);
$stmt->bindParam(':abreviatura', $abreviatura);
$stmt->bindParam(':cod_tipoobjetivo', $codTipoObjetivo);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':cod_gestion', $globalGestion);
$stmt->bindParam(':cod_estado', $codEstado);
$stmt->bindParam(':createdAt', $fechaHoraActual);
$stmt->bindParam(':createdBy', $globalUser);

$flagSuccess=$stmt->execute();
$lastId = $dbh->lastInsertId();

$flagSuccessDetail=true;

for ($i=0;$i<count($hitos);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO objetivos_hitos (cod_objetivo, cod_hito) VALUES (:cod_objetivo, :cod_hito)");
	$stmt->bindParam(':cod_objetivo', $lastId);
	$stmt->bindParam(':cod_hito', $hitos[$i]);
	$flagSuccess2=$stmt->execute();
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
