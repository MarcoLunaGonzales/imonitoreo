<?php

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"DATOSPOA.csv\""); 

//require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();

$gestion=$_POST["gestion"];
$nombreGestion=nameGestion($gestion);

$sql="SELECT p.nombre as perspectiva, o.codigo as codObjetivo, o.abreviatura as abrevObjetivo, o.nombre as nombreObjetivo, i.codigo as codIndicador, 
i.nombre as nombreIndicador, a.codigo as codActividad, a.nombre as nombreActividad, 
(SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(SELECT t.abreviatura from tipos_seguimiento t where t.codigo=a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area, (select u.nombre from unidades_organizacionales u where u.codigo=a.cod_unidadorganizacional)as unidad, (select aa.nombre from areas aa where aa.codigo=a.cod_area)as area
from actividades_poa a, indicadores i, objetivos o, perspectivas p where a.cod_estado=1 and 
 a.cod_indicador=i.codigo and i.cod_objetivo=o.codigo and p.codigo=o.cod_perspectiva and a.cod_gestion='$gestion' ";
// echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stmt->bindColumn('perspectiva', $perspectiva);
$stmt->bindColumn('codObjetivo', $codObjetivo);
$stmt->bindColumn('abrevObjetivo', $abrevObjetivo);
$stmt->bindColumn('nombreObjetivo', $nombreObjetivo);
$stmt->bindColumn('codIndicador', $codIndicador);
$stmt->bindColumn('nombreIndicador', $nombreIndicador);
$stmt->bindColumn('codActividad', $codActividad);
$stmt->bindColumn('nombreActividad', $nombreActividad);
$stmt->bindColumn('normapriorizada', $normapriorizada);
$stmt->bindColumn('sectorpriorizado', $sectorpriorizado);
$stmt->bindColumn('norma', $norma);
$stmt->bindColumn('sector', $sector);
$stmt->bindColumn('tipodato', $tipodato);
$stmt->bindColumn('producto_esperado', $producto_esperado);
$stmt->bindColumn('cod_unidadorganizacional', $cod_unidadorganizacional);
$stmt->bindColumn('cod_area', $cod_area);
$stmt->bindColumn('unidad', $unidad);
$stmt->bindColumn('area', $area);

echo "perspectiva;codObjetivo;abrevObjetivo;nombreObjetivo;codIndicador;nombreIndicador;codActividad;nombreActividad;normapriorizada;sectorpriorizado;norma;sector;tipodato;producto_esperado;cod_unidadorganizacional;cod_area;unidad;area;eneP;eneE;eneDesc;febP;febE;febDesc;marP;marE;marDesc;abrP;abrE;abrDesc;mayP;mayE;mayDesc;junP;junE;junDesc;julP;julE;julDesc;agoP;agoE;agoDesc;sepP;sepE;sepDesc;octP;octE;octDesc;novP;novE;novDesc;dicP;dicE;dicDesc";	
echo "\r\n";

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
    $nombreActividad=clean_string($nombreActividad);
    $nombreActividad=addslashes($nombreActividad);

    $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
    $reemplazar=array("", "", "", "");
    $nombreActividad=str_ireplace($buscar,$reemplazar,$nombreActividad);



	$txt="$perspectiva;$codObjetivo;$abrevObjetivo;$nombreObjetivo;$codIndicador;$nombreIndicador;$codActividad;$nombreActividad;$normapriorizada;$sectorpriorizado;$norma;$sector;$tipodato;$producto_esperado;$cod_unidadorganizacional;$cod_area;$unidad;$area;";	
	for($i=1;$i<=12;$i++){
		$sqlRecupera="SELECT value_numerico from actividades_poaplanificacion where cod_actividad=:cod_actividad and mes=:cod_mes";
		$stmtRecupera = $dbh->prepare($sqlRecupera);
		$stmtRecupera->bindParam(':cod_actividad',$codActividad);
		$stmtRecupera->bindParam(':cod_mes',$i);
		$stmtRecupera->execute();
		$valorPlanificacion=0;
		while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
			$valorPlanificacion=$rowRec['value_numerico'];
			$txt.=$valorPlanificacion.";";
		} 	

		$sqlRecupera="SELECT value_numerico, descripcion from actividades_poaejecucion where cod_actividad=:cod_actividad and mes=:cod_mes";
		$stmtRecupera = $dbh->prepare($sqlRecupera);
		$stmtRecupera->bindParam(':cod_actividad',$codActividad);
		$stmtRecupera->bindParam(':cod_mes',$i);
		$stmtRecupera->execute();
		$valorEjecucion=0;
		$descripcionEj="";
		while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
			$valorEjecucion=$rowRec['value_numerico'];
			$descripcionEj=$rowRec['descripcion'];
		} 	
    	$descripcionEj=clean_string($descripcionEj);
		$descripcionEj=addslashes($descripcionEj);
		$buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
		$reemplazar=array("", "", "", "");
		$descripcionEj=str_ireplace($buscar,$reemplazar,$descripcionEj);

		$txt.=$valorEjecucion.";".$descripcionEj.";";
	}
	$txt.="\r\n";
	echo $txt;
}


?>
