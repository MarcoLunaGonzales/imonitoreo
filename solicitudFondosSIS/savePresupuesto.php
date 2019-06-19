<?php
set_time_limit(0);
require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

$gestion=$_POST["gestion"];
$tipoCargado=$_POST["tipo"];

$nombreGestion=nameGestion($gestion);

$urlRedirect="../index.php?opcion=cargarPresupuestoSIS";

session_start();

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

//borramos la tabla SI EL TIPO ES 0
if($tipoCargado==0){
	$stmtDel = $dbh->prepare("DELETE FROM sis_presupuesto WHERE cod_ano=:cod_anio");
	$stmtDel->bindParam(':cod_anio', $nombreGestion);
	$flagSuccess=$stmtDel->execute();	
}

$fechahora=date("dmy.Hi");
$archivoName=$fechahora.$_FILES['file']['name'];
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
	$varPresupuesto=fgets($file);

	//quita los miles de los numeros
	$varPresupuesto=str_replace(',', '', $varPresupuesto);
	//PONE 0 EN LOS QUE NO HAY DATOS
	//$varPresupuesto=str_replace(';;', '', $varPresupuesto);
	

	if($varPresupuesto!=""){
		//echo $varPresupuesto."<br>";
		list($idCuenta, $nombreCuenta, $enero, $febrero, $marzo, $abril, $mayo, $junio, $julio, $agosto, $septiembre, $octubre, $noviembre, $diciembre)=explode(";", $varPresupuesto);

		$idCuenta=trim($idCuenta);
		$idCuenta=str_replace('-', '', $idCuenta);
		
		$nombreCuenta=trim($nombreCuenta);
		
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
		
		//echo $idCuenta." ".$nombreCuenta." ".$enero." ".$febrero." ".$marzo." ".$abril." ".$mayo." ".$junio." ".$julio." ".$agosto." ".$septiembre." ".$octubre." ".$noviembre." ".$diciembre."<br>";
		
		if($banderaError==0){
			//echo "TODO OK";
		}else{
			echo "ERROR EN FILA: ".$indice;
		}


		$partidaX="0";
		$sql="SELECT c.partida from componentessis c where c.partida='$idCuenta'";
		$stmt=$dbh->prepare($sql);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$partidaX=$row['partida'];
		}
		//echo $partidaX."no es<br>";
		if($partidaX=="0"){
			$sql="SELECT c.partida from componentessis c where c.abreviatura='$idCuenta'";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$partidaX=$row['partida'];
			}
		}
		
		//echo $sql."<br>";
		//echo $partidaX."<br>";

		$idCuenta=$partidaX;

		if($partidaX!="0"){
			//BORRAMOS SI EL TIPO ES 1
			if($tipoCargado==1){
				$stmtDel = $dbh->prepare("DELETE FROM sis_presupuesto WHERE cod_ano=:cod_anio and cod_cuenta=:cod_cuenta");
				$stmtDel->bindParam(':cod_anio', $nombreGestion);
				$stmtDel->bindParam(':cod_cuenta', $idCuenta);
				$flagSuccess=$stmtDel->execute();	
			}

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '1',
					':monto'=>$enero
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '2',
					':monto'=>$febrero
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '3',
					':monto'=>$marzo
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '4',
					':monto'=>$abril
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '5',
					':monto'=>$mayo
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '6',
					':monto'=>$junio
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '7',
					':monto'=>$julio
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '8',
					':monto'=>$agosto
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '9',
					':monto'=>$septiembre
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '10',
					':monto'=>$octubre
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '11',
					':monto'=>$noviembre
					);
			$stmt->execute($values);

			$sql="INSERT INTO sis_presupuesto (cod_cuenta, cod_gestion, cod_ano, cod_mes, monto) VALUES (:cod_cuenta, :cod_gestion, :cod_ano, :cod_mes, :monto)";	    		    
			$stmt = $dbh->prepare($sql);
			$values = array( ':cod_cuenta' => $idCuenta,
					':cod_gestion' => $gestion,
					':cod_ano' => $nombreGestion,
					':cod_mes'=> '12',
					':monto'=>$diciembre
					);
			$stmt->execute($values);
		}
	
	}
	$indice++;
}

showAlertSuccessError(true,$urlRedirect);	

?>
