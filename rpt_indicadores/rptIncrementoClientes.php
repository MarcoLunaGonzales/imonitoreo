<?php
error_reporting(E_ALL);
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

session_start();

$mesTemporal=$_GET["mes"];
$nombreMes=nameMes($mesTemporal);
$anioTemporal=$_GET["anio"];
$codArea=$_GET["codArea"];
$codUnidad=$_GET["codUnidad"];
$nombreUnidad=nameUnidad($codUnidad);
$abrevUnidad=abrevUnidad($codUnidad);
$nombreArea=nameArea($codArea);

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Incremento y Retencion de Clientes </h3>
        <h3><?=$nombreArea;?> <?=$nombreUnidad;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


    <h6 class="text-left text-primary font-weight-bold">
      Nota: Los clientes retenidos se presentan con negrilla y color diferente.
    </h6>


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">
                <?=$mesTemporal;?>.<?=$anioTemporal-1;?>
              </h4>
            </div>

            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center">-</th>
                    <th class="text-center">Unidad</th>
                    <th class="text-center"><?=$mesTemporal;?>.<?=$anioTemporal-1;?><br>Cliente</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $fechaFin=$anioTemporal."-".$mesTemporal."-01";
                  $fechaIni=date('Y-m-d',strtotime($fechaFin.'-11 month'));
                  $fechaFin=date('Y-m-d',strtotime($fechaFin.'+1 month'));
                  $fechaFin=date('Y-m-d',strtotime($fechaFin.'-1 day'));
                  $fechaFinAnt=date('Y-m-d',strtotime($fechaFin.'-1 year'));
                  $fechaIniAnt=date('Y-m-d',strtotime($fechaIni.'-1 year'));

                  $sqlC="SELECT distinct(c.codigo)as codigo, c.nombre FROM ext_servicios e, clientes c where e.id_cliente=c.codigo and e.id_area in($codArea) and e.id_oficina in ($codUnidad) and e.fecha_factura BETWEEN '$fechaIniAnt' and '$fechaFinAnt' order by 2";
                  //echo $sqlC;
                  $stmtC = $dbh->prepare($sqlC);
                  $stmtC->execute();
                  $stmtC->bindColumn('codigo', $codigoCliente);
                  $stmtC->bindColumn('nombre', $nombreCliente);
                  $indice=1;
                  while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-center"><?=$indice;?></td>
                    <td class="text-center"><?=$abrevUnidad;?></td>
                    <td class="text-left"><?=$nombreCliente;?></td>
                  </tr>
                  <?php
                    $indice++;
                  }
                  ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">
                <?=$mesTemporal;?>.<?=$anioTemporal;?>
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center">-</th>
                    <th class="text-center">Unidad</th>
                    <th class="text-center"><?=$mesTemporal;?>.<?=$anioTemporal;?><br>Cliente</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $fechaFin=$anioTemporal."-".$mesTemporal."-01";
                  $fechaIni=date('Y-m-d',strtotime($fechaFin.'-11 month'));
                  $fechaFin=date('Y-m-d',strtotime($fechaFin.'+1 month'));
                  $fechaFin=date('Y-m-d',strtotime($fechaFin.'-1 day'));

                  $sql="SELECT distinct(c.codigo)as codigo, c.nombre FROM ext_servicios e, clientes c where e.id_cliente=c.codigo and e.id_area in($codArea) and e.id_oficina in ($codUnidad) and e.fecha_factura BETWEEN '$fechaIni' and '$fechaFin' order by 2";
                  //echo $sql;
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('codigo', $codigoCliente);
                  $stmt->bindColumn('nombre', $nombreCliente);
                  $indice=1;
                  while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
                    $sqlVerificar="SELECT count(*) as cantidad from ext_servicios e where e.id_area in ($codArea) and e.id_oficina in ($codUnidad) and e.fecha_factura BETWEEN '$fechaIniAnt' and '$fechaFinAnt' and e.id_cliente in ($codigoCliente)";
                    //echo $sqlVerificar;
                    $stmtV = $dbh->prepare($sqlVerificar);
                    $stmtV->execute();
                    $bandera=0;
                    while ($rowV = $stmtV->fetch(PDO::FETCH_ASSOC)) {
                        $bandera=$rowV['cantidad'];
                    }
                  ?>
                  <tr>
                    <td class="text-center"><?=$indice;?></td>
                    <td class="text-center"><?=$abrevUnidad;?></td>
                    <td class="text-left <?=($bandera>0)?"font-weight-bold text-primary":""?>"><?=$nombreCliente;?></td>
                  </tr>
                  <?php
                    $indice++;
                  }
                  ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
