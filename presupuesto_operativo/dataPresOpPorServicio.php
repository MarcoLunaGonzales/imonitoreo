<?php
header('Content-Type: application/json');
set_time_limit(0);

require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

session_start();
$fondoTemporal=$_SESSION['fondoTemporal'];
$anioTemporal=$_SESSION['anioTemporal'];
$mesTemporal=$_SESSION['mesTemporal'];

//SACAMOS LA CONFIGURACINO PARA REDISTRIBUIR EL IT
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=1");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $banderaRedistIT=$row['valor_configuracion'];
}

//SACAMOS LA CONFIGURACINO PARA LOS ORGANISMOS
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}
/*$fondoTemporal=$_GET['fondoTemporal'];
$anioTemporal=$_GET['anioTemporal'];
$mesTemporal=$_GET['mesTemporal'];*/


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

	$sqlServicios="SELECT codigo, nombre from po_organismos where codigo in ($cadenaOrganismos) order by 2";
	$stmtServicios = $dbh->prepare($sqlServicios);
	$stmtServicios->execute();
	while ($rowServicios= $stmtServicios->fetch(PDO::FETCH_ASSOC)) {
	  $codigoServicio=$rowServicios['codigo'];
	  $nombreServicio=$rowServicios['nombre'];
		
		$montoPresIngreso=presupuestoIngresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codigoServicio,0,0);
		$montoEjIngreso=ejecutadoIngresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codigoServicio,0,0);

		//EGRESOS
		$montoPresEgreso=presupuestoEgresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codigoServicio,0,0);
		$montoEjEgreso=ejecutadoEgresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codigoServicio,0,0);

		$resultadoPres=$montoPresIngreso-$montoPresEgreso;
		$resultadoEj=$montoEjIngreso-$montoEjEgreso;

		//CAMBIAMOS DE SIGNO
		$montoPresEgreso=$montoPresEgreso*(-1);
		$montoEjEgreso=$montoEjEgreso*(-1);

		$emparray[]=array("servicio"=>$nombreServicio, "montoPresIngreso"=>round($montoPresIngreso), "montoEjIngreso"=>round($montoEjIngreso),"montoPresEgreso"=>round($montoPresEgreso),"montoEjEgreso"=>round($montoEjEgreso),"resultadoPres"=>round($resultadoPres),"resultadoEj"=>round($resultadoEj));
	}
array_splice($emparray, 0,1);	                  
echo json_encode($emparray);

?>