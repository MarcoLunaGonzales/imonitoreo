<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

header('Content-Type: application/json');
set_time_limit(0);


$dbh = new Conexion();
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
$cadenaOrganismos=$_SESSION["cadenaOrganismos"];
$cadenaFondos=$_SESSION["cadenaFondos"];



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

$sql="SELECT p.codigo, p.nombre from po_organismos p where p.codigo in ($cadenaOrganismos)";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codOrganismo=$row['codigo'];
	$nombreOrganismo=$row['nombre'];

  	$montoPresIngreso=round(presupuestoEgresosMes($cadenaFondos,$anioTemporal,$mesTemporal,$codOrganismo,0,0),2);
	$montoEjIngreso=round(ejecutadoEgresosMes($cadenaFondos,$anioTemporal,$mesTemporal,$codOrganismo,0,0),2);

	$emparray[]=array("fondo"=>$nombreOrganismo, "montoPresIngreso"=>$montoPresIngreso, "montoEjIngreso"=>$montoEjIngreso);

}

array_splice($emparray, 0,1);
echo json_encode($emparray);

?>