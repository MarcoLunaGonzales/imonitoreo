<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listAreas";
$cargosX=$_POST["cargos"];
$codArea=$_POST["codigo_area"];

$stmtDel = $dbh->prepare("DELETE FROM areas_cargos where cod_area='$codArea'");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($cargosX);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO areas_cargos(cod_area, cod_cargo) VALUES (:cod_area, :cod_cargo)");
	$stmt->bindParam(':cod_area', $codArea);
	$stmt->bindParam(':cod_cargo', $cargosX[$i]);

	$flagSuccess2=$stmt->execute();
	if($flagSuccess2==false){
		$flagSuccessDetail=false;
	}
}

if($flagSuccessDetail==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
