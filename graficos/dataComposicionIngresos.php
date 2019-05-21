<?php
header('Content-Type: application/json');
set_time_limit(0);


require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

error_reporting(E_ALL);
$dbh = new Conexion();

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
$cadenaOrganismos=$_SESSION["organismoTemporal"];

/*$fondoTemporal="1011,1012,1060,0";
$nombreFondo="XXX";
$mesTemporal=4;
$anioTemporal=2019;
$cadenaOrganismos="503,505,506,508,510,507";*/


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

    $sqlOrganismos="SELECT o.codigo, o.nombre from po_organismos o where o.codigo in ($cadenaOrganismos)";
    $stmtOrganismo=$dbh->prepare($sqlOrganismos);
    $stmtOrganismo->execute();
    $totalIngresos=0;
    $totalEgresos=0;
    $totalResultado=0;
    while($rowOrganismo=$stmtOrganismo->fetch(PDO::FETCH_ASSOC)){
      $codOrganismoX=$rowOrganismo['codigo']; 
      $nombreOrganismoX=$rowOrganismo['nombre']; 

      $montoEjIng=round(ejecutadoIngresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codOrganismoX,0,0));
      $montoEjEg=round(ejecutadoEgresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codOrganismoX,0,0));
      $resultado=$montoEjIng-$montoEjEg;

      if($resultado>0){
	      $emparray[]=array("area"=>$nombreOrganismoX, "resultado"=>$resultado);      	
      }
  	}

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>