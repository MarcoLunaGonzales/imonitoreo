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
$codArea=$_GET["codAreaX"];


/*$mesTemporal=5;
$anioTemporal=2019;
$vista="2";
$codArea="38";
*/

$cantidadRegistrosMostrar=obtieneValorConfig(28);

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
	
	$fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
	$fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
	$fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));


  	$organismoExtCert="641";//AFNOR
  	$organismoCert="804";

  	$totalAfnor=obtenerCantCertificadosOrganismo(0,$anioTemporal,$mesTemporal,$codArea,$organismoExtCert,1,$vista);

  	$totalIbnorca=obtenerCantCertificadosOrganismo(0,$anioTemporal,$mesTemporal,$codArea,$organismoCert,1,$vista);

  	$total=$totalAfnor+$totalIbnorca;

  	$porcentajeIbnorca=0;
  	$porcentajeAfnor=0;
  	if($total>0){
	  	$porcentajeIbnorca=round(($totalIbnorca/$total)*100);
		$porcentajeAfnor=round(($totalAfnor/$total)*100);
  	}
  	
  	$emparray[]=array("area"=>"IBNORCA", "resultado"=>$porcentajeIbnorca);
  	$emparray[]=array("area"=>"AFNOR", "resultado"=>$porcentajeAfnor);

array_splice($emparray, 0,1);
echo json_encode($emparray);
?>