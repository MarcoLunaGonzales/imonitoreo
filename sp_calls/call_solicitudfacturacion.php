<?php

set_time_limit(0);
error_reporting(-1);

require_once '../conexionExtIbnorca.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbhExterno = new ConexionExterno();
$dbh = new Conexion();

echo "<h3>Hora Inicio Proceso Solicitud Facturacion: " . date("Y-m-d H:i:s")."</h3>";


try{
	$sql = 'CALL sp_cubo_solFactura';
	$query = $dbhExterno->query($sql);
	$query -> setFetchMode(PDO::FETCH_ASSOC);

	$insert_str="";
	$indice=1;

	$sqlDelete = 'delete from ext_solicitudfacturacion';
	$stmtDelete = $dbh->prepare($sqlDelete);
	$flagSuccess=$stmtDelete->execute();


//	echo "antes";

	while($resp = $query->fetch()):
		//echo "entro while";
		//echo $r['IdSolicitudFactura']." xxx<br>";


		$IdSolicitudFactura=$resp['IdSolicitudFactura'];
		$Fecha=$resp['Fecha'];
		
		//$año=$resp['año'];
		$anio=0;

		$GranDetalle=$resp['GranDetalle'];

		//echo $Fecha;

		
		$GranDetalle=clean_string($GranDetalle);
		$GranDetalle=addslashes($GranDetalle);

		$NombreContacto=$resp['NombreContacto'];

		$NombreContacto=clean_string($NombreContacto);
		$NombreContacto=addslashes($NombreContacto);

		$NombreContactoAdmin=$resp['NombreContactoAdmin'];

		$NombreContactoAdmin=clean_string($NombreContactoAdmin);
		$NombreContactoAdmin=addslashes($NombreContactoAdmin);

		$Telefono=$resp['Telefono'];
		$Direccion=$resp['Direccion'];
		$Email=$resp['Email'];

		$Email=clean_string($Email);
		$Email=addslashes($Email);

		$idObjeto=$resp['idObjeto'];
		$IdCliente=$resp['IdCliente'];
		$NombreFactura=$resp['NombreFactura'];

		$NombreFactura=clean_string($NombreFactura);
		$NombreFactura=addslashes($NombreFactura);

		$NIT=$resp['NIT'];

		$NIT=clean_string($NIT);
		$NIT=addslashes($NIT);

		$Observacion=$resp['Observacion'];
		$d_usuario=$resp['d_usuario'];
		$d_oficina=$resp['d_oficina'];
		$d_tipoobjeto=$resp['d_tipoobjeto'];
		$d_area=$resp['d_area'];
		$d_cliente=$resp['d_cliente'];

		$d_cliente=clean_string($d_cliente);
		$d_cliente=addslashes($d_cliente);

		$idestado=$resp['idestado'];
		$d_estado=$resp['d_estado'];
		$fechaEstado=$resp['fechaEstado'];
		$Estado_obs=$resp['Estado_obs'];
		$d_formaPago=$resp['d_formaPago'];
		$CodigoServicioCurso=$resp['CodigoServicioCurso'];
		$d_ServicioCurso=$resp['d_ServicioCurso'];
		$detalle=$resp['detalle'];

		$detalle=clean_string($detalle);
		$detalle=addslashes($detalle);

		$Cantidad=$resp['Cantidad'];
		$Precio=$resp['Precio'];
		$montobs=$resp['montobs'];


		$insert_str .= "('$IdSolicitudFactura','$Fecha','$anio','$GranDetalle','$NombreContacto','$NombreContactoAdmin','$Telefono','$Direccion','$Email','$idObjeto','$IdCliente','$NombreFactura','$NIT','$Observacion','$d_usuario','$d_oficina','$d_tipoobjeto','$d_area','$d_cliente','$idestado','$d_estado','$fechaEstado','$Estado_obs','$d_formaPago','$CodigoServicioCurso','$d_ServicioCurso','$detalle','$Cantidad','$Precio','$montobs'),";	

		//echo $insert_str;

		if($indice%100==0){
			$insert_str = substr_replace($insert_str, '', -1, 1);
			$sqlInserta="INSERT INTO ext_solicitudfacturacion (idsolicitudfactura, fecha, anio, grandetalle, nombrecontacto, nombrecontactoadmin, telefono, direccion, email, idobjeto,  idcliente, nombrefactura, nit, observacion, dusuario, doficina, dtipoobjeto, darea, dcliente, idestado, destado, fechaestado, estadoobs, dformapago, codigoserviciocurso, dserviciocurso, detalle, cantidad, precio, montobs) values ".$insert_str.";";
			
			//echo $sqlInserta;
			
			$stmtInsert=$dbh->prepare($sqlInserta);
			$flagSuccess=$stmtInsert->execute();
			echo "vamos $indice <br>";
			$insert_str="";
		}
		if($flagSuccess==FALSE){
			echo "*****************ERROR*****************";
			echo $sqlInserta."<br>";
			break;
		}
		
		$indice++;
	endwhile;

	$insert_str = substr_replace($insert_str, '', -1, 1);
	$sqlInserta="INSERT INTO ext_solicitudfacturacion (idsolicitudfactura,fecha, anio, grandetalle, nombrecontacto, nombrecontactoadmin,   direccion, email, idobjeto,  idcliente, nombrefactura, nit, observacion, dusuario, doficina, dtipoobjeto, darea, dcliente, idestado,   destado, fechaestado, estadoobs, dformapago, codigoserviciocurso, dserviciocurso, detalle, cantidad, precio, montobs) values ".$insert_str.";";
	//echo $sqlInserta;
	$stmtInsert=$dbh->prepare($sqlInserta);
	$stmtInsert->execute();


	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=9 where doficina='Of. Cochabamba'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=10 where doficina='Of. Santa Cruz'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=270 where doficina='Of. Sucre'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=5 where doficina='Of. La Paz'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=8 where doficina='Of. Oruro'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=272 where doficina='Of. Potosi'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=271 where doficina='Of. Tarija'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=1103 where doficina='Of. Virtual'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();

	$sqlUpdIdOficina="UPDATE ext_solicitudfacturacion SET idoficina=829 where doficina='Of. DN La Paz'";
	$stmtUpd=$dbh->prepare($sqlUpdIdOficina);
	$stmtUpd->execute();




}catch (PDOException $pe) {
	die("Error occurred:" . $pe->getMessage());
}


echo "<h3>Hora Fin Proceso Solicitud Facturacion: " . date("Y-m-d H:i:s")."</h3>";

?>