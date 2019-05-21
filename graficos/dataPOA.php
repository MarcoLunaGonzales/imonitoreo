<?php
header('Content-Type: application/json');
set_time_limit(0);


session_start();


$mesTemporal=$_SESSION["mesTemporal"];
$anioTemporal=$_SESSION["anioTemporal"];
$codIndicador=$_SESSION["codIndicador"];

$codAreaTemporal=$_GET["codAreaX"];
$codUnidadTemporal=$_GET["codUnidadX"];

/*$mesTemporal=4;
$anioTemporal=2019;
$codIndicador=30;
$codAreaTemporal=39;
$codUnidadTemporal=4;*/


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
		$planificadoMes=planificacionPorIndicador($codIndicador,$codAreaTemporal,$codUnidadTemporal,$i,0);
      	$ejecutadoMes=ejecucionPorIndicador($codIndicador,$codAreaTemporal,$codUnidadTemporal,$i,0);
              
	  	$emparray[]=array("area"=>$codAreaTemporal,"unidad"=>$codUnidadTemporal,"mes"=>$i, "presupuesto"=>$planificadoMes, "ejecutado"=>$ejecutadoMes);
	}

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>