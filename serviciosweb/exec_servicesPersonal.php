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
	$idCliente=$objDet->IdCliente;


	if($codigoX=="" || $codigoX==0){
		$codigoX=$idCliente;
	}

	$sql="INSERT INTO $tableInsert (codigo, nombre, cod_area, cod_unidad, cod_usuario, cod_personal) VALUES (:codigo, :nombre, :cod_area, :cod_unidad, :cod_usuario, :cod_personal)";
	$stmt = $dbh->prepare($sql);
	$values = array( ':codigo' => $codigoX,
        ':nombre' => $nombreX,
        ':cod_area' => $idArea,
        ':cod_unidad' => $idOficina,
        ':cod_usuario' => $idUsuario,
        ':cod_personal' => $idPersonal
    	);

	$exQuery=str_replace(array_keys($values), array_values($values), $sql);
	
	//echo $exQuery;

	$flagSuccess=$stmt->execute($values);
}
echo "ok PERSONAL<br>";


?>