<?php
set_time_limit(0);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"DATOSPO.csv\""); 

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
//$version=$_POST["version"];
$version=0;

if($version==0){
	$tabla1="po_presupuesto";
}else{
	$tabla1="po_presupuesto_version";
}

$sql="SELECT p.cod_cuenta, (select pc.nombre from po_plancuentas pc where pc.codigo=p.cod_cuenta)as cuenta, p.cod_fondo, 
(select pf.abreviatura from po_fondos pf where pf.codigo=p.cod_fondo)as unidad, p.cod_organismo, 
(select po.nombre from po_organismos po where po.codigo=p.cod_organismo)as area from po_presupuesto p 
where p.cod_gestion='$gestion' ";

if($version!=0){
	$sql.=" and p.cod_version='$version' ";
}
$sql.=" group by cod_cuenta, cuenta, cod_fondo, area, cod_organismo, unidad order by cod_cuenta, area, unidad";

//echo $sql;

$stmt = $dbh->prepare($sql);
$stmt->execute();
$stmt->bindColumn('cod_cuenta', $codCuenta);
$stmt->bindColumn('cuenta', $nombreCuenta);
$stmt->bindColumn('cod_fondo', $codFondo);
$stmt->bindColumn('unidad', $nombreFondo);
$stmt->bindColumn('cod_organismo', $codOrganismo);
$stmt->bindColumn('area', $nombreOrganismo);

echo "gestion;codcuenta;cuenta;codunidad;unidad;codarea;area;ene;feb;mar;abril;may;junio;julio;ago;sept;oct;nov;dic";	
echo "\r\n";

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {

	$txt="$gestion;$codCuenta;$nombreCuenta;$codFondo;$nombreFondo;$codOrganismo;$nombreOrganismo;";	
	
	for($i=1;$i<=12;$i++){
		
		$banderaPlani=0;
		if($version==0){
			$sqlRecupera="SELECT sum(p.monto)as monto from po_presupuesto p where p.cod_gestion='$gestion' and p.cod_fondo='$codFondo' and p.cod_organismo='$codOrganismo' and p.cod_mes='$i' ";
			//echo $sqlRecupera;
			$stmtRecupera = $dbh->prepare($sqlRecupera);
			$stmtRecupera->execute();
			$valorPlanificacion=0;
			while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
				$valorPlanificacion=$rowRec['monto'];
				$txt.=$valorPlanificacion.";";
				//echo "version 0=".$valorPlanificacion;
				$banderaPlani=1;
			}
		}
		if($banderaPlani==0){
			$txt.="0;";
		}		 	
	}
	$txt.="\r\n";
	echo $txt;
}


?>
