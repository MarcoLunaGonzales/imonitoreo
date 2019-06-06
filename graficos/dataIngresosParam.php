<?php
header('Content-Type: application/json');
set_time_limit(0);

/*
$fondoTemporal=$_GET['fondoTemporal'];
$anioTemporal=$_GET['anioTemporal'];
$mesTemporal=$_GET['mesTemporal'];
*/
session_start();

$codFondoX=$_GET["codFondoX"];
$codOrganismoX=$_GET["codOrganismoX"];
$anioTemporal=$_SESSION["anioTemporal"];
$mesTemporal=$_SESSION["mesTemporal"];


/*$codFondoX=1030;
$codOrganismoX=503;
$anioTemporal=2019;
$mesTemporal=4;*/

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

	for($i=1;$i<=12;$i++){
	  	$montoPres=round(presupuestoIngresosMes($codFondoX,$anioTemporal,$i,$codOrganismoX,0,0),2);
		$montoEj=round(ejecutadoIngresosMes($codFondoX,$anioTemporal,$i,$codOrganismoX,0,0),2);
		          
	  	$abrevMes=abrevMes($i);		  	
		$emparray[]=array("mes"=>$abrevMes, "presupuesto"=>$montoPres, "ejecutado"=>$montoEj);

	}

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>