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



/*$mesTemporal=6;
$anioTemporal=2019;
*/

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


for($i=2015;$i<=$anioTemporal;$i++){
	$certificadosTCP=obtenerCantCertificados(0,$i,12,39,0,1,$vista);
	$certificadosTCS=obtenerCantCertificados(0,$i,12,38,0,1,$vista);

	$emparray[]=array("anio"=>$i, "tcp"=>$certificadosTCP, "tcs"=>$certificadosTCS);

}
	
array_splice($emparray, 0,1);
echo json_encode($emparray);
?>