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


	$sqlN="SELECT e.norma, count(*)as cantidad from ext_certificados e where e.norma not in ('N/A') and YEAR(e.fechaemision)=$anioTemporal and e.idarea=38 group by e.norma order by 2 desc";
	$stmtN = $dbh->prepare($sqlN);
	$stmtN->execute();
	$stmtN->bindColumn('norma', $nombreNorma);
	$stmtN->bindColumn('cantidad', $cantidadNorma);

	while($rowN = $stmtN -> fetch(PDO::FETCH_BOUND)){
	    $cantCertificados=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,$nombreNorma,1);
	    $cantCertificadosTotal=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,'',1);
	    $porcentaje=0;
	    if($cantCertificadosTotal>0){
	    	$porcentaje=($cantCertificados/$cantCertificadosTotal)*100;
	    }
		$emparray[]=array("area"=>$nombreNorma, "resultado"=>$porcentaje);
	}


array_splice($emparray, 0,1);
echo json_encode($emparray);
?>