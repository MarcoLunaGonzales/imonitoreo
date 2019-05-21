<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="indicadores";

session_start();

$cod_objetivo=$_POST["cod_objetivo"];

$urlRedirect="../index.php?opcion=listIndicadores&codigo=$cod_objetivo";

$nombre=$_POST["nombre"];
$periodo=$_POST["periodo"];
$descripcion=$_POST["descripcion"];
$lineamiento=$_POST["lineamiento"];
$tipo_calculo=$_POST["tipo_calculo"]; 
$codEstado="1";
$codTipoObjetivo="1";
$tipo_resultado=$_POST["tipo_resultado"];
$tipo_resultadoMeta=$_POST["tipo_resultadometa"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$fechaHoraActual=date("Y-m-d H:i:s");
$propiedad_indicador=$_POST["propiedad_indicador"];
$clasificador=$_POST["clasificador"];


// Prepare
$stmt = $dbh->prepare("INSERT INTO $table (nombre, cod_objetivo, cod_periodo, descripcion_calculo, lineamiento, cod_tipocalculo, cod_gestion, cod_estado, cod_tiporesultado, cod_tiporesultadometa, cod_tipoobjetivo, cod_clasificador, created_at, created_by) VALUES (:nombre, :cod_objetivo, :cod_periodo, :descripcion_calculo, :lineamiento, :cod_tipocalculo, :cod_gestion, :cod_estado, :cod_tiporesultado, :cod_tiporesultadometa, :cod_tipoobjetivo, :cod_clasificador, :created_at, :created_by)");
// Bind
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':cod_objetivo', $cod_objetivo);
$stmt->bindParam(':cod_periodo', $periodo);
$stmt->bindParam(':descripcion_calculo', $descripcion);
$stmt->bindParam(':lineamiento', $lineamiento);
$stmt->bindParam(':cod_tipocalculo', $tipo_calculo);
$stmt->bindParam(':cod_gestion', $globalGestion);
$stmt->bindParam(':cod_estado', $codEstado);
$stmt->bindParam(':cod_tiporesultado', $tipo_resultado);
$stmt->bindParam(':cod_tiporesultadometa', $tipo_resultadoMeta);
$stmt->bindParam(':cod_tipoobjetivo', $codTipoObjetivo);
$stmt->bindParam(':cod_clasificador', $clasificador);
$stmt->bindParam(':created_at', $fechaHoraActual);
$stmt->bindParam(':created_by', $globalUser);

$flagSuccess=$stmt->execute();
$lastId = $dbh->lastInsertId();

$flagSuccessDetail=true;

for ($i=0;$i<count($propiedad_indicador);$i++){ 	    
	list($codUnidad, $codArea)=explode("|",$propiedad_indicador[$i]);
	$stmt = $dbh->prepare("INSERT INTO indicadores_unidadesareas (cod_indicador, cod_unidadorganizacional, cod_area) VALUES (:cod_indicador, :cod_unidad, :cod_area)");
	$stmt->bindParam(':cod_indicador', $lastId);
	$stmt->bindParam(':cod_unidad', $codUnidad);
	$stmt->bindParam(':cod_area', $codArea);

	$flagSuccess2=$stmt->execute();
	if($flagSuccess2==false){
		$flagSuccessDetail=false;
	}
}

if($flagSuccessDetail==true && $flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
