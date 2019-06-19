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
$codUnidadTemporal=$_GET["codUnidadX"];


/*$mesTemporal=4;
$anioTemporal=2019;
$codAreaTemporal=13;
$codUnidadTemporal=9;
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


$sqlC="SELECT distinct(e.tipo)as tipo from ext_cursos e order by 1";
$stmtC = $dbh->prepare($sqlC);
$stmtC->execute();
$stmtC->bindColumn('tipo', $tipoCurso);
$totalCursos=0;
while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
  	$tipoCursoX=$tipoCurso;
	$numeroCursos=cursosPorUnidad($codUnidadTemporal,$anioTemporal,$mesTemporal,0,$tipoCursoX);

	$emparray[]=array("tipocurso"=>$tipoCursoX, "curso1"=>$numeroCursos);
}
array_splice($emparray, 0,1);
echo json_encode($emparray);

?>