<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$urlRedirect="../index.php?opcion=listPlanCuentas";
$cuentasX=$_POST["cuentas"];

$stmtDel = $dbh->prepare("DELETE FROM plancuentas_costosdirectos");
$stmtDel->execute();

$flagSuccessDetail=true;
for ($i=0;$i<count($cuentasX);$i++){ 	    
	$stmt = $dbh->prepare("INSERT INTO plancuentas_costosdirectos(cod_plancuenta) VALUES (:cod_cuenta)");
	$stmt->bindParam(':cod_cuenta', $cuentasX[$i]);

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
