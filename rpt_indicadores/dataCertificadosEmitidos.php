<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

header('Content-Type: application/json');
set_time_limit(0);

$dbh = new Conexion();

session_start();


$mesTemporal=$_GET["mesX"];
$anioTemporal=$_GET["anioX"];
$vista=$_GET["vistaX"];


/*$mesTemporal=5;
$anioTemporal=2019;*/


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

	$cantEmpresasTCP=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0,$vista);
	$cantEmpresasTCPAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1,$vista);

	$cantEmpresasTCS=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0,$vista);
	$cantEmpresasTCSAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1,$vista);

	$totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
	$totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;


	$partMesTCP=0;
	$partMesTCS=0;
	if($totalMes>0){
	$partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
	$partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
	}

	$partAcumTCP=0;
	$partAcumTCS=0;
	if($totalAcumulado>0){
	$partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
	$partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
	}

	$emparray[]=array("area"=>"TCP", "resultado"=>$partAcumTCP);
	$emparray[]=array("area"=>"TCS", "resultado"=>$partAcumTCS);

array_splice($emparray, 0,1);
echo json_encode($emparray);
?>