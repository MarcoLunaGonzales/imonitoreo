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

$table="actividades_poaejecucion";
$urlRedirect="../index.php?opcion=listActividadesPOAIEjecucion&codigo=$codigoIndicador";

session_start();

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

$flagSuccessDetail=true;
foreach($_POST as $nombre_campo => $valor){ 
   	$asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   
   	//echo "CAMPOS: ".$asignacion."<br>";

	$cadenaBuscar='plan';
	$posicion = strpos($nombre_campo, $cadenaBuscar);

	if ($posicion === false) {
	}else{
		list($planX, $codActividadX, $mesX)=explode("|",$nombre_campo);

		//SACAMOS PARA LAS ACTIVIDADES UNICAS LA FECHA
		$fechaEjecucion="";
		$fechaEjecucion=$_POST['date|'.$codActividadX.'|'.$mesX];

		$ejeSistema=$_POST["ejsistema|".$codActividadX."|".$mesX];
		$explicacionLogro=$_POST["explicacion|".$codActividadX."|".$mesX];
		//$fileEjecucion=$_FILES["file|".$codActividadX."|".$mesX];
		$fileEjecucion="file|".$codActividadX."|".$mesX;

		//CARGAMOS EL ARCHIVO PARA CADA FILA
		$fechahora=date("dmy.Hi");
		$archivoName=$fechahora.$_FILES[$fileEjecucion]['name'];
		if ($_FILES[$fileEjecucion]["error"] > 0){
			echo "Error: " . $_FILES[$fileEjecucion]['error'] . "<br>";
			$archivoName="";
		}
		else{
				//echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
				//echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
				//echo "Tamaño: " . (($_FILES["archivo"]["size"])/1024)/1024 . " MB<br>";
				//echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
				move_uploaded_file($_FILES[$fileEjecucion]['tmp_name'], "../filesApp/".$archivoName);		
		}
		//FIN CARGAR ARCHIVO

	    $sqlDel="DELETE FROM $table WHERE cod_actividad in ($codActividadX) and mes='$mesX'";
		echo $sqlDel;
		$stmtDel = $dbh->prepare($sqlDel);
		$flagSuccess=$stmtDel->execute();

	    $sql="";
    	$sql="INSERT INTO $table (cod_actividad, mes, value_numerico, descripcion, archivo, value_numericosistema, fecha_ejecucion) VALUES ('$codActividadX','$mesX','$valor','$explicacionLogro','$archivoName','$ejeSistema','$fechaEjecucion')";	    		    
	    $stmt = $dbh->prepare($sql);
		$flagSuccess2=$stmt->execute();

		//echo $sql.";<br>";
		
		if($flagSuccess2==false){
			$flagSuccessDetail=false;
		}
	}
}

if($flagSuccessDetail==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}

?>
