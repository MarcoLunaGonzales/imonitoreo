<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);
$dbh = new Conexion();

$externalCosts=$_POST['externalcost'];
$urlRedirect="../index.php?opcion=rptOpRelacionarGastos";

$flagSuccessDetail=true;

for($i=0; $i<count($externalCosts);$i++){
	//echo $externalCosts[$i]."<br>";
	list($codigoAcc, $fecha, $partida, $glosa) = explode('|', $externalCosts[$i]);

    //SANITIZAMOS LA CADENA
    $glosa=string_sanitize($glosa);

	$sql="DELETE from gastos_externalcosts where fecha='$fecha' and ml_partida='$partida' and glosa_detalle='$glosa' and cod_externalcost='$codigoAcc'";
    $stmt = $dbh->prepare($sql);
    $flagSuccess2=$stmt->execute();

    if($flagSuccess2==false){
        $flagSuccessDetail=false;
    }
    
    $sql="INSERT INTO gastos_externalcosts (fecha, ml_partida, glosa_detalle, cod_externalcost) VALUES ('$fecha','$partida','$glosa','$codigoAcc')";
    $stmt = $dbh->prepare($sql);
    $flagSuccess2=$stmt->execute();

    if($flagSuccess2==false){
        $flagSuccessDetail=false;
    }

}
   		
if($flagSuccessDetail==true){
	showAlertSuccessError(true,$urlRedirect);	
}else{
	showAlertSuccessError(false,$urlRedirect);
}



?>
