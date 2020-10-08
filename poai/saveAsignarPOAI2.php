<?php
require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';
//print_r($_POST);

$dbh = new Conexion();
$cantidadFilas=$_POST["cantidad_filas"];
$codigoIndicador=$_POST["codigo_indicador"];

$stmt = $dbh->prepare("SET FOREIGN_KEY_CHECKS=0;");
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
		$codPersonal=$_POST["personal".$i];
		

		$sqlDel="DELETE from actividades_personal where cod_actividad='$actividadPadre' and cod_personal='$codPersonal')";
		$stmtDel = $dbh->prepare($sqlDel);
		$flagSuccessDel = $stmtDel->execute();			
		
		$sqlInsert="INSERT INTO actividades_personal (cod_actividad, cod_personal) values ($actividadPadre, $codPersonal)";
		echo $sqlInsert;
		$stmtInsert = $dbh->prepare($sqlInsert);
		$flagSuccess = $stmtInsert->execute();	
	}
} 

$stmt = $dbh->prepare("SET FOREIGN_KEY_CHECKS=1;");
$stmt->execute();


if($flagSuccess==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}

?>
