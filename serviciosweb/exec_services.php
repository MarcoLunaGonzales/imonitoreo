<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";



//SERVICIOS TLQ
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"403");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="servicios_tlq";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok servicios tlq<br>";


?>