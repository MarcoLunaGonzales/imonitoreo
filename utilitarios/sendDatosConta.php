<?php
set_time_limit(0);
error_reporting(-1);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"DATOSCONTA.csv\""); 

//require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

session_start();

$gestion=$_POST["gestion"];
$nombreGestion=nameGestion($gestion);

$mes=$_POST["mes"];
$mesString=implode(",", $mes);

$sql="SELECT p.indice, p.fondo, (select pf.abreviatura from po_fondos pf where pf.codigo=p.fondo) as nombrefondo, p.anio, p.mes, p.fecha, p.cta_n1, p.cta_n2, p.cta_n3, p.cta_n4, p.cuenta, 
	(select pp.nombre from po_plancuentas pp where pp.codigo=p.cuenta) as nombrecuenta, 
	p.partida, p.monto, p.organismo, (select po.nombre from po_organismos po where po.codigo=p.organismo)as nombreorganismo, p.ml_partida, p.glosa, p.glosa_detalle from po_mayores p where p.anio='$nombreGestion' and p.mes in ($mesString)";

//echo $sql;


$stmt = $dbh->prepare($sql);
$stmt->execute();
$stmt->bindColumn('indice', $indice);
$stmt->bindColumn('fondo', $fondo);
$stmt->bindColumn('nombrefondo', $nombrefondo);
$stmt->bindColumn('anio', $anio);
$stmt->bindColumn('mes', $mes);
$stmt->bindColumn('fecha', $fecha);
$stmt->bindColumn('cta_n1', $cta_n1);
$stmt->bindColumn('cta_n2', $cta_n2);
$stmt->bindColumn('cta_n3', $cta_n3);
$stmt->bindColumn('cta_n4', $cta_n4);
$stmt->bindColumn('cuenta', $cuenta);
$stmt->bindColumn('nombrecuenta', $nombrecuenta);
$stmt->bindColumn('partida', $partida);
$stmt->bindColumn('monto', $monto);
$stmt->bindColumn('organismo', $organismo);
$stmt->bindColumn('nombreorganismo', $nombreorganismo);
$stmt->bindColumn('ml_partida', $ml_partida);
$stmt->bindColumn('glosa_detalle', $glosa_detalle);


echo "indice;fondo;nombrefondo;anio;mes;fecha;cta_n1;cta_n2;cta_n3;cta_n4;cuenta;nombrecuenta;partida;debe;haber;organismo;nombreorganismo;ml_partida;glosa_detalle;accnum;externalcost";
echo "\r\n";

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {

	$debe=0;
	$haber=0;
	if($monto>0){
		$debe=$monto;
	}else{
		$haber=$monto;
		$haber=$haber*(-1);
	}
	//SACAMOS EL ACCNUM
	
	$glosaComparar=string_sanitize($glosa_detalle);               
    $sqlVerifica="SELECT cod_externalcost from gastos_externalcosts where fecha='$fecha' and ml_partida='$ml_partida' and glosa_detalle='$glosaComparar'";
    //echo $sqlVerifica;
    $stmtVerifica = $dbh->prepare($sqlVerifica);
    $stmtVerifica->execute();
    $codigoAccX=0;
    while ($rowVerifica = $stmtVerifica->fetch(PDO::FETCH_ASSOC)) {
       $codigoAccX=$rowVerifica['cod_externalcost'];
    }
    $abrevAccX=abrevAccNum($codigoAccX);
    $nombreAccX=nameAccNum($codigoAccX);
	
	echo "$indice;$fondo;$nombrefondo;$anio;$mes;$fecha;$cta_n1;$cta_n2;$cta_n3;$cta_n4;$cuenta;$nombrecuenta;$partida;$debe;$haber;$organismo;$nombreorganismo;$ml_partida;$glosa_detalle;$abrevAccX;$nombreAccX";	
	echo "\r\n";
	
}


?>
