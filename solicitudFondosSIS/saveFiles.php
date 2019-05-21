<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

$anio=$_POST["anio"];
$mes=$_POST["mes"];
$nro_archivo=$_POST["nro_archivo"];

$table="sis_archivos";
$urlRedirect="../index.php?opcion=resumenGeneralSIS";

session_start();

$stmtDel = $dbh->prepare("DELETE FROM $table WHERE anio='$anio' and mes='$mes' and nro_archivo='$nro_archivo'");
$flagSuccess=$stmtDel->execute();

$flagSuccessDetail=true;

$fechahora=date("dmy.Hi");
$archivoName=$fechahora.$_FILES['file']['name'];
if ($_FILES['file']["error"] > 0){
	echo "Error: " . $_FILES['file']['error'] . "<br>";
	$archivoName="";
}
else{
	move_uploaded_file($_FILES['file']['tmp_name'], "../filesSIS/".$archivoName);		
}

$sql="INSERT INTO $table (anio, mes,nro_archivo,archivo) 
VALUES (:anio, :mes, :nro_archivo, :archivo)";	    	
$stmt = $dbh->prepare($sql);
$values = array( ':anio' => $anio,
':mes' => $mes,
':nro_archivo' => $nro_archivo,
':archivo' => $archivoName
);

$exQuery=str_replace(array_keys($values), array_values($values), $sql);
//echo $exQuery;

$flagSuccess2=$stmt->execute($values);
if($flagSuccess2==false){
	$flagSuccessDetail=false;
}

if($flagSuccessDetail==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}

?>
