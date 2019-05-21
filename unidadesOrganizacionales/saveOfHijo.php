<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listUnidadOrg";
$areasX=$_POST["hijos"];
$codUnidad=$_POST["codigo_unidad"];

$stmtDel = $dbh->prepare("DELETE FROM unidadesorganizacionales_hijos where cod_unidadorganizacional='$codUnidad'");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($areasX);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO unidadesorganizacionales_hijos(cod_unidadorganizacional, cod_unidadorganizacionalhijo) VALUES (:cod_unidad, :cod_hijo)");
	$stmt->bindParam(':cod_unidad', $codUnidad);
	$stmt->bindParam(':cod_hijo', $areasX[$i]);

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
