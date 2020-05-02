<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();


$codigoIndicador=$_POST["cod_indicador"];
$cantidadFilas=$_POST["cantidad_filas"];
$codigoUnidad=$_POST["codigoUnidad"];
$codigoArea=$_POST["codigoArea"];


$table="actividades_poa";
$urlRedirect="../index.php?opcion=listActividadesPOA&codigo=$codigoIndicador&codigoPON=0&area=0&unidad=0";

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
	if(isset($_POST["actividad".$i])){
		$nombre=$_POST["actividad".$i];
	}else{
		$nombre="";
	}
	//echo $i." area: ".$area." <br>";

	if($nombre!=0 || $nombre!=""){
		$codigo=$_POST["codigo".$i];
		$datoClasificador="0";
		if(isset($_POST["clasificador".$i])){
			$datoClasificador=$_POST["clasificador".$i];
		}

		$sql="UPDATE $table set cod_datoclasificador = '$datoClasificador' where codigo='$codigo'";
		//echo $sql;
		$stmt = $dbh->prepare($sql);
		$flagSuccess=$stmt->execute();	
	}
} 



if($flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
