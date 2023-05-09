<?php
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

$areasX=$_GET["area"];
$nameArea=abrevArea($areasX);


$gestion=$_GET["gestion"];
$mes=$_GET["mes"];
$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

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
                  <h4 class="card-title">Ingresos Devengados Detallados por Area</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>
                  <h6 class="card-title">Area:<?=$nameArea;?></h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">Fecha Solicitud Factura</th>
                          <th class="text-center font-weight-bold">Fecha Solicitada Facturación</th>
                          <th class="text-center font-weight-bold">Cliente</th>
                          <th class="text-center font-weight-bold">Monto</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php

                        $sql="SELECT i.fecha_sf, i.fecha_factura, i.nombre_cliente, i.monto from ingresos_devengados i where i.cod_area='$areasX'";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();

                        // bindColumn
                        $stmt->bindColumn('fecha_sf', $fechaSF);
                        $stmt->bindColumn('fecha_factura', $fechaFactura);
                        $stmt->bindColumn('nombre_cliente', $nombreCliente);
                        $stmt->bindColumn('monto', $montoDevengado);

                        $totalMontoDevengado=0;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $totalMontoDevengado+=$montoDevengado;                               
                      ?>
                        <tr>
                          <td class="text-center"><?=$fechaSF;?></td>
                          <td><p class="text-center"><?=$fechaFactura;?></p></td>
                          <td class="text-left"><?=$nombreCliente;?></td>
                          <td class="text-right"><?=formatNumberDec($montoDevengado);?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                          <td class="text-right small">-</td>
                          <td><p class="<?=$styleText;?>">-</p></td>
                          <td class="text-right">Total Ingreso Devengado</td>
                          <td class="text-right"><?=formatNumberDec($totalMontoDevengado);?></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>  
        </div>
    </div>



