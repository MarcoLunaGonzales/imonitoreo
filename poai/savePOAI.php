<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
$stmt->execute();
$codigoIndicadorPON=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoIndicadorPON=$row['valor_configuracion'];
}

$codigoIndicador=$_POST["cod_indicador"];
$cantidadFilas=$_POST["cantidad_filas"];

$codigoUnidad=$_POST["codigoUnidad"];
$codigoArea=$_POST["codigoArea"];


$table="actividades_poa";
$urlRedirect="../index.php?opcion=listActividadesPOAI&codigo=$codigoIndicador&area=0&unidad=0";

session_start();

$orden="1";
$codEstado="1";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

for ($i=1;$i<=$cantidadFilas;$i++){ 	    	
	// Prepare
	$tipoSeguimiento=$_POST["tipo_seguimiento".$i];
	//echo $i." area: ".$area." <br>";

	if($tipoSeguimiento!=0 || $tipoSeguimiento!=""){
		$codigo=$_POST["codigo".$i];
		$nombre=$_POST["actividad".$i];
		$normaPriorizada=$_POST["norma_priorizada".$i];
		$norma=$_POST["norma".$i];
		$productoEsperado=$_POST["producto_esperado".$i];
		$tipoSeguimiento=$_POST["tipo_seguimiento".$i];
		$tipoResultado="1";//valor numerico por defecto
		$datoClasificador=$_POST["clasificador".$i];
		$tipoActividad=$_POST["tipo_actividad".$i];
		$periodo=$_POST["periodo".$i];

		//BORRAMOS EL CAMPO
		$sqlDelete="";
		$sqlDelete="DELETE from $table where codigo=:codigo";
		$stmtDel = $dbh->prepare($sqlDelete);
		$stmtDel->bindParam(':codigo', $codigo);
		$flagSuccess=$stmtDel->execute();

		$codigoPOA=0;
		if($codigo==0){
			$stmtCod = $dbh->prepare("SELECT IFNULL(max(a.codigo)+1,1)as codigo from actividades_poa a");
			$stmtCod->execute();
			while ($rowCod = $stmtCod->fetch(PDO::FETCH_ASSOC)) {
			  $codigoPOA=$rowCod['codigo'];
			}			
		}else{
			$codigoPOA=$codigo;
		}

		$poai=1;

		$stmt = $dbh->prepare("INSERT INTO $table (codigo, orden, nombre, cod_gestion, cod_normapriorizada, cod_norma, cod_tiposeguimiento, producto_esperado, cod_indicador, cod_unidadorganizacional, cod_area, cod_estado, created_at, created_by, cod_personal, cod_tiporesultado, cod_datoclasificador, poai, cod_tipoactividad, cod_periodo) VALUES (:codigo, :orden, :nombre, :cod_gestion, :cod_normapriorizada, :cod_norma, :cod_tiposeguimiento, :producto_esperado, :cod_indicador, :cod_unidadorganizacional, :cod_area, :cod_estado, :created_at, :created_by, :cod_personal, :cod_tiporesultado, :cod_datoclasificador, :poai, :cod_tipoactividad, :cod_periodo)");
		// Bind
		$stmt->bindParam(':codigo', $codigoPOA);
		$stmt->bindParam(':orden', $i);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':cod_gestion', $globalGestion);
		$stmt->bindParam(':cod_normapriorizada', $normaPriorizada);
		$stmt->bindParam(':cod_norma', $norma);
		$stmt->bindParam(':cod_tiposeguimiento', $tipoSeguimiento);
		$stmt->bindParam(':producto_esperado', $productoEsperado);
		$stmt->bindParam(':cod_indicador', $codigoIndicador);
		$stmt->bindParam(':cod_unidadorganizacional', $codigoUnidad);
		$stmt->bindParam(':cod_area', $codigoArea);
		$stmt->bindParam(':cod_estado', $codEstado);
		$stmt->bindParam(':created_at', $fechaHoraActual);
		$stmt->bindParam(':created_by', $globalUser);
		$stmt->bindParam(':cod_personal', $globalUser);
		$stmt->bindParam(':cod_tiporesultado', $tipoResultado);
		$stmt->bindParam(':cod_datoclasificador', $datoClasificador);
		$stmt->bindParam(':poai', $poai);
		$stmt->bindParam(':cod_tipoactividad', $tipoActividad);
		$stmt->bindParam(':cod_periodo', $periodo);


		$flagSuccess=$stmt->execute();	
	}
} 



if($flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>