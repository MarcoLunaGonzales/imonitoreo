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


/*$mesTemporal=4;
$anioTemporal=2019;
$codAreaTemporal=13;*/

$codOrganismo=obtenerOrganismosReport($codAreaTemporal);

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

$sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
$stmtU = $dbh->prepare($sqlU);
$stmtU->execute();
$stmtU->bindColumn('codigo', $codigoX);
$stmtU->bindColumn('abreviatura', $abrevX);

while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
	$codFondo=obtenerFondosReport($codigoX);

	$ingresosMes=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
	$ingresosMesAcum=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);
	$egresosMes=ejecutadoEgresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
	$egresosMesAcum=ejecutadoEgresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);
	$resultado=$ingresosMes-$egresosMes;
	$resultadoAcum=$ingresosMesAcum-$egresosMesAcum;

	$emparray[]=array("unidad"=>$abrevX, "resultado"=>$resultado, "resultadoAcum"=>$resultadoAcum);

}
array_splice($emparray, 0,1);
echo json_encode($emparray);
?>