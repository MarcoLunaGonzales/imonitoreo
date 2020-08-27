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

header('Content-type: application/json'); 	
print_r($json);


?>