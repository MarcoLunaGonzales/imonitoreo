<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listAreas";
$areasPOA=$_POST["areaspoa"];

$stmtDel = $dbh->prepare("DELETE FROM areas_poa");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($areasPOA);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO areas_poa(cod_area) VALUES (:cod_area)");
	$stmt->bindParam(':cod_area', $areasPOA[$i]);

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
