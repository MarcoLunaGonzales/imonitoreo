<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="objetivos";
$urlRedirect="../index.php?opcion=listObjetivosOp";

session_start();

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$indicadorEst=$_POST["indicador_est"];
$descripcion=$_POST["descripcion"];
$hitos=$_POST["hito"]; 
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$fechaHoraActual=date("Y-m-d H:i:s");

$nombre=strtoupper($nombre);
$descripcion=strtoupper($descripcion);

// Prepare
$sql="UPDATE $table set nombre=:nombre, descripcion=:descripcion,  modified_at=:modifiedAt, modified_by=:modifiedBy, cod_indicador=:cod_indicador where codigo=:codigo";
$stmt = $dbh->prepare($sql);
// Bind

$values = array(':codigo' => $codigo,
		':nombre' => $nombre,
		':descripcion' => $descripcion,
		':modifiedAt' => $fechaHoraActual,
		':modifiedBy' => $globalUser,
		':cod_indicador' => $indicadorEst);

$exQuery=str_replace(array_keys($values), array_values($values), $sql);

echo $exQuery;

$flagSuccess=$stmt->execute($values);

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


/*if($flagSuccessDetail==true && $flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}*/


?>
