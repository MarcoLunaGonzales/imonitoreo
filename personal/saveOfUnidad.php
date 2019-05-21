<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listPersonal";
$areasX=$_POST["areas"];
$codPersonal=$_POST["cod_personal"];

$stmtDel = $dbh->prepare("DELETE FROM personal_unidadesorganizacionales where cod_personal='$codPersonal'");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($areasX);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO personal_unidadesorganizacionales(cod_personal, cod_unidad) VALUES (:cod_personal, :cod_area)");
	$stmt->bindParam(':cod_personal', $codPersonal);
	$stmt->bindParam(':cod_area', $areasX[$i]);

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
