<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";

//SERVICIOS TLQ
/*$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"Niveles", "padre"=>"80");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
*/

$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey,"accion"=>"ListarPersonal");
$url="http://ibnored.ibnorca.org/wsibno/lista/ws-lst-personal.php";

$json=callService($parametros, $url);

/*echo "entrando json:";

$obj=json_decode($json);
$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdCliente;
	$nombreX=strtoupper(clean_string($objDet->NombreCliente));
	$idCiudad=strtoupper($objDet->IdCiudad);
	$estadoX="1";

	echo $codigoX." ".$nombreX."<br>";

}*/


// imprimir en formato JSON
header('Content-type: application/json'); 	
print_r($json);

?>