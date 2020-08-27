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
		$tipoActividad=$_POST["tipo_actividad".$i];
		$periodo=$_POST["periodo".$i];
		$funcion=$_POST["funcion".$i];


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

		$sqlDelete="";
		$sqlDelete="DELETE from $table where codigo='$codigoPOA'";
		//echo $sqlDelete;
		$stmtDelete = $dbh->prepare($sqlDelete);
		$flagSuccessDel=$stmtDelete->execute();	

		$poai=1;
		$metapoai=0;
		$codActividadPadre=-1000;


		$sqlInsert="INSERT INTO $table (codigo, orden, nombre, cod_gestion, cod_normapriorizada, cod_norma, cod_tiposeguimiento, producto_esperado, cod_indicador, cod_unidadorganizacional, cod_area, cod_estado, created_at, created_by, cod_personal, cod_tiporesultado, cod_datoclasificador, poai, cod_tipoactividad, cod_periodo, cod_funcion, metapoai, cod_actividadpadre) VALUES ('$codigoPOA', '$i', '$nombre', '$globalGestion', '$normaPriorizada', '$norma', '$tipoSeguimiento', '$productoEsperado', '$codigoIndicador', '$codigoUnidad', '$codigoArea', '$codEstado', '$fechaHoraActual', '$globalUser', '$globalUser', '$tipoResultado', '$datoClasificador', '$poai', '$tipoActividad', '$periodo', '$funcion', '$metapoai', '$codActividadPadre')";
		$stmt = $dbh->prepare($sqlInsert);
		//echo $sqlInsert;

		$flagSuccess=$stmt->execute();	

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

