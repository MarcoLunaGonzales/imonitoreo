<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";



//SERVICIOS TLQ
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"Niveles", "padre"=>"80");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";

$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM servicios_oi_detalle");
$flagDel=$stmtDel->execute();

$stmtDel=$dbh->prepare("DELETE FROM servicios_tlq_detalle");
$flagDel=$stmtDel->execute();

$stmtDel=$dbh->prepare("DELETE FROM servicios_tcp_detalle");
$flagDel=$stmtDel->execute();


$detalle=$obj->listaNivel1;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$idPadreX=$objDet->IdPadre;
	$estadoX="1";

	echo $codigoX." ".$nombreX." ".$abreviaturaX." ".$idPadreX."<br>";

	if($codigoX==107){
		$detalleNivel2=$objDet->ListaNivel2;
		foreach ($detalleNivel2 as $objDetN2){
			$codigoY=$objDetN2->IdClasificador;
			$nombreY=strtoupper(clean_string($objDetN2->Descripcion));
			echo "detalle Nivel 2 ".$codigoY." ".$nombreY."<br>";
			
			$detalleNivel3=$objDetN2->ListaNivel3;
			foreach($detalleNivel3 as $objDetN3){
				$codigoZ=$objDetN3->IdClaServicio;
				$nombreZ=$objDetN3->Descripcion;
				echo "Nivel 3: ".$codigoZ." ".$nombreZ."<br>";
				
				$stmt = $dbh->prepare("INSERT INTO servicios_oi_detalle (codigo, nombre, cod_servicio) VALUES (:codigo, :nombre, :cod_serviciooi)");
				$stmt->bindParam(':codigo', $codigoZ);
				$stmt->bindParam(':nombre', $nombreZ);
				$stmt->bindParam(':cod_serviciooi', $codigoY);
				$flagSuccess=$stmt->execute();
			}				
		}
	}


	if($codigoX==403){
		$detalleNivel2=$objDet->ListaNivel2;
		foreach ($detalleNivel2 as $objDetN2){
			$codigoY=$objDetN2->IdClasificador;
			$nombreY=strtoupper(clean_string($objDetN2->Descripcion));
			echo "detalle Nivel 2 ".$codigoY." ".$nombreY."<br>";
			
			$detalleNivel3=$objDetN2->ListaNivel3;
			foreach($detalleNivel3 as $objDetN3){
				$codigoZ=$objDetN3->IdClaServicio;
				$nombreZ=$objDetN3->Descripcion;
				echo "Nivel 3: ".$codigoZ." ".$nombreZ."<br>";
				
				$stmt = $dbh->prepare("INSERT INTO servicios_tlq_detalle (codigo, nombre, cod_servicio) VALUES (:codigo, :nombre, :cod_serviciooi)");
				$stmt->bindParam(':codigo', $codigoZ);
				$stmt->bindParam(':nombre', $nombreZ);
				$stmt->bindParam(':cod_serviciooi', $codigoY);
				$flagSuccess=$stmt->execute();
			}				
		}
	}

	if($codigoX==108){
		$detalleNivel2=$objDet->ListaNivel2;
		foreach ($detalleNivel2 as $objDetN2){
			$codigoY=$objDetN2->IdClasificador;
			$nombreY=strtoupper(clean_string($objDetN2->Descripcion));
			echo "detalle Nivel 2 ".$codigoY." ".$nombreY."<br>";
			
			$detalleNivel3=$objDetN2->ListaNivel3;
			foreach($detalleNivel3 as $objDetN3){
				$codigoZ=$objDetN3->IdClaServicio;
				$nombreZ=$objDetN3->Descripcion;
				echo "Nivel 3: ".$codigoZ." ".$nombreZ."<br>";
				
				$stmt = $dbh->prepare("INSERT INTO servicios_tcp_detalle (codigo, nombre, cod_servicio) VALUES (:codigo, :nombre, :cod_serviciooi)");
				$stmt->bindParam(':codigo', $codigoZ);
				$stmt->bindParam(':nombre', $nombreZ);
				$stmt->bindParam(':cod_serviciooi', $codigoY);
				$flagSuccess=$stmt->execute();
			}				
		}
	}

	if($codigoX==109){
		$detalleNivel2=$objDet->ListaNivel2;
		foreach ($detalleNivel2 as $objDetN2){
			$codigoY=$objDetN2->IdClasificador;
			$nombreY=strtoupper(clean_string($objDetN2->Descripcion));
			echo "detalle Nivel 2 ".$codigoY." ".$nombreY."<br>";
			
			$detalleNivel3=$objDetN2->ListaNivel3;
			foreach($detalleNivel3 as $objDetN3){
				$codigoZ=$objDetN3->IdClaServicio;
				$nombreZ=$objDetN3->Descripcion;
				echo "Nivel 3: ".$codigoZ." ".$nombreZ."<br>";
				
				$stmt = $dbh->prepare("INSERT INTO servicios_tcs_detalle (codigo, nombre, cod_servicio) VALUES (:codigo, :nombre, :cod_serviciooi)");
				$stmt->bindParam(':codigo', $codigoZ);
				$stmt->bindParam(':nombre', $nombreZ);
				$stmt->bindParam(':cod_serviciooi', $codigoY);
				$flagSuccess=$stmt->execute();
			}				
		}
	}

	
}

echo "FIN CARGAR SERVICIOS NIVEL 3 OI, TCP, TCS y TLQ<br>";


?>