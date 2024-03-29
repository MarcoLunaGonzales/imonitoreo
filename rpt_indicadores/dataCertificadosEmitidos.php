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

	$cadenaUnidades=obtieneValorConfig(11);

	$sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
	$stmtU = $dbh->prepare($sqlU);
	$stmtU->execute();
	$stmtU->bindColumn('codigo', $codigoX);
	$stmtU->bindColumn('abreviatura', $abrevX);

	$cantEmpresasTCPTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0,$vista);
	$cantEmpresasTCPAcumTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1,$vista);

	$cantEmpresasTCSTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0,$vista);
	$cantEmpresasTCSAcumTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1,$vista);

	$totalMes=$cantEmpresasTCPTotal+$cantEmpresasTCSTotal;
	$totalAcumulado=$cantEmpresasTCPAcumTotal+$cantEmpresasTCSAcumTotal;

	$cantidadTotalCertificados=$cantEmpresasTCPAcumTotal+$cantEmpresasTCSAcumTotal;

	while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
		$cantEmpresasTCPAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,0,$vista);
		$cantEmpresasTCSAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,1,$vista);

		$totalUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

		$participacionUnidad=0;
		if($cantidadTotalCertificados>0){
		$participacionUnidad=($totalUnidad/$cantidadTotalCertificados)*100;                    
		}
		$emparray[]=array("area"=>$abrevX, "resultado"=>$participacionUnidad);
	}


array_splice($emparray, 0,1);
echo json_encode($emparray);
?>