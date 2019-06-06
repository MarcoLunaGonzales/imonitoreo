<?php

require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

header('Content-Type: application/json');
set_time_limit(0);

$dbh = new Conexion();

session_start();


$mesTemporal=$_SESSION["mesTemporal"];
$anioTemporal=$_SESSION["anioTemporal"];
$codIndicador=$_SESSION["codIndicador"];
$codUnidadTemporal=$_GET["codUnidadX"];

/*$mesTemporal=4;
$anioTemporal=2019;
$codIndicador=24;
//$codAreaTemporal=39;
$codUnidadTemporal=4;
*/


	function utf8json($inArray) { 
	static $depth = 0; 
		/* our return object */ 
		$newArray = array(); 
		/* safety recursion limit */ 
		$depth ++; 
		if($depth >= '1000000') { 
			return false; 
		} 
		/* step through inArray */ 
		foreach($inArray as $key=>$val) { 
			if(is_array($val)) { 
				/* recurse on array elements */ 
				$newArray[$key] = utf8json($val); 
			} else { 
				/* encode string values */ 
				$newArray[$key] = utf8_encode($val); 
			} 
		} 
		/* return utf8 encoded array */ 
		return $newArray; 
	}
	
	$emparray[] = array();

 	$sqlArea="SELECT iua.cod_area FROM objetivos o, indicadores i, indicadores_unidadesareas iua WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and i.codigo in ($codIndicador) and iua.cod_unidadorganizacional in ($codUnidadTemporal) and i.codigo=iua.cod_indicador";
        /*if($globalAdmin==0){
          $sql.=" and iua.cod_area in ($globalArea) and iua.cod_unidadorganizacional in ($globalUnidad) ";
         }*/
    $sqlArea.=" group by iua.cod_area";
    //echo $sqlArea;
    $stmtArea = $dbh->prepare($sqlArea);
    $stmtArea->execute();
    $stmtArea->bindColumn('cod_area', $codAreaX);
    while($rowArea=$stmtArea->fetch(PDO::FETCH_BOUND)){
	    $abrevArea=abrevArea($codAreaX);
	    $codAreaTemporal=$codAreaX;

		$planificadoMes=round(planificacionPorIndicador($codIndicador,$codAreaTemporal,$codUnidadTemporal,$mesTemporal,1));
      	$ejecutadoMes=round(ejecucionPorIndicador($codIndicador,$codAreaTemporal,$codUnidadTemporal,$mesTemporal,1));
      	$porcentajeMes=0;
      	if($planificadoMes>0){
      		$porcentajeMes=($ejecutadoMes/$planificadoMes)*100;
      	}

  	  	$planificadoGestion=round(planificacionPorIndicador($codIndicador,$codAreaTemporal,$codUnidadTemporal,12,1));
      	$ejecutadoGestion=round(ejecucionPorIndicador($codIndicador,$codAreaTemporal,$codUnidadTemporal,12,1));
      	$porcentajeGestion=0;
      	if($planificadoGestion>0){
      		$porcentajeGestion=($ejecutadoGestion/$planificadoGestion)*100;
      	}      	
  	  	$emparray[]=array("area"=>$abrevArea,"porcentajemes"=>$porcentajeMes, "porcentajegestion"=>$porcentajeGestion);
	}

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>