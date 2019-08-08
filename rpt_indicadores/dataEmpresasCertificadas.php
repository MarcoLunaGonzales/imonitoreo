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

	$cantEmpresasTCPTotal=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,39,38,0,0,$vista);
	$cantEmpresasTCPAcumTotal=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,39,38,0,1,$vista);

	$cantEmpresasTCSTotal=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,0,0,$vista);
	$cantEmpresasTCSAcumTotal=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,0,1,$vista);

	$cantidadTotalEmpresas=$cantEmpresasTCPAcumTotal+$cantEmpresasTCSAcumTotal;

	while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){

		$cantEmpresasTCP=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,39,38,0,0,$vista);
		$cantEmpresasTCPAcum=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,39,38,0,1,$vista);

		$cantEmpresasTCS=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,38,39,0,0,$vista);
		$cantEmpresasTCSAcum=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,38,39,0,1,$vista);

		$totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
		$totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;


		$partAcumulada=0;
		if($cantidadTotalEmpresas>0){
		$partAcumulada=($totalAcumulado/$cantidadTotalEmpresas)*100;                    
		}

		$emparray[]=array("unidad"=>$abrevX, "resultado"=>$partAcumulada);

	}


array_splice($emparray, 0,1);
echo json_encode($emparray);
?>