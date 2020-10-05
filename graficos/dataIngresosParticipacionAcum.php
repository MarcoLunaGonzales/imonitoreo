<?php
header('Content-Type: application/json');
set_time_limit(0);

session_start();

require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';

$areasValorConfig=0;
$areasValorConfig=obtieneValorConfig(29);

$fondoTemporal=$_SESSION["fondoTemporal"];
$nombreFondo=$_SESSION["nombreFondoTemporal"];
$mesTemporal=$_SESSION["mesTemporal"];
$anioTemporal=$_SESSION["anioTemporal"];
$organismoTemporal=$_SESSION["organismoTemporal"];
$organismoTemporalAgrupado=$_SESSION["organismoTemporalAgrupado"];
$acumuladoTemporal=$_GET["acumuladoTemporal"];  
$nombreTemporalAgrupado=$_SESSION["nombreTemporalAgrupado"];
$fondo1=$fondoTemporal;
$nameFondo1=$nombreFondo;


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
    
    $organismoTemporalArray = explode(",",$organismoTemporal);
    
    if($acumuladoTemporal==0){
       for($i=0;$i<count($organismoTemporalArray);$i++){
	  	$montoPresIngreso1=round(presupuestoIngresosMes($fondo1,$anioTemporal,$mesTemporal,$organismoTemporalArray[$i],1,0));
		$montoEjIngreso1=round(ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,$organismoTemporalArray[$i],1,0));
		$montoEjTotal=round(ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,0,1,0));

		$participacionPorcent=0;
		if($montoEjTotal>0){
		  $participacionPorcent=($montoEjIngreso1*100)/$montoEjTotal;	
		}
		$nombreOrganismo=nameOrganismo($organismoTemporalArray[$i]);		
		$emparray[]=array("nombreOrganismo"=>$nombreOrganismo, "montoIngresoTotal"=>$montoEjIngreso1,"participacionPorcent"=>number_format($participacionPorcent,0,',',''));
	 }
    }else{
      for($i=0;$i<count($organismoTemporalArray);$i++){
      	if ($organismoTemporalArray[$i]=="503"||$organismoTemporalArray[$i]=="505"||$organismoTemporalArray[$i]=="506"||$organismoTemporalArray[$i]=="507") {
      		
      	}else{
      		$montoPresIngreso1=round(presupuestoIngresosMes($fondo1,$anioTemporal,$mesTemporal,$organismoTemporalArray[$i],1,0));
		   $montoEjIngreso1=round(ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,$organismoTemporalArray[$i],1,0));
		   $montoEjTotal=round(ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,0,1,0));

		   $participacionPorcent=0;
		   if($montoEjTotal>0){
		     $participacionPorcent=($montoEjIngreso1*100)/$montoEjTotal;	
		   }
		  $nombreOrganismo=nameOrganismo($organismoTemporalArray[$i]);		
		  $emparray[]=array("nombreOrganismo"=>$nombreOrganismo, "montoIngresoTotal"=>$montoEjIngreso1,"participacionPorcent"=>number_format($participacionPorcent,0,',','')); 
      	}
	 }

	 $montoPresIngreso1=round(presupuestoIngresosMes($fondo1,$anioTemporal,$mesTemporal,$organismoTemporalAgrupado,1,0));
	 $montoEjIngreso1=round(ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,$organismoTemporalAgrupado,1,0));
	 $montoEjTotal=round(ejecutadoIngresosMes($fondo1,$anioTemporal,$mesTemporal,0,1,0));

     $participacionPorcent=0;
	 if($montoEjTotal>0){
		     $participacionPorcent=($montoEjIngreso1*100)/$montoEjTotal;	
	 }
	 $nombreOrganismo=$nombreTemporalAgrupado;		
	 $emparray[]=array("nombreOrganismo"=>$nombreOrganismo, "montoIngresoTotal"=>$montoEjIngreso1,"participacionPorcent"=>number_format($participacionPorcent,0,',',''));

    }
	 

array_splice($emparray, 0,1);
	//echo json_encode(utf8json($emparray));
echo json_encode($emparray);

?>