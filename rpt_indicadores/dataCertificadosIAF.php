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

/*
$mesTemporal=5;
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
	
	$fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
	$fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
	$fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));


	if($vista==1){
		$sqlN="SELECT e.iaf, count(*)as cantidad from ext_certificados e where e.iaf not in ('0') and YEAR(e.fechaemision)=$anioTemporal and e.idarea=38 group by e.iaf order by 2 desc limit 0,10";		
	}else{
		$sqlN="SELECT e.iaf, count(*)as cantidad from ext_certificados e where e.iaf not in ('0') and e.fechaemision<='$fechaVistaIni' and e.fechavalido>='$fechaVistaFin' and e.idarea=38 group by e.iaf order by 2 desc limit 0,10";
	}

	$stmtN = $dbh->prepare($sqlN);
	$stmtN->execute();
	$stmtN->bindColumn('iaf', $codigoIAF);
	$stmtN->bindColumn('cantidad', $cantidadNorma);

	while($rowN = $stmtN -> fetch(PDO::FETCH_BOUND)){
	    $nombreIAF=nameIAF($codigoIAF);
	    $cantCertificados=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,38,$codigoIAF,1,$vista);
	    $cantCertificadosTotal=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,0,1,$vista);
	    $porcentaje=0;
	    if($cantCertificadosTotal>0){
	    	$porcentaje=($cantCertificados/$cantCertificadosTotal)*100;
	    }
		$emparray[]=array("area"=>$nombreIAF, "resultado"=>$porcentaje);
	}


array_splice($emparray, 0,1);
echo json_encode($emparray);
?>