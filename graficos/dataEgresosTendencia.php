<?php
header('Content-Type: application/json');
set_time_limit(0);

require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

/*
$fondoTemporal=$_GET['fondoTemporal'];
$anioTemporal=$_GET['anioTemporal'];
$mesTemporal=$_GET['mesTemporal'];
*/
session_start();

$fondoTemporal=$_SESSION["fondoTemporal"];
$nombreFondo=$_SESSION["nombreFondoTemporal"];
$mesTemporal=$_SESSION["mesTemporal"];
$anioTemporal=$_SESSION["anioTemporal"];
$organismoTemporal=$_SESSION["organismoTemporal"];

$fondo1=$fondoTemporal;
$nameFondo1=$nombreFondo;

$areasValorConfig=0;
$areasValorConfig=obtieneValorConfig(29);


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
	  	$montoPresIngreso1=round(presupuestoEgresosMes($fondo1,$anioTemporal,$i,$organismoTemporal,0,0));
		$montoEjIngreso1=round(ejecutadoEgresosMes($fondo1,$anioTemporal,$i,$organismoTemporal,0,0));

	  	$montoPresIngreso2=round(presupuestoEgresosMes($fondo1,$anioTemporal-1,$i,$organismoTemporal,0,0));
		$montoEjIngreso2=round(ejecutadoEgresosMes($fondo1,$anioTemporal-1,$i,$organismoTemporal,0,0));
		
		$montoPresTotal=0;
		$montoEjTotal=0;	
		if($organismoTemporal==$areasValorConfig){
			$montoPresTotal=round(presupuestoEgresosMes($fondo1,$anioTemporal,$i,0,0,0));
			$montoEjTotal=round(ejecutadoEgresosMes($fondo1,$anioTemporal,$i,0,0,0));
		}

		$emparray[]=array("mes"=>$i, "montoPres"=>$montoPresIngreso1, "montoEj"=>$montoEjIngreso1, "montoPres2"=>$montoPresIngreso2, "montoEj2"=>$montoEjIngreso2, "montoPresRegional"=>$montoPresTotal,"montoEjRegional"=>$montoEjTotal);
	}

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>