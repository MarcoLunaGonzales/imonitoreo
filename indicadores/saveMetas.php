<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$table="indicadores_metas";

session_start();

$cod_objetivo=$_POST["cod_objetivo"];
$cod_indicador=$_POST["cod_indicador"];

$urlRedirect="../index.php?opcion=listIndicadores&codigo=$cod_objetivo";

//borramos la tabla
$stmtDel = $dbh->prepare("DELETE FROM $table WHERE cod_indicador=:cod_indicador");
$stmtDel->bindParam(':cod_indicador', $cod_indicador);
$flagSuccess=$stmtDel->execute();

$flagSuccessDetail=true;
foreach($_POST as $nombre_campo => $valor){ 
   	$asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   
	$cadenaBuscar='combo';
	$posicion = strpos($nombre_campo, $cadenaBuscar);

	//echo "pos: ".$posicion."<br>";

	if ($posicion === false) {
	}else{
		list($nombreX, $codUnidadX, $codAreaX)=explode("|",$nombre_campo);
	    $codOperadorX=$valor;
	    $valorMetaX=$_POST["text|".$codUnidadX."|".$codAreaX];

	    $sql="INSERT INTO indicadores_metas (cod_indicador, cod_unidadorganizacional, cod_area, cod_operador, meta) VALUES (:cod_indicador, :cod_unidad, :cod_area, :cod_operador, :meta)";
	    $stmt = $dbh->prepare($sql);
		$values = array( ':cod_indicador' => $cod_indicador,
        ':cod_unidad' => $codUnidadX,
        ':cod_area' => $codAreaX,
        ':cod_operador' => $codOperadorX,
        ':meta' => $valorMetaX
    	);

		/*$stmt->bindParam(':cod_indicador', $cod_indicador);
		$stmt->bindParam(':cod_unidad', $codUnidadX);
		$stmt->bindParam(':cod_area', $codAreaX);
		$stmt->bindParam(':cod_operador', $codOperadorX);
		$stmt->bindParam(':meta', $valorMetaX);*/

		$flagSuccess2=$stmt->execute($values);

		//$exQuery=str_replace(array_keys($values), array_values($values), $sql);
		//echo $exQuery.";<br>";
				
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
