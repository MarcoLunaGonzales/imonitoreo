<?php

require_once 'functions.php';
require_once 'conexion.php';

session_start();

date_default_timezone_set('America/La_Paz');

$dbh = new Conexion();
$user=$_POST["user"];
$password=$_POST["password"];

//OBTENEMOS EL VALOR DE LA CONFIGURACION 1 -> LOGIN PROPIO DE MONITOREO    2-> LOGIN POR SERVICIO WEB
$tipoLogin=obtieneValorConfig(-1);

//echo $tipoLogin;

//echo "hola";

$banderaLogin=0;

if($tipoLogin==2){
	
	$sIdentificador = "monitoreo";
	$sKey="837b8d9aa8bb73d773f5ef3d160c9b17";
	$nombreuser=$user;
	$claveuser=md5($password);
	$datos=array("sIdentificador"=>$sIdentificador, "sKey"=>$sKey, 
		"operacion"=>"Login", "nombreUser"=>$nombreuser, "claveUser"=>$claveuser);
	$datos=json_encode($datos);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/verifica/ws-user-personal.php");
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$remote_server_output = curl_exec ($ch);
	curl_close ($ch);
	$obj=json_decode($remote_server_output);

	$banderaLogin=$obj->estado;
	$idUsuarioSW=$obj->usuario->IdUsuario;

	//echo "codigo: ".$idUsuarioSW;
}


if($banderaLogin==1 || $tipoLogin==1){

	$sql="";
	if($tipoLogin==1){
		//SI TIPO LOGIN ES 1 VEMOS SI EXISTE EL USUARIO EN MONITOREO
		$sql="SELECT p.codigo, p.nombre, p.cod_area, p.cod_unidad, pd.perfil, 1 as cod_usuario from personal2 p, personal_datosadicionales pd where p.codigo=pd.cod_personal and pd.usuario='$user' and pd.contrasena='$password'";
	}else{
		$sql="SELECT p.codigo, p.nombre, p.cod_area, p.cod_unidad, 1 as perfil, p.cod_usuario from personal2 p 
		where p.cod_usuario='$idUsuarioSW'";
	}

	//echo $sql;
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$stmt->bindColumn('codigo', $codigo);
	$stmt->bindColumn('nombre', $nombre);
	$stmt->bindColumn('cod_area', $codArea);
	$stmt->bindColumn('cod_unidad', $codUnidad);
	$stmt->bindColumn('perfil', $perfil);
	$stmt->bindColumn('cod_usuario', $codUsuario);

	while ($rowDetalle = $stmt->fetch(PDO::FETCH_BOUND)) {
		$nombreUnidad=abrevUnidad($codUnidad);
		
		$codAreaTrabajo=buscarAreasAdicionales($codigo, 1);
		//echo $codAreaTrabajo."codareatrab";
		if($codAreaTrabajo!="" && $codAreaTrabajo!=0){
			//$codAreaTrabajo=substr($codAreaTrabajo, 1); ;
		}
		$codUnidadTrabajo=buscarUnidadesAdicionales($codigo,1);
		if($codUnidadTrabajo!="" && $codUnidadTrabajo!=0){
			//$codUnidadTrabajo=substr($codUnidadTrabajo, 1);
		}
		//echo "area unidad: ".$codAreaTrabajo." ".$codUnidadTrabajo;

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

		if($idUsuarioSW==49299){
			$codGestionActiva=1205;
			$nombreGestion="2020";
			$codMesActiva=12;
			$codUnidad=3000;
			$nombreUnidad="SIS";
		}
		
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
		$_SESSION['globalProyecto']='';


		if($codigo==90 || $codigo==332 || $codigo==195){
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
		$datos=array("sIdentificador"=>$sIdentificador, "sKey"=>$sKey, "operacion"=>"Menu", "IdUsuario"=>$codUsuario);
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
	//INSERTAMOS LA FECHA Y HORA DE SESSION
	$fechaHoraActual=date("Y-m-d H:i:s");
	$sqlInsertUserConnect="INSERT usuarios_conectados(cod_personal, fecha) values ('$codigo','$fechaHoraActual')";
	$stmtInsert = $dbh->prepare($sqlInsertUserConnect);
	$stmtInsert->execute();
}

header("location:index.php");

?>