<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

$stmt = $dbh->prepare("ALTER TABLE actividades_poaejecucion DROP FOREIGN KEY actividades_poaejecucion_fk1;");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `actividades_poaplanificacion` DROP FOREIGN KEY `actividades_poaplanificacion_fk1`;");
$stmt->execute();



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
$urlRedirect="../index.php?opcion=listActividadesPOA&codigo=$codigoIndicador&codigoPON=$codigoIndicadorPON&area=0&unidad=0";

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
	$nombre=$_POST["actividad".$i];
	//echo $i." area: ".$area." <br>";

	if($nombre!=0 || $nombre!=""){
		$codigo=$_POST["codigo".$i];
		$nombre=$_POST["actividad".$i];
		$normaPriorizada=$_POST["norma_priorizada".$i];
		$norma=$_POST["norma".$i];
		$productoEsperado=$_POST["producto_esperado".$i];
		$tipoSeguimiento=$_POST["tipo_seguimiento".$i];
		$tipoResultado="1";//valor numerico por defecto
		$datoClasificador=$_POST["clasificador".$i];
		$observaciones=$_POST["observaciones".$i];
		$hito=$_POST["hito".$i];
		$claveIndicador=$_POST["clave_indicador".$i];


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

		//BORRAMOS LA TABLA
		$sqlDelete="";
		$sqlDelete="DELETE from $table where codigo='$codigoPOA'";

		//echo $sqlDelete;

		$stmtDel = $dbh->prepare($sqlDelete);
		$flagSuccess=$stmtDel->execute();

		$ordenPOA=obtieneOrdenPOA($codigoIndicador,$codigoUnidad,$codigoArea);
		//echo $ordenPOA."<br>";
		//SACAMOS EL ESTADO DEL POA PARA LA GESTION
		$actividadExtra=0;
		$codEstadoPOAGestion=estadoPOAGestion($globalGestion);
		if($codEstadoPOAGestion==3 || $codEstadoPOAGestion==1){
			$actividadExtra=1;
		}
		$sql="INSERT INTO $table (codigo, orden, nombre, cod_gestion, cod_normapriorizada, cod_norma, cod_tiposeguimiento, producto_esperado, cod_indicador, cod_unidadorganizacional, cod_area, cod_estado, created_at, created_by, cod_tiporesultado, cod_datoclasificador, actividad_extra, observaciones, cod_hito, clave_indicador) VALUES (:codigo, :orden, :nombre, :cod_gestion, :cod_normapriorizada, :cod_norma, :cod_tiposeguimiento, :producto_esperado, :cod_indicador, :cod_unidadorganizacional, :cod_area, :cod_estado, :created_at, :created_by, :cod_tiporesultado, :cod_datoclasificador, :actividad_extra,:observaciones,:cod_hito,:clave_indicador)";
		$stmt = $dbh->prepare($sql);
		// Bind
 		
 		$values = array(':codigo'=>$codigoPOA,
		':orden'=> $ordenPOA,
		':nombre'=> $nombre,
		':cod_gestion'=> $globalGestion,
		':cod_normapriorizada'=> $normaPriorizada,
		':cod_norma'=> $norma,
		':cod_tiposeguimiento'=> $tipoSeguimiento,
		':producto_esperado'=> $productoEsperado,
		':cod_indicador'=> $codigoIndicador,
		':cod_unidadorganizacional'=> $codigoUnidad,
		':cod_area'=> $codigoArea,
		':cod_estado'=> $codEstado,
		':created_at'=> $fechaHoraActual,
		':created_by'=> $globalUser,
		':cod_tiporesultado'=> $tipoResultado,
		':cod_datoclasificador'=> $datoClasificador,
		':actividad_extra'=> $actividadExtra,
		':observaciones'=> $observaciones,
		':cod_hito'=> $hito,
		':clave_indicador'=> $claveIndicador
    	);

    	$exQuery=str_replace(array_keys($values), array_values($values), $sql);
    	//echo $exQuery;

		$flagSuccess=$stmt->execute($values);	
	}
} 


$stmt = $dbh->prepare("ALTER TABLE `actividades_poaejecucion` ADD CONSTRAINT `actividades_poaejecucion_fk1` FOREIGN KEY (`cod_actividad`) REFERENCES `actividades_poa` (`codigo`);");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `actividades_poaplanificacion` ADD CONSTRAINT `actividades_poaplanificacion_fk1` FOREIGN KEY (`cod_actividad`) REFERENCES `actividades_poa` (`codigo`);");
$stmt->execute();



if($flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}


?>
