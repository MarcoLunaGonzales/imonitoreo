<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";

//PERSONAL
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey,"accion"=>"ListarPersonal");
$url="http://ibnored.ibnorca.org/wsibno/lista/ws-lst-personal.php";

$tableInsert="personal2";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdPersonal;
	$nombreX=strtoupper(clean_string($objDet->NombreApellido));
	$idArea=$objDet->IdArea;
	$idOficina=$objDet->IdOficina;
	$cargo=$objDet->Cargo;
	$idUsuario=$objDet->IdUsuario;
	$idPersonal=$objDet->IdPersonal;

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, cod_area, cod_unidad, cod_usuario, cod_personal) VALUES (:codigo, :nombre, :cod_area, :cod_unidad, :cod_usuario, :cod_personal)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':cod_area', $idArea);
	$stmt->bindParam(':cod_unidad', $idOficina);
	$stmt->bindParam(':cod_usuario', $idUsuario);
	$stmt->bindParam(':cod_personal', $idPersonal);
	$flagSuccess=$stmt->execute();
}
echo "ok PERSONAL<br>";


?>