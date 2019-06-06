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
$codAreaTemporal=13;
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

$cadenaUnidades=obtieneValorConfig(11);
$tipoCursoCorto=obtieneValorConfig(12);
$tipoCursoEspecialista=obtieneValorConfig(13);

$sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
$stmtU = $dbh->prepare($sqlU);
$stmtU->execute();
$stmtU->bindColumn('codigo', $codigoX);
$stmtU->bindColumn('abreviatura', $abrevX);

while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){

	$numeroCursos1=cursosPorUnidad($codigoX,$anioTemporal,$mesTemporal,0,$tipoCursoCorto);
	$numeroCursos2=cursosPorUnidad($codigoX,$anioTemporal,$mesTemporal,0,$tipoCursoEspecialista);
	
	$emparray[]=array("unidad"=>$abrevX, "curso1"=>$numeroCursos1, "curso2"=>$numeroCursos2);

}
array_splice($emparray, 0,1);
echo json_encode($emparray);
?>