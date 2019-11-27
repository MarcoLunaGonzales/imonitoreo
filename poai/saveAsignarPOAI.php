<?php
require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';
//print_r($_POST);

$dbh = new Conexion();
$cantidadFilas=$_POST["cantidad_filas"];
$codigoIndicador=$_POST["codigo_indicador"];
$stmt = $dbh->prepare("ALTER TABLE actividades_poaejecucion DROP FOREIGN KEY actividades_poaejecucion_fk1;");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `actividades_poaplanificacion` DROP FOREIGN KEY `actividades_poaplanificacion_fk1`;");
$stmt->execute();

$table="actividades_poa";
$urlRedirect="../index.php?opcion=listActividadesPOA&codigo=$codigoIndicador&area=0&unidad=0";

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
	$actividadPadre=$_POST["codigoPadre".$i];
	//echo $i." area: ".$area." <br>";
	if($actividadPadre!=0 || $actividadPadre!=""){
		$codigoPOAI=$_POST["codigoPOAI".$i];
		$codPersonal=$_POST["personal".$i];
		$funcion=$_POST["funcion".$i];
		$meta=$_POST["meta".$i];
		//echo $actividadPadre." ".$codigoPOAI." ".$funcion." ".$meta."<br>";
		$codigoInsert=0;
		if($codigoPOAI==0){
			$stmtCod = $dbh->prepare("SELECT IFNULL(max(a.codigo)+1,1)as codigo from actividades_poa a");
			$stmtCod->execute();
			while ($rowCod = $stmtCod->fetch(PDO::FETCH_ASSOC)) {
			  $codigoInsert=$rowCod['codigo'];
			}			
		}else{
			$codigoInsert=$codigoPOAI;
		}
		//BORRAMOS LA TABLA
		$sqlDelete="";
		$sqlDelete="DELETE from $table where codigo='$codigoPOAI'";
		$stmtDel = $dbh->prepare($sqlDelete);
		$flagSuccess=$stmtDel->execute();
		$ordenPOA=obtieneOrdenPOA($codigoIndicador,$globalUnidad,$globalArea);

		$sqlInsert="INSERT INTO actividades_poa (codigo,cod_gestion,orden,nombre,cod_normapriorizada,cod_norma,  cod_tiposeguimiento,producto_esperado,clave_indicador,cod_indicador,cod_unidadorganizacional,cod_area,  created_at,modified_at,created_by,modified_by,cod_estado,cod_tiporesultado,cod_datoclasificador,  cod_comite,cod_estadopon,cod_modogeneracionpon,cod_personal,poai,cod_tipoactividad,cod_periodo, actividad_extra,cod_hito,observaciones,solicitante,cod_tiposolicitante,cod_funcion, metapoai,cod_actividadpadre) SELECT '$codigoInsert',cod_gestion,'$ordenPOA',nombre,cod_normapriorizada,cod_norma,  cod_tiposeguimiento,producto_esperado,clave_indicador,cod_indicador,cod_unidadorganizacional,cod_area,'$fechaHoraActual',modified_at,'$globalUser',modified_by,cod_estado,cod_tiporesultado,cod_datoclasificador,  cod_comite,cod_estadopon,cod_modogeneracionpon,'$codPersonal','1',cod_tipoactividad,cod_periodo, actividad_extra,cod_hito,observaciones,solicitante,cod_tiposolicitante, '$funcion', '$meta', '$actividadPadre' FROM actividades_poa WHERE codigo='$actividadPadre'";
		
		//echo $sqlInsert."<br>";
		
		$stmtInsert = $dbh->prepare($sqlInsert);
		$flagSuccess = $stmtInsert->execute();	
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
