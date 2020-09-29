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
$codAreaTemporal=$_GET["codAreaX"];


/*
$mesTemporal=4;
$anioTemporal=2019;
$codAreaTemporal=11;
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

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=11");
$stmt->execute();
$cadenaUnidades="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaUnidades=$row['valor_configuracion'];
}


$sql="SELECT so.codigo, so.nombre, so.abreviatura, sum(e.cantidad)as totalCantidadServicios, sum(e.monto_facturado*0.87)as montoTotalFactura from ext_servicios e, servicios_oi_detalle sd, servicios_oi so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anioTemporal and MONTH(e.fecha_factura)=$mesTemporal group by so.codigo, so.nombre, so.abreviatura order by 4 desc limit 0,15";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stmt->bindColumn('codigo', $codigoServicio);
$stmt->bindColumn('nombre', $nombreServicio);
$stmt->bindColumn('abreviatura', $abreviaturaServicio);
$stmt->bindColumn('totalCantidadServicios', $totalCantidadServicios);
$stmt->bindColumn('montoTotalFactura', $totalServicioFacturado);

while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
	$montoServicio=serviciosPorUnidad($cadenaUnidades,$anioTemporal,$mesTemporal,0,$codigoServicio,2);
	$montoServicioAcum=serviciosPorUnidad($cadenaUnidades,$anioTemporal,$mesTemporal,1,$codigoServicio,2);
	$emparray[]=array("servicio"=>$abreviaturaServicio, "montomes"=>$montoServicio, "montoacum"=>$montoServicioAcum);
}

array_splice($emparray, 0,1);
echo json_encode($emparray);
?>