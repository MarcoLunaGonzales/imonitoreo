<?php
require_once 'functions.php';
require_once 'conexion.php';

$dbh = new Conexion();
session_start();


$user=$_POST["idUsuario "];
$keyID=$_POST["key"];


if($keyID=="ZAFHKnDxHQ94CJ6RSgwp"){

	$sql="";
		//SI TIPO LOGIN ES 1 VEMOS SI EXISTE EL USUARIO EN MONITOREO
	$sql="SELECT p.codigo, p.nombre, p.cod_area, p.cod_unidad, pd.perfil from personal2 p, personal_datosadicionales pd where p.codigo=pd.cod_personal and pd.cod_personal='$user'";
	//echo $sql;
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$stmt->bindColumn('codigo', $codigo);
	$stmt->bindColumn('nombre', $nombre);
	$stmt->bindColumn('cod_area', $codArea);
	$stmt->bindColumn('cod_unidad', $codUnidad);
	$stmt->bindColumn('perfil', $perfil);

	while ($rowDetalle = $stmt->fetch(PDO::FETCH_BOUND)) {
		$nombreUnidad=abrevUnidad($codUnidad);
		
		$codAreaTrabajo=buscarAreasAdicionales($codigo, 1);
		if($codAreaTrabajo!="" && $codAreaTrabajo!=0){
			$codAreaTrabajo=substr($codAreaTrabajo, 1); ;
		}
		$codUnidadTrabajo=buscarUnidadesAdicionales($codigo,1);
		if($codUnidadTrabajo!="" && $codUnidadTrabajo!=0){
			$codUnidadTrabajo=substr($codUnidadTrabajo, 1);
		}
		//echo $codAreaTrabajo;

		$nombreArea=abrevArea($codAreaTrabajo);
		$nombreUnidad=abrevUnidad($codUnidadTrabajo);

		//SACAMOS LA GESTION ACTIVA
		$sqlGestion="SELECT cod_gestion FROM gestiones_datosadicionales where cod_estado=1";
		$stmtGestion = $dbh->prepare($sqlGestion);
		$stmtGestion->execute();
		while ($rowGestion = $stmtGestion->fetch(PDO::FETCH_ASSOC)) {
			$codGestionActiva=$rowGestion['cod_gestion'];
		}
		$nombreGestion=nameGestion($codGestionActiva);

		$_SESSION['globalUser']=$codigo;
		$_SESSION['globalNameUser']=$nombre;
		$_SESSION['globalGestion']=$codGestionActiva;
		$_SESSION['globalNombreGestion']=$nombreGestion;


		$_SESSION['globalUnidad']=$codUnidadTrabajo;
		$_SESSION['globalNombreUnidad']=$nombreUnidad;

		$_SESSION['globalArea']=$codAreaTrabajo;
		$_SESSION['globalNombreArea']=$nombreArea;
		$_SESSION['logueado']=1;
		$_SESSION['globalPerfil']=$perfil;
		$_SESSION['globalUserPON']=0;


		if($codigo==183){
			$_SESSION['globalAdmin']=1;			
		}else{
			$_SESSION['globalAdmin']=0;	
		}
		
		if($perfil==1 || $perfil==2 || $perfil==7){
			$arrayUnidadesReports=obtenerUnidadesReport(0);
			$arrayAreasReports=obtenerAreasReport(0);
			$arrayFondosReports=obtenerFondosReport(0);
			$arrayOrganismosReports=obtenerOrganismosReport(0);		
		}
		if($perfil==3 || $perfil==6){
			$arrayUnidadesReports=obtenerUnidadesReport($codUnidadTrabajo);
			$arrayFondosReports=obtenerFondosReport($codUnidadTrabajo);

			if($codAreaTrabajo=="0,78"){
				$arrayAreasReports=obtenerAreasReport(0);
				$arrayOrganismosReports=obtenerOrganismosReport(0);
			}else{
				$arrayAreasReports=obtenerAreasReport($codAreaTrabajo);
				$arrayOrganismosReports=obtenerOrganismosReport($codAreaTrabajo);
			}			
		}
		//echo $codAreaTrabajo;

		$_SESSION['globalUnidadesReports']=$arrayUnidadesReports;
		$_SESSION['globalAreasReports']=$arrayAreasReports;
		$_SESSION['globalOrganismosReports']=$arrayOrganismosReports;
		$_SESSION['globalFondosReports']=$arrayFondosReports;
		$_SESSION['globalServerArchivos']="http://ibnored.ibnorca.org/itranet/documentos/";



		$sIdentificador = "monitoreo";
		$sKey="837b8d9aa8bb73d773f5ef3d160c9b17";
		$datos=array("sIdentificador"=>$sIdentificador, "sKey"=>$sKey, "operacion"=>"Menu", "IdUsuario"=>$codigo);
		$datos=json_encode($datos);
		$ch = curl_init();
		//curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno19/verifica/ws-user-personal.php");
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/verifica/ws-user-personal.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		curl_close ($ch);
		//header('Content-type: application/json');   
		//print_r($remote_server_output);       
		$obj=json_decode($remote_server_output);
		$_SESSION['globalMenuJson']=$obj;

	}
	header("location:index.php");
}
else{
	header("location:error.html");
}


?>