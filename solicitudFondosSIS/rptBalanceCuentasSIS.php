<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$mes=$_GET["mes"];
$gestion=$_GET["gestion"];
$desde=nameGestion($gestion)."-01-01";
$datosMes=explode("####", $_GET["mes"]);
$gestiones[0]=$gestion;
if(count($datosMes)>0){
  $mes=$datosMes[0];
  if($datosMes[1]>0){
    $gestion=$datosMes[1];
    $gestiones[1]=$datosMes[1];
  }  
}
$stringGestiones=implode(",", $gestiones);
$diaUltimo=date("d",(mktime(0,0,0,$mes,1,nameGestion($gestion))-1));
$hasta=nameGestion($gestion)."-".$mes."-".$diaUltimo;


$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

$sql="SELECT pc.codigo, pc.nombre from po_mayores s, po_plancuentas pc where pc.codigo=s.cuenta and s.fondo=2001 and s.fecha BETWEEN '$desde' and '$hasta' and (pc.codigo not like '4%' and pc.codigo not like '5%') group by pc.codigo, pc.nombre order by pc.codigo";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigoCuenta);
$stmt->bindColumn('nombre', $nombreCuenta);

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
                  <h4 class="card-title">Balance de Cuentas SIS</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="main">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">Codigo</th>
                          <th class="text-center font-weight-bold">Cuenta</th>
                          <th class="text-center font-weight-bold">Debe</th>
                          <th class="text-center font-weight-bold">Haber</th>
                          <th class="text-center font-weight-bold">Saldo</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                        $indice=1;
                        while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $debe=montoMayores($codigoCuenta,$anio,$mes,1);
                          $haber=montoMayores($codigoCuenta,$anio,$mes,2);
                      ?>
                        <tr>
                          <td class="text-right"><?=$codigoCuenta;?></td>
                          <td class="text-left">
                          <div id="accordion<?=$indice;?>" role="tablist">
                            <div class="card-collapse">
                              <div class="card-header" role="tab" id="heading<?=$indice;?>">
                                <h5 class="mb-0">
                                  <a data-toggle="collapse" href="#collapse<?=$indice;?>" aria-expanded="false" aria-controls="collapse<?=$indice;?>" class="collapsed">
                                    <?=$nombreCuenta;?>
                                    <i class="material-icons">keyboard_arrow_down</i>
                                  </a>
                                </h5>
                              </div>
                              <div id="collapse<?=$indice;?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$indice;?>" data-parent="#accordion<?=$indice;?>" style="">
                                <div class="card-body">
                                  <?php
                                  $sqlDetalle="SELECT s.indice, s.glosa, s.fecha from po_mayores s, po_plancuentas pc where pc.codigo=s.cuenta and s.fondo=2001 and s.fecha BETWEEN '$desde' and '$hasta' and s.cuenta='$codigoCuenta' order by s.fecha;";
                                  //echo $sql;
                                  $stmtDetalle = $dbh->prepare($sqlDetalle);
                                  $stmtDetalle->execute();

                                  // bindColumn
                                  $stmtDetalle->bindColumn('indice', $indiceMayores);
                                  $stmtDetalle->bindColumn('glosa', $glosa);
                                  $stmtDetalle->bindColumn('fecha', $fecha);

                                  ?>
                                  <table>
                                    <tr>
                                      <th>Detalle</th>
                                      <th>Fecha</th>
                                      <th>Debe</th>
                                      <th>Haber</th>
                                      <th>Saldo</th>
                                    </tr>
                                  <?php
                                  while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_BOUND)) {
                                    $debeDetalle=montoMayoresDetalle($codigoCuenta,$indiceMayores,$fecha,1);
                                    $haberDetalle=montoMayoresDetalle($codigoCuenta,$indiceMayores,$fecha,2);
                                  ?>
                                  <tr>
                                    <td class="text-left small"><?=$glosa;?></td>
                                    <td><?=$fecha;?></td>
                                    <td class="text-right"><?=formatNumberInt($debeDetalle);?></td>
                                    <td class="text-right"><?=formatNumberInt($haberDetalle);?></td>
                                    <td class="text-right"><?=formatNumberInt($debeDetalle+$haberDetalle);?></td>
                                  </tr>
                                  <?php    
                                  }
                                  ?>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                          </td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($debe);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($haber);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($debe+$haber);?></td>
                        </tr>
                      <?php
                        $indice++;
                      }
                      ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>-</th>
                          <th>TOTALES</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>  
        </div>
    </div>

<script type="text/javascript">
  totalesSIS2();
</script>