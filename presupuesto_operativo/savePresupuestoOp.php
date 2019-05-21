<?php
set_time_limit(0);
require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';

//print_r($_POST);

$dbh = new Conexion();

$fondo=$_POST["fondo"];
$organismo=$_POST["organismo"];
$gestion=$_POST["gestion"];
$nombreGestion=nameGestion($gestion);


$urlRedirect="../index.php?opcion=cargarPresupuestoOp";

session_start();

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");

//borramos la tabla
$stmtDel = $dbh->prepare("DELETE FROM po_presupuesto WHERE cod_organismo=:organismo and cod_fondo=:fondo and cod_ano=:cod_anio");
$stmtDel->bindParam(':organismo', $organismo);
$stmtDel->bindParam(':fondo', $fondo);
$stmtDel->bindParam(':cod_anio', $nombreGestion);
$flagSuccess=$stmtDel->execute();

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


	if($varPresupuesto!=""){
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

		$digitoCuenta = substr($idCuenta, 0, 1); 
		//echo "<br>".$digitoCuenta."<br>";

		if($digitoCuenta=="4"){
			$sql="SELECT COUNT(p.cod_cuentaingreso)as nrofilas from po_cuentaingresos p where p.cod_cuentaingreso='$idCuenta'";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$nroFilas=$row['nrofilas'];
			}
			if($nroFilas>0){
				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '1',
						':cod_organismo'=>$organismo,
						':monto'=>$enero
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '2',
						':cod_organismo'=>$organismo,
						':monto'=>$febrero
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '3',
						':cod_organismo'=>$organismo,
						':monto'=>$marzo
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '4',
						':cod_organismo'=>$organismo,
						':monto'=>$abril
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '5',
						':cod_organismo'=>$organismo,
						':monto'=>$mayo
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '6',
						':cod_organismo'=>$organismo,
						':monto'=>$junio
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '7',
						':cod_organismo'=>$organismo,
						':monto'=>$julio
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '8',
						':cod_organismo'=>$organismo,
						':monto'=>$agosto
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '9',
						':cod_organismo'=>$organismo,
						':monto'=>$septiembre
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '10',
						':cod_organismo'=>$organismo,
						':monto'=>$octubre
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '11',
						':cod_organismo'=>$organismo,
						':monto'=>$noviembre
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '12',
						':cod_organismo'=>$organismo,
						':monto'=>$diciembre
						);
				$stmt->execute($values);
			}
		}

		if($digitoCuenta=="5"){
			$sql="SELECT COUNT(p.cod_cuentaegreso)as nrofilas from po_cuentaegresos p where p.cod_cuentaegreso='$idCuenta'";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$nroFilas=$row['nrofilas'];
			}
			if($nroFilas>0){
				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '1',
						':cod_organismo'=>$organismo,
						':monto'=>$enero
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '2',
						':cod_organismo'=>$organismo,
						':monto'=>$febrero
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '3',
						':cod_organismo'=>$organismo,
						':monto'=>$marzo
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '4',
						':cod_organismo'=>$organismo,
						':monto'=>$abril
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '5',
						':cod_organismo'=>$organismo,
						':monto'=>$mayo
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '6',
						':cod_organismo'=>$organismo,
						':monto'=>$junio
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '7',
						':cod_organismo'=>$organismo,
						':monto'=>$julio
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '8',
						':cod_organismo'=>$organismo,
						':monto'=>$agosto
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '9',
						':cod_organismo'=>$organismo,
						':monto'=>$septiembre
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '10',
						':cod_organismo'=>$organismo,
						':monto'=>$octubre
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '11',
						':cod_organismo'=>$organismo,
						':monto'=>$noviembre
						);
				$stmt->execute($values);

				$sql="INSERT INTO po_presupuesto (cod_cuenta, cod_fondo, cod_gestion, cod_ano, cod_mes, cod_organismo, monto) VALUES (:cod_cuenta, :cod_fondo, :cod_gestion, :cod_ano, :cod_mes, :cod_organismo, :monto)";	    		    
				$stmt = $dbh->prepare($sql);
				$values = array( ':cod_cuenta' => $idCuenta,
						':cod_fondo' => $fondo,
						':cod_gestion' => $gestion,
						':cod_ano' => $nombreGestion,
						':cod_mes'=> '12',
						':cod_organismo'=>$organismo,
						':monto'=>$diciembre
						);
				$stmt->execute($values);
			}
		}
	}
	$indice++;
}


showAlertSuccessError(true,$urlRedirect);	

?>
