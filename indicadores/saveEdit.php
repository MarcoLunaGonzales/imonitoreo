<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$codigoObjetivo=$_POST["cod_objetivo"];

$table="indicadores";
$urlRedirect="../index.php?opcion=listIndicadores&codigo=$codigoObjetivo";

session_start();

$codigo=$_POST["cod_indicador"];
$nombre=$_POST["nombre"];
$descripcion=$_POST["descripcion"];
$lineamiento=$_POST["lineamiento"];
$codEstado="1";
$codTipoObjetivo="1";
$tipo_resultado=$_POST["tipo_resultado"];
$tipo_resultadoMeta=$_POST["tipo_resultadometa"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$fechaHoraActual=date("Y-m-d H:i:s");
$propiedad_indicador=$_POST["propiedad_indicador"];


// Prepare
$stmt = $dbh->prepare("UPDATE $table set nombre=:nombre, descripcion_calculo=:descripcion_calculo, lineamiento=:lineamiento, cod_tiporesultado=:cod_tiporesultado, cod_tiporesultadometa=:cod_tiporesultadometa, modified_at=:modifiedAt, modified_by=:modifiedBy where codigo=:codigo");
// Bind
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':descripcion_calculo', $descripcion);
$stmt->bindParam(':lineamiento', $lineamiento);
$stmt->bindParam(':cod_tiporesultado', $tipo_resultado);
$stmt->bindParam(':cod_tiporesultadometa', $tipo_resultadoMeta);
$stmt->bindParam(':modifiedAt', $fechaHoraActual);
$stmt->bindParam(':modifiedBy', $globalUser);

$flagSuccess=$stmt->execute();

$flagSuccessDetail=true;

$sqlDel="DELETE FROM indicadores_unidadesareas where cod_indicador=:codigo_indicador";
$stmtDel = $dbh->prepare($sqlDel);
$stmtDel->bindParam(':codigo_indicador', $codigo);
$stmtDel->execute();

for ($i=0;$i<count($propiedad_indicador);$i++){ 	    
	list($codUnidad, $codArea)=explode("|",$propiedad_indicador[$i]);
	$codClasificador=$_POST["combo|".$codUnidad."|".$codArea];

	$stmt = $dbh->prepare("INSERT INTO indicadores_unidadesareas (cod_indicador, cod_unidadorganizacional, cod_area, cod_clasificador) VALUES (:cod_indicador, :cod_unidad, :cod_area, :cod_clasificador)");
	$stmt->bindParam(':cod_indicador', $codigo);
	$stmt->bindParam(':cod_unidad', $codUnidad);
	$stmt->bindParam(':cod_area', $codArea);
	$stmt->bindParam(':cod_clasificador', $codClasificador);

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
