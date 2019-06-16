<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

$anio=$_POST["anio"];
$mes=$_POST["mes"];
$nro_archivo=$_POST["nro_archivo"];

//$archivito=$_POST["archivo"];
$files = $_FILES;

$table="sis_archivos";
$urlRedirect="../index.php?opcion=resumenGeneralSIS";

session_start();

$globalUser=$_SESSION["globalUser"];

$stmtDel = $dbh->prepare("DELETE FROM $table WHERE anio='$anio' and mes='$mes' and nro_archivo='$nro_archivo'");
$flagSuccess=$stmtDel->execute();

$flagSuccessDetail=true;

$sqlId="select IFNULL(max(s.id)+1,1)as id from sis_archivos s";
$stmtId = $dbh->prepare($sqlId);
$stmtId->execute();
while ($rowId = $stmtId->fetch(PDO::FETCH_ASSOC)) {
  $idArchivo=$rowId['id'];
}

$sql="INSERT INTO $table (id, anio, mes, nro_archivo) 
VALUES (:id, :anio, :mes, :nro_archivo)";	    	
$stmt = $dbh->prepare($sql);
$values = array('id' => $idArchivo,
':anio' => $anio,
':mes' => $mes,
':nro_archivo' => $nro_archivo
);

$exQuery=str_replace(array_keys($values), array_values($values), $sql);
//echo $exQuery;

$flagSuccess2=$stmt->execute($values);

$url="http://www.crespal.com";
//$cadenaGuardar="idD=$idDir&idR=$idReg&idusr=$idusr&Tipodoc=$Tipodoc&descripcion=$descripcion&codigo=$codigo&observacion=$observacion&archivito=$files&r=$url&v=$visor";

if($flagSuccess2==false){
	$flagSuccessDetail=false;
}

if($flagSuccessDetail==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}

?>

<!--script type="text/javascript">
	location.href="../upload_libraries/guardar_archivo.php?<?=$cadenaGuardar;?>";
</script-->