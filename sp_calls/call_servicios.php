<?php

set_time_limit(0);
require_once '../conexionExtIbnorca.php';
require_once '../conexion.php';
$dbhExterno = new ConexionExterno();
$dbh = new Conexion();

echo "<h3>Hora Inicio Proceso Servicios: " . date("Y-m-d H:i:s")."</h3>";


$sql = 'CALL cubo_servicios4()';
$query = $dbhExterno->query($sql);
$query -> setFetchMode(PDO::FETCH_ASSOC);

$insert_str="";
$indice=1;

$sqlDelete = 'delete from ext_servicios';
$stmtDelete = $dbh->prepare($sqlDelete);
$flagSuccess=$stmtDelete->execute();

while($resp = $query->fetch()){
	$idClaServicio=$resp['IdClaServicio'];
	$d_tipo=$resp['d_Tipo'];
	$idOficina=$resp['IdOficina'];
	$idArea=$resp['IdArea'];
	$cantidad=$resp['cantidad'];
	$total_cotizado=$resp['total_cotizado'];
	$idCliente=$resp['IdCliente'];
	$idServicio=$resp['IdServicio'];
	$fechaRegistro=$resp['FechaRegistro'];
	$estadoServicio=$resp['estadoServicio'];
	$Mt_Facturado=$resp['Mt_Facturado'];
	$fechaEstadofactura=$resp['fechaEstadofactura'];
	$nroServicio=$resp['Nro_Servicio'];
	$idCotizacion=$resp['IdCotizacion'];
	$estadoFactura=$resp['estadoFactura'];
	$datosFactura=$resp['DatosFactura'];

	$insert_str .= "('$indice','$idClaServicio','$d_tipo','$idOficina','$idArea','$cantidad','$total_cotizado','$idCliente','$idServicio','$fechaRegistro','$estadoServicio','$Mt_Facturado','$fechaEstadofactura','$nroServicio','$idCotizacion','$estadoFactura','$datosFactura'),";	

	if($indice%100==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_servicios (codigo, idclaservicio, d_tipo, id_oficina, id_area, cantidad, total_cotizado, id_cliente, id_servicio, fecha_registro, estado_servicio, monto_facturado, fecha_factura, nro_servicio, id_cotizacion, estado_factura, datos_factura) values ".$insert_str.";";
		//echo $sqlInserta;
		$stmtInsert=$dbh->prepare($sqlInserta);
		$flagSuccess=$stmtInsert->execute();
		$insert_str="";
	}
	if($flagSuccess==FALSE){
      echo "*****************ERROR*****************";
      echo $sqlInserta."<br>";
      break;
    }
    if($indice%100==0){
      echo "vamos $indice <br>";
    }
	$indice++;
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_servicios (codigo, idclaservicio, d_tipo, id_oficina, id_area, cantidad, total_cotizado, id_cliente, id_servicio, fecha_registro, estado_servicio, monto_facturado, fecha_factura, nro_servicio, id_cotizacion, estado_factura, datos_factura) values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();

echo "<h3>Hora Fin Proceso Servicios: " . date("Y-m-d H:i:s")."</h3>";
?>