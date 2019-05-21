<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listNormas";
$priorizada=$_POST["priorizada"];

$stmtDel = $dbh->prepare("DELETE FROM normas_priorizadas");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($priorizada);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO normas_priorizadas(codigo) VALUES (:cod_norma)");
	$stmt->bindParam(':cod_norma', $priorizada[$i]);

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
