<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";

//SERVICIOS TLQ
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"109", "todos"=>1);
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";


/*$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"Clientes"); 
$url="http://ibnored.ibnorca.org/wsibno/cliente/ws-cliente-listas.php";
*/

//$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"45");//oficinas
//$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"107");//areas
//$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";

// $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"6");
// $url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";

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