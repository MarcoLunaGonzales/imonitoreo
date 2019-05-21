<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="po_distribucionunidadesareas";

session_start();

$urlRedirect="../index.php?opcion=distribucionDNSA";

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$fechaHoraActual=date("Y-m-d H:i:s");

$flagSuccess=true;
$flagSuccess2=true;
$flagSuccessDetail=true;

$stmtDel = $dbh->prepare("DELETE FROM $table");
$flagSuccess=$stmtDel->execute();

foreach($_POST as $nombre_campo => $valor){ 
   	$asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   
	$cadenaBuscar='DN';
	$posicion = strpos($nombre_campo, $cadenaBuscar);
	if ($posicion === false) {
	}else{
		list($dn, $codFondo, $codOrganismo)=explode("|",$nombre_campo);
		//echo $dn." ".$codFondo." ".$codOrganismo."<br>";
		$valorDN=$_POST["DN|".$codFondo."|".$codOrganismo];
		$valorSA=$_POST["SA|".$codFondo."|".$codOrganismo];
		//echo $valorDN." ".$valorSA;

		$sql="INSERT INTO $table (cod_fondo, cod_organismo, porcentaje_sa, porcentaje_dn) VALUES (:cod_fondo, :cod_organismo, :porcentaje_sa, :porcentaje_dn)";
		$stmt = $dbh->prepare($sql);
		$values = array(':cod_fondo' => $codFondo,
        ':cod_organismo' => $codOrganismo,
        ':porcentaje_sa' => $valorSA,
        ':porcentaje_dn' => $valorDN
    	);
		$flagSuccess2=$stmt->execute($values);
		if($flagSuccess2==false){
			$flagSuccessDetail=false;
		}
	}
}

if($flagSuccessDetail==true && $flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
