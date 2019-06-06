<?php
header('Content-Type: application/json');
set_time_limit(0);

/*
$fondoTemporal=$_GET['fondoTemporal'];
$anioTemporal=$_GET['anioTemporal'];
$mesTemporal=$_GET['mesTemporal'];
*/
session_start();

$anioTemporal=$_GET["anioTemporal"];
$mesTemporal=$_GET["mesTemporal"];
$arrayOrganismos=$_GET["arrayOrganismos"];
$arrayFondos=$_GET["arrayFondos"];

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

$arrayFondosX = explode(",", $arrayFondos);
$longitud = count($arrayFondosX);
for($i=0; $i<$longitud; $i++){
	$nameFondo=abrevFondo($arrayFondosX[$i]);
  	$montoPresEg1=round(presupuestoEgresosMes($arrayFondosX[$i],$anioTemporal,$mesTemporal,0,0,0),2);
	$montoEjEg1=round(ejecutadoEgresosMes($arrayFondosX[$i],$anioTemporal,$mesTemporal,0,0,0),2);
	$emparray[]=array("fondo"=>$nameFondo, "montoPres"=>$montoPresEg1, "montoEj"=>$montoEjEg1);
}

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>