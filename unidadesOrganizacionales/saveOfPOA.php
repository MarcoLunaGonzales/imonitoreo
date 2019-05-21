<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listUnidadOrg";
$unidadesPOA=$_POST["unidadespoa"];

$stmtDel = $dbh->prepare("DELETE FROM unidadesorganizacionales_poa");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($unidadesPOA);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO unidadesorganizacionales_poa(cod_unidadorganizacional) VALUES (:cod_unidad)");
	$stmt->bindParam(':cod_unidad', $unidadesPOA[$i]);

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
