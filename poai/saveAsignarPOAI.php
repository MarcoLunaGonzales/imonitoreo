<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON

$codigoIndicadorPON=obtenerCodigoPON();


$codigoIndicador=$_POST["cod_indicador"];
$cantidadFilas=$_POST["cantidad_filas"];

$codigoUnidad=$_POST["codigoUnidad"];
$codigoArea=$_POST["codigoArea"];


$table="actividades_poa";
$urlRedirect="../index.php?opcion=listActividadesPOA&codigo=$codigoIndicador&codigoPON=$codigoIndicadorPON&area=0&unidad=0";

session_start();

$orden="1";
$codEstado="1";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

for ($i=1;$i<=$cantidadFilas;$i++){ 	    	
	// Prepare
	$actividad=$_POST["actividad".$i];
	//echo $i." area: ".$area." <br>";

	if($actividad!=0 || $actividad!=""){
		$codigo=$_POST["codigo".$i];
		$nombre=$_POST["actividad".$i];
		$personal=$_POST["personal".$i];
		$funcion=$_POST["funcion".$i];

		$codigoPOA=$codigo;

		$sqlUpd="UPDATE $table SET cod_personal='$personal', cod_funcion='$funcion' where codigo='$codigo'";
		
		//echo $sqlUpd;
		
		$stmt = $dbh->prepare($sqlUpd);
		$flagSuccess=$stmt->execute();	
	}
} 



if($flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
