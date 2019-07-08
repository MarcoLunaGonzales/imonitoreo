<?php
error_reporting(E_ALL);
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();

$mesTemporal=$_GET["mes"];
$nombreMes=nameMes($mesTemporal);
$anioTemporal=$_GET["anio"];
$codArea=$_GET["codArea"];
$codUnidad=$_GET["codUnidad"];
$iaf=$_GET["iaf"];
$norma=$_GET["norma"];
$acumulado=$_GET["acumulado"];
$certificador=$_GET["certificador"];
$vista=$_GET["vista"];

$nombreVista="";
if($vista==1){
  $nombreVista="CERTIFICADOS EMITIDOS";
}else{
  $nombreVista="CERTIFICADOS VIGENTES";
}

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];

$nombreArea=abrevArea($codArea);

if($codUnidad==0){
  $stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=11");
  $stmt->execute();
  $cadenaUnidades="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $cadenaUnidades=$row['valor_configuracion'];
  }  
  $codUnidad=$cadenaUnidades;
}

$fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
$fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
$fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Detalle Certificaciones <?=$nombreArea;?></h3>
        <h3 class="title"><?=$nombreVista;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Detalle Certificaciones
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed table-bordered" id="main">
                <thead>
                  <tr>
                    <th class="text-center">-</th>
                    <th class="text-center">Unidad</th>
                    <th class="text-center">Area</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Norma</th>
                    <th class="text-center">Descripcion</th>
                    <th class="text-center">F.Emision</th>
                    <th class="text-center">F.Validez</th>
                    <th class="text-center">F.Entrega</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Certificador</th>
                    <th class="text-center">IAF</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql="SELECT (select u.nombre from unidades_organizacionales u where u.codigo=e.idoficina)as unidad, (select a.nombre from areas a where a.codigo=e.idarea)as area, (select c.nombre from clientes c where c.codigo=e.idcliente)as cliente, e.norma, e.descripcion, e.fechaemision, e.fechavalido, e.fechaentrega, e.stipo, e.codigo, e.estado,  e.dcertificadorext, (select i.nombre from iaf i where i.abreviatura=e.iaf)as iaf from ext_certificados e where e.idarea in ($codArea) and e.idoficina in ($codUnidad) ";
                  if($vista==1){
                    if($acumulado==0){
                      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)=$mesTemporal ";
                    }else{
                      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<=$mesTemporal ";
                    }                    
                  }else{
                    $sql.=" and e.fechaemision<='$fechaVistaIni' and e.fechavalido>='$fechaVistaFin' ";
                  }

                  if($norma!=""){
                    $sql.=" and e.norma='$norma' ";
                  }
                  if($iaf>0){
                    $sql.=" and e.iaf='$iaf' ";
                  }
                  $sql.=" and e.idestado not in (646, 860, 475, 1118) order by e.fechaemision, unidad, area, cliente ";
                  
                  //echo $sql;
                  
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('unidad', $unidadX);
                  $stmt->bindColumn('area', $areaX);
                  $stmt->bindColumn('cliente', $clienteX);
                  $stmt->bindColumn('norma', $normaX);
                  $stmt->bindColumn('descripcion', $descripcionX);
                  $stmt->bindColumn('fechaemision', $fechaEmisionX);
                  $stmt->bindColumn('fechavalido', $fechaValidoX);
                  $stmt->bindColumn('fechaentrega', $fechaEntregaX);
                  $stmt->bindColumn('stipo', $tipoCertificacionX);
                  $stmt->bindColumn('codigo', $codigoX);
                  $stmt->bindColumn('estado', $estadoX);
                  $stmt->bindColumn('dcertificadorext', $certificadorExtX);
                  $stmt->bindColumn('iaf', $iafX);

                  $indice=1;
                  while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-center small"><?=$indice?></td>
                    <td class="text-left small"><?=$unidadX;?></td>             
                    <td class="text-left small"><?=$areaX;?></td>             
                    <td class="text-left small"><?=$clienteX;?></td>             
                    <td class="text-left small"><?=$normaX;?></td>             
                    <td class="text-left small"><?=$descripcionX;?></td>             
                    <td class="text-left small"><?=$fechaEmisionX;?></td>             
                    <td class="text-left small"><?=$fechaValidoX;?></td>             
                    <td class="text-left small"><?=$fechaEntregaX;?></td>             
                    <td class="text-left small"><?=$tipoCertificacionX;?></td>             
                    <td class="text-left small"><?=$codigoX;?></td>             
                    <td class="text-left small"><?=$estadoX;?></td>             
                    <td class="text-left small"><?=$certificadorExtX;?></td>             
                    <td class="text-left small"><?=$iafX;?></td>             
                  </tr>
                  <?php
                    $indice++;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
