<?php
header('Content-Type: application/json');
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


  	$montoPresEg1=presupuestoEgresosMes($fondo1,$anioTemporal,$mesTemporal,0,0,0);
  	$montoPresEg2=presupuestoEgresosMes($fondo2,$anioTemporal,$mesTemporal,0,0,0);
  	$montoPresEg3=presupuestoEgresosMes($fondo3,$anioTemporal,$mesTemporal,0,0,0);

	$montoEjEg1=ejecutadoEgresosMes($fondo1,$anioTemporal,$mesTemporal,0,0,0);
	$montoEjEg2=ejecutadoEgresosMes($fondo2,$anioTemporal,$mesTemporal,0,0,0);
	$montoEjEg3=ejecutadoEgresosMes($fondo3,$anioTemporal,$mesTemporal,0,0,0);


$emparray[]=array("fondo"=>$nameFondo1, "montoPres"=>$montoPresEg1, "montoEj"=>$montoEjEg1);

$emparray[]=array("fondo"=>$nameFondo2, "montoPres"=>$montoPresEg2, "montoEj"=>$montoEjEg2);

$emparray[]=array("fondo"=>$nameFondo3, "montoPres"=>$montoPresEg3, "montoEj"=>$montoEjEg3);


array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>