<?php
header('Content-Type: application/json');
set_time_limit(0);

/*
$fondoTemporal=$_GET['fondoTemporal'];
$anioTemporal=$_GET['anioTemporal'];
$mesTemporal=$_GET['mesTemporal'];
*/
session_start();
$fondoTemporal=$_SESSION['fondoTemporal'];
$anioTemporal=$_SESSION['anioTemporal'];
$mesTemporal=$_SESSION['mesTemporal'];

$anioTemporalAnt=$anioTemporal-1;


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

	$montoPresIngresoAnt=presupuestoIngresosMes($fondoTemporal,$anioTemporalAnt,$mesTemporal,0,0,0);
  	$montoPresIngreso=presupuestoIngresosMes($fondoTemporal,$anioTemporal,$mesTemporal,0,0,0);

	$montoEjIngresoAnt=ejecutadoIngresosMes($fondoTemporal,$anioTemporalAnt,$mesTemporal,0,0,0);
	$montoEjIngreso=ejecutadoIngresosMes($fondoTemporal,$anioTemporal,$mesTemporal,0,0,0);

	$porcIngresoAnt=(($montoEjIngresoAnt-$montoPresIngresoAnt)/$montoPresIngresoAnt)*100;
	$porcIngreso=(($montoEjIngreso-$montoPresIngreso)/$montoPresIngreso)*100;

  //EGRESOS
  $montoPresEgresoAnt=presupuestoEgresosMes($fondoTemporal,$anioTemporalAnt,$mesTemporal,0,0,0);
  $montoPresEgreso=presupuestoEgresosMes($fondoTemporal,$anioTemporal,$mesTemporal,0,0,0);
  
  $montoEjEgresoAnt=ejecutadoEgresosMes($fondoTemporal,$anioTemporalAnt,$mesTemporal,0,0,0);
  $montoEjEgreso=ejecutadoEgresosMes($fondoTemporal,$anioTemporal,$mesTemporal,0,0,0);
  
  //RESULTADOS
  $resultadoPresAnt=$montoPresIngresoAnt-$montoPresEgresoAnt;
  $resultadoEjAnt=$montoEjIngresoAnt-$montoEjEgresoAnt;

  $resultadoPres=$montoPresIngreso-$montoPresEgreso;
  $resultadoEj=$montoEjIngreso-$montoEjEgreso;

//CAMBIAMOS DE SIGNO
  $montoPresEgresoAnt=$montoPresEgresoAnt*(-1);
  $montoPresEgreso=$montoPresEgreso*(-1);
  
  $montoEjEgresoAnt=$montoEjEgresoAnt*(-1);
  $montoEjEgreso=$montoEjEgreso*(-1);

$emparray[]=array("gestion"=>$anioTemporalAnt, "montoPresIngreso"=>round($montoPresIngresoAnt), "montoEjIngreso"=>round($montoEjIngresoAnt),"montoPresEgreso"=>round($montoPresEgresoAnt),"montoEjEgreso"=>round($montoEjEgresoAnt),"resultadoPres"=>round($resultadoPresAnt),"resultadoEj"=>round($resultadoEjAnt));

$emparray[]=array("gestion"=>$anioTemporal, "montoPresIngreso"=>round($montoPresIngreso), "montoEjIngreso"=>round($montoEjIngreso),"montoPresEgreso"=>round($montoPresEgreso),"montoEjEgreso"=>round($montoEjEgreso),"resultadoPres"=>round($resultadoPres),"resultadoEj"=>round($resultadoEj));

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>