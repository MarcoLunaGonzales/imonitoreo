<?php

set_time_limit(0);
require_once '../conexionExtIbnorca.php';
require_once '../conexion.php';
$dbhExterno = new ConexionExterno();
$dbh = new Conexion();

echo "<h3>Hora Inicio Proceso Certificados: " . date("Y-m-d H:i:s")."</h3>";


$sqlDelete = 'delete from ext_certificados';
$stmtDelete = $dbh->prepare($sqlDelete);
$flagSuccess=$stmtDelete->execute();

$sql = "SELECT IdCertificadoServicios, IdServicio, IdTipoCertificado, idCliente, Norma, Descripcion, NumeroAnterior, FechaEmision, FechaValido, FechaEntrega, FechaRegistro, ProductoServicio, Observaciones, idCabeceraFormInspeccion, NroHoja, de_cliente, TipoCertificado, idCertificadorExterno, Codigo, idestado, estado, d_certificadorExt, stipo, idarea, idTipoEstado, idoficina, idDocumentoBase, idFormularioCertificado, idTipoServicio, iaf from vw_listacertificadosservicios where FechaEmision>='2015-01-01'";
echo $sql;
$stmt = $dbhExterno->prepare($sql);
$stmt->execute();
$insert_str="";
$indice=0;
while ($resp = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$IdCertificadoServicios=$resp['IdCertificadoServicios'];
	$IdServicio=$resp['IdServicio'];
	$IdTipoCertificado=$resp['IdTipoCertificado'];
	$idCliente=$resp['idCliente'];
	$Norma=$resp['Norma'];
	$Descripcion=$resp['Descripcion'];
	$NumeroAnterior=$resp['NumeroAnterior'];
	$FechaEmision=$resp['FechaEmision'];
	$FechaValido=$resp['FechaValido'];
	$FechaEntrega=$resp['FechaEntrega'];
	$FechaRegistro=$resp['FechaRegistro'];
	$ProductoServicio=$resp['ProductoServicio'];
	$Observaciones=$resp['Observaciones'];
	$idCabeceraFormInspeccion=$resp['idCabeceraFormInspeccion'];
	$NroHoja=$resp['NroHoja'];
	$decliente=$resp['de_cliente'];
	$TipoCertificado=$resp['TipoCertificado'];
	$idCertificadorExterno=$resp['idCertificadorExterno'];
	$Codigo=$resp['Codigo'];
	$idestado=$resp['idestado'];
	$estado=$resp['estado'];
	$dcertificadorExt=$resp['d_certificadorExt'];
	$stipo=$resp['stipo'];
	$idarea=$resp['idarea'];
	$idTipoEstado=$resp['idTipoEstado'];
	$idoficina=$resp['idoficina'];
	$idDocumentoBase=$resp['idDocumentoBase'];
	$idFormularioCertificado=$resp['idFormularioCertificado'];
	$idTipoServicio=$resp['idTipoServicio'];
	$iaf=$resp['iaf'];

	$codigoIAF=0;
	if($iaf!=""){
		$arrayiaf = explode(",",$iaf);
		$codigoIAF=$arrayiaf[0];
	}


	$insert_str .= "('$IdCertificadoServicios','$IdServicio','$IdTipoCertificado','$idCliente','$Norma','$Descripcion','$NumeroAnterior','$FechaEmision','$FechaValido','$FechaEntrega','$FechaRegistro','$ProductoServicio','$Observaciones','$idCabeceraFormInspeccion','$NroHoja','$decliente','$TipoCertificado','$idCertificadorExterno','$Codigo','$idestado','$estado','$dcertificadorExt','$stipo','$idarea','$idTipoEstado','$idoficina','$idDocumentoBase','$idFormularioCertificado','$idTipoServicio','$codigoIAF'),";	

	if($indice%10==0){
		$insert_str = substr_replace($insert_str, '', -1, 1);
		$sqlInserta="INSERT INTO ext_certificados (idcertificadoservicios,idservicio,idtipocertificado,idcliente,norma,descripcion,
  numeroanterior,fechaemision,fechavalido,fechaentrega,fecharegistro,productoservicio,observaciones,idcabeceraforminspeccion,nrohoja,decliente,tipocertificado,idcertificadorexterno,codigo,idestado,estado,dcertificadorext,stipo,idarea,idtipoestado,
  idoficina,iddocumentobase,idformulariocertificado,idtiposervicio,iaf) values ".$insert_str.";";
		echo $sqlInserta;
		$stmtInsert=$dbh->prepare($sqlInserta);
		$flagSuccess=$stmtInsert->execute();
		$insert_str="";
	}
	if($flagSuccess==FALSE){
      echo "*****************ERROR*****************";
      echo $sqlInserta."<br>";
      break;
    }
    if($indice%10==0){
      echo "vamos $indice <br>";
    }
	$indice++;
}

$insert_str = substr_replace($insert_str, '', -1, 1);
$sqlInserta="INSERT INTO ext_certificados (idcertificadoservicios,idservicio,idtipocertificado,idcliente,norma,descripcion,
  numeroanterior,fechaemision,fechavalido,fechaentrega,fecharegistro,productoservicio,observaciones,idcabeceraforminspeccion,nrohoja,decliente,tipocertificado,idcertificadorexterno,codigo,idestado,estado,dcertificadorext,stipo,idarea,idtipoestado,
  idoficina,iddocumentobase,idformulariocertificado,idtiposervicio,iaf) values ".$insert_str.";";
//echo $sqlInserta;
$stmtInsert=$dbh->prepare($sqlInserta);
$stmtInsert->execute();

echo "<h3>Hora Fin Proceso Certificados: " . date("Y-m-d H:i:s")."</h3>";
?>