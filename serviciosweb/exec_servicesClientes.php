<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";



//CLIENTES
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"Clientes"); 
$url="http://ibnored.ibnorca.org/wsibno/cliente/ws-cliente-listas.php";
$tableInsert="clientes";
$json=callService($parametros, $url);
$obj=json_decode($json);


$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdCliente;
	$nombreX=strtoupper(clean_string($objDet->NombreRazon));
	$idCiudad=strtoupper($objDet->IdCiudad);
	$estadoX="1";

	//sacamos la unidad para insertar
	$stmt = $dbh->prepare("SELECT codigo, nombre, cod_unidad FROM ciudades where codigo=:codigo");
	$stmt->bindParam(':codigo',$idCiudad);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$codigoUnidadX=$row['cod_unidad'];
	}

	$sqlInsert="INSERT INTO $tableInsert (codigo, nombre, cod_estado, cod_unidad) VALUES ('$codigoX', '$nombreX', '$estadoX','$codigoUnidadX')";
	echo $sqlInsert;
	$stmt = $dbh->prepare($sqlInsert);
	$flagSuccess=$stmt->execute();

	echo $flagSuccess."<br>";
}
echo "ok Clientes<br>";


?>