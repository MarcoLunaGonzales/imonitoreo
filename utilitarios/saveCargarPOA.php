<?php
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

//print_r($_POST);

$dbh = new Conexion();
?>

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header <?=$colorCard;?> card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Cargado de datos POA</h4>
          </div>
          <div class="card-body">

<?php
$gestion=$_POST["gestion"];

$nombreGestion=nameGestion($gestion);


//$urlRedirect="../index.php?opcion=cargarPresupuestoOp";

session_start();

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

//borramos la tabla TEMPORAL
	$stmtDel = $dbh->prepare("DELETE FROM actividades_poaplanificacion_temp");
	$flagSuccess=$stmtDel->execute();	

	$stmtDel = $dbh->prepare("DELETE FROM actividades_poa_temp");
	$flagSuccess=$stmtDel->execute();	


$fechahora=date("dmy.Hi");
$archivoName="POA".$fechahora.$_FILES['file']['name'];
if ($_FILES['file']["error"] > 0){
	echo "Error: " . $_FILES['file']['error'] . "<br>";
	$archivoName="";
}
else{
	move_uploaded_file($_FILES['file']['tmp_name'], "../filesPresupuesto/".$archivoName);		
}

$file = fopen("../filesPresupuesto/".$archivoName, "r") or exit("No se puede abrir el archivo!");
$indice=1;
$insert_str="";




while(!feof($file)){
	$varPOA=fgets($file);

	//quita los miles de los numeros
	$varPOA=str_replace(',', '', $varPOA);

	$contarCampos=substr_count($varPOA, ';'); // 2
	//echo $contarCampos;
	
	if($varPOA!="" && $contarCampos==24 && $indice>1){

		list($idIndicador, $idUnidad, $idArea, $idSector, $idNorma, $idHito, $nombreAct, $prodEsperado, $unidadMedida, $cmi, $tablaClasificador, $codClasificador, $nombreClasificador, $enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre)=explode(";", $varPOA);

		if($cmi=="si" || $cmi=="SI"){
			$cmi=1;
		}else{
			$cmi=0;
		}

		$nombreAct=clean_string($nombreAct);
		$prodEsperado=clean_string($prodEsperado);
		$nombreClasificador=clean_string($nombreClasificador);
		
		$enero=(float)$enero;
		$febrero=(float)$febrero;
		$marzo=(float)$marzo;
		$abril=(float)$abril;
		$mayo=(float)$mayo;
		$junio=(float)$junio;
		$julio=(float)$julio;
		$agosto=(float)$agosto;
		$septiembre=(float)$septiembre;
		$octubre=(float)$octubre;
		$noviembre=(float)$noviembre;
		$diciembre=(float)$diciembre;

		$banderaError=0;

		if(!is_numeric($enero)){
			$banderaError=1;
		}
		if(!is_numeric($febrero)){
			$banderaError=1;
		}
		if(!is_numeric($marzo)){
			$banderaError=1;
		}
		if(!is_numeric($abril)){
			$banderaError=1;
		}
		if(!is_numeric($mayo)){
			$banderaError=1;
		}
		if(!is_numeric($junio)){
			$banderaError=1;
		}
		if(!is_numeric($julio)){
			$banderaError=1;
		}
		if(!is_numeric($agosto)){
			$banderaError=1;
		}
		if(!is_numeric($septiembre)){
			$banderaError=1;
		}
		if(!is_numeric($octubre)){
			$banderaError=1;
		}
		if(!is_numeric($noviembre)){
			$banderaError=1;
		}		
		if(!is_numeric($diciembre)){
			$banderaError=1;
		}		
		
		if($banderaError==0){
			$sqlInsert="INSERT INTO actividades_poa_temp (cod_gestion, orden, nombre, cod_normapriorizada, cod_norma, cod_tiposeguimiento, producto_esperado, clave_indicador, cod_indicador, cod_unidadorganizacional, cod_area, cod_estado, cod_tiporesultado, cod_datoclasificador, cod_hito) VALUES ('$gestion', '$indice', '$nombreAct', '$idSector', '$idNorma', '1', '$prodEsperado', '$cmi', '$idIndicador', '$idUnidad', '$idArea', '1', '1', '$codClasificador', '$idHito');";
			$stmtInsert=$dbh->prepare($sqlInsert);
		  	$stmtInsert->execute();

		  	$lastId = $dbh->lastInsertId();

		  	if($enero>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '1', '$enero');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}
		  	if($febrero>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '2', '$febrero');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  	
		  	if($marzo>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '3', '$marzo');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}
		  	if($abril>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '4', '$abril');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  	
		  	if($mayo>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '5', '$mayo');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}
		  	if($junio>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '6', '$junio');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  			  			  	
		  	if($julio>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '7', '$julio');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  			  			  	
		  	if($agosto>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '8', '$agosto');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  			  			  	
		  	if($septiembre>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '9', '$septiembre');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}
		  	if($octubre>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '10', '$octubre');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}
		  	if($noviembre>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '11', '$noviembre');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  			  			  			  			  			  	
		  	if($diciembre>0){
				$sqlInsert="INSERT INTO actividades_poaplanificacion_temp (cod_actividad, mes, value_numerico) VALUES ('$lastId', '12', '$diciembre');";
				$stmtInsert=$dbh->prepare($sqlInsert);
			  	$stmtInsert->execute();
		  	}		  			  			  			  			  			  			  	
		}else{
			echo "ERROR EN FILA: ".$indice."<br>";
		}
	}else{
		if($indice>1){
			echo "FILA VACIA O CON ERROR EN LA CANTIDAD DE CAMPOS: ".$indice."<br>";
		}
	}

	$indice++;
}

//DESDE ACA CARGAMOS A LA TABLA OFICIAL
$sqlCarga="SELECT a.cod_indicador, a.cod_unidadorganizacional, a.cod_area from actividades_poa_temp a group by a.cod_indicador, a.cod_unidadorganizacional, a.cod_area";
$stmtCarga = $dbh->prepare($sqlCarga);
$stmtCarga->execute();
while ($rowCarga = $stmtCarga->fetch(PDO::FETCH_ASSOC)) {
	$codIndicadorX=$rowCarga['cod_indicador'];
  	$codUnidadX=$rowCarga['cod_unidadorganizacional'];
  	$codAreaX=$rowCarga['cod_area'];
  	//echo $codIndicadorX." ".$codUnidadX." ".$codAreaX."<br>";

  	$sqlDel="DELETE FROM actividades_poaplanificacion where cod_actividad in (SELECT codigo from actividades_poa WHERE  cod_indicador='$codIndicadorX' and cod_unidadorganizacional='$codUnidadX' and cod_area='$codAreaX')";
  	//echo $sqlDel;
	$stmtDelOficial = $dbh->prepare($sqlDel);
	$flagSuccess3=$stmtDelOficial->execute();

  	$sqlDel="DELETE FROM actividades_poa where cod_indicador='$codIndicadorX' and cod_unidadorganizacional='$codUnidadX' and cod_area='$codAreaX'";
  	//echo $sqlDel;
	$stmtDelOficial = $dbh->prepare($sqlDel);
	$flagSuccess3=$stmtDelOficial->execute();
}        

$sqlTemp="SELECT codigo from actividades_poa_temp";
$stmtTemp = $dbh->prepare($sqlTemp);
$stmtTemp->execute();
$contador=1;
while ($rowTemp = $stmtTemp->fetch(PDO::FETCH_ASSOC)) {	
	$codigoTemp=$rowTemp['codigo'];
	
	$codigoPOA=0;
	$stmtCod = $dbh->prepare("SELECT IFNULL(max(a.codigo)+1,1)as codigo from actividades_poa a");
	$stmtCod->execute();
	while ($rowCod = $stmtCod->fetch(PDO::FETCH_ASSOC)) {
	  $codigoPOA=$rowCod['codigo'];
	}			

	$codigoOrdenPOA=obtieneOrdenPOA($codIndicadorX, $codUnidadX, $codAreaX);
	
	$sqlInsertTemp="INSERT INTO actividades_poa(codigo,cod_gestion,orden,nombre,cod_normapriorizada,cod_norma,cod_tiposeguimiento,
	producto_esperado,clave_indicador,cod_indicador,cod_unidadorganizacional,cod_area,cod_estado,cod_tiporesultado,cod_datoclasificador,cod_tipoactividad,cod_periodo,actividad_extra,cod_hito,observaciones,solicitante,cod_tiposolicitante)
	SELECT $codigoPOA, cod_gestion, $codigoOrdenPOA, nombre,cod_normapriorizada,cod_norma,cod_tiposeguimiento,
	producto_esperado,clave_indicador,cod_indicador,cod_unidadorganizacional,cod_area,cod_estado,cod_tiporesultado,cod_datoclasificador,cod_tipoactividad,cod_periodo,actividad_extra,cod_hito,observaciones,solicitante,cod_tiposolicitante FROM actividades_poa_temp where codigo='$codigoTemp'";
	$stmtInsertTemp = $dbh->prepare($sqlInsertTemp);
	$flagSuccess4=$stmtInsertTemp->execute();

	$sqlInsertTemp="INSERT INTO actividades_poaplanificacion (cod_actividad, mes, value_numerico) SELECT $codigoPOA, mes, value_numerico FROM actividades_poaplanificacion_temp WHERE cod_actividad='$codigoTemp'";
	$stmtInsertTemp = $dbh->prepare($sqlInsertTemp);
	$flagSuccess5=$stmtInsertTemp->execute();


	//echo "contador: ".$contador." variable temp: ".$codigoTemp."<br>";
	$contador++;

}
//FIN CARGADO TABLA OFICIAL

echo "<br><br>";
echo "PROCESO COMPLETADO!!!.";
//showAlertSuccessError(true,$urlRedirect);	

?>


          </div>
        </div>
      </div>
    </div>  
  </div>
</div>