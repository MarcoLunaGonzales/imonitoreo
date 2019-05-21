<?php
header('Content-Type: application/json');
set_time_limit(0);
set_time_limit(0);


/*
$fondoTemporal=$_GET['fondoTemporal'];
$anioTemporal=$_GET['anioTemporal'];
$mesTemporal=$_GET['mesTemporal'];
*/
session_start();

$fondo1=$_SESSION["fondo1"];
$nameFondo1=$_SESSION["nameFondo1"];
$fondo2=$_SESSION["fondo2"];
$nameFondo2=$_SESSION["nameFondo2"];
$fondo3=$_SESSION["fondo3"];
$nameFondo3=$_SESSION["nameFondo3"];
$anioTemporal=$_SESSION["anioTemporal"];
$mesTemporal=$_SESSION["mesTemporal"];


require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

	function utf8json($inArray) { 
	static $depth = 0; 
		/* our return object */ 
		$newArray = array(); 
		/* safety recursion limit */ 
		$depth ++; 
		if($depth >= '1000000') { 
			return false; 
		} 
		/* step through inArray */ 
		foreach($inArray as $key=>$val) { 
			if(is_array($val)) { 
				/* recurse on array elements */ 
				$newArray[$key] = utf8json($val); 
			} else { 
				/* encode string values */ 
				$newArray[$key] = utf8_encode($val); 
			} 
		} 
		/* return utf8 encoded array */ 
		return $newArray; 
	}
	
	$emparray[] = array();

  	$montoPresIngreso1=presupuestoIngresosMes($fondo1,$anioTemporal,$mesTemporal,0,1,0);
  	$montoPresIngreso2=presupuestoIngresosMes($fondo2,$anioTemporal,$mesTemporal,0,1,0);
  	$montoPresIngreso3=presupuestoIngresosMes($fondo3,$anioTemporal,$mesTemporal,0,1,0);

	$montoEjIngreso1=ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,0,1,0);
	$montoEjIngreso2=ejecutadoIngresosMes($fondo2,$anioTemporal,$mesTemporal,0,1,0);
	$montoEjIngreso3=ejecutadoIngresosMes($fondo3,$anioTemporal,$mesTemporal,0,1,0);


$emparray[]=array("fondo"=>$nameFondo1, "montoPresIngreso"=>$montoPresIngreso1, "montoEjIngreso"=>$montoEjIngreso1);

$emparray[]=array("fondo"=>$nameFondo2, "montoPresIngreso"=>$montoPresIngreso2, "montoEjIngreso"=>$montoEjIngreso2);

$emparray[]=array("fondo"=>$nameFondo3, "montoPresIngreso"=>$montoPresIngreso3, "montoEjIngreso"=>$montoEjIngreso3);


array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>