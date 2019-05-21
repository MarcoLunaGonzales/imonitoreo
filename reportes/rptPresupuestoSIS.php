<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$gestion=$_POST["gestion"];

$anio=nameGestion($gestion);

$sql="SELECT distinct(c.partida), c.nombre from sis_presupuesto p, componentessis c
where p.cod_cuenta=c.partida and p.cod_ano='$anio' and p.monto>0";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('partida', $codCuenta);
$stmt->bindColumn('nombre', $nombreCuenta);

$totalEne=0;
$totalFeb=0;
$totalMar=0;
$totalAbr=0;
$totalMay=0;
$totalJun=0;
$totalJul=0;
$totalAgo=0;
$totalSep=0;
$totalOct=0;
$totalNov=0;
$totalDic=0;
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
                  <h4 class="card-title">Reporte Revision Presupuesto SIS</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> </h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold small">Partida</th>
                          <th class="text-center font-weight-bold small">Actividad</th>
                          <th class="text-center font-weight-bold">Ene</th>
                          <th class="text-center font-weight-bold">Feb</th>
                          <th class="text-center font-weight-bold">Mar</th>
                          <th class="text-center font-weight-bold">Abr</th>
                          <th class="text-center font-weight-bold">May</th>
                          <th class="text-center font-weight-bold">Jun</th>
                          <th class="text-center font-weight-bold">Jul</th>
                          <th class="text-center font-weight-bold">Ago</th>
                          <th class="text-center font-weight-bold">Sept</th>
                          <th class="text-center font-weight-bold">Oct</th>
                          <th class="text-center font-weight-bold">Nov</th>
                          <th class="text-center font-weight-bold">Dic</th>
                          <th class="text-center font-weight-bold">Totales</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $totalIngresos=0;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $totalCuenta=0;
                      ?>
                        <tr>
                          <td class="text-center small"><?=$codCuenta;?></td>
                          <td class="text-left small"><?=$nombreCuenta;?></td>
                      <?php
                        for($i=1;$i<=12;$i++){
                          $sqlDatos="SELECT p.monto as monto from sis_presupuesto p where p.cod_ano='$anio' and p.cod_cuenta='$codCuenta' and p.cod_mes='$i'";
                          //echo $sqlDatos;
                          $stmtDatos = $dbh->prepare($sqlDatos);
                          $stmtDatos->execute();
                          $stmtDatos->bindColumn('monto', $monto);
                          while ($rowDatos = $stmtDatos->fetch(PDO::FETCH_BOUND)) {
                            if($i==1){$totalEne+=$monto;}
                            if($i==2){$totalFeb+=$monto;}
                            if($i==3){$totalMar+=$monto;}
                            if($i==4){$totalAbr+=$monto;}
                            if($i==5){$totalMay+=$monto;}
                            if($i==6){$totalJun+=$monto;}
                            if($i==7){$totalJul+=$monto;}
                            if($i==8){$totalAgo+=$monto;}
                            if($i==9){$totalSep+=$monto;}
                            if($i==10){$totalOct+=$monto;}
                            if($i==11){$totalNov+=$monto;}
                            if($i==12){$totalDic+=$monto;}
                            $totalCuenta+=$monto;
                            $totalIngresos+=$monto;
                      ?>
                          <td class="text-right"><?=formatNumberDec($monto);?></td>
                      <?php
                          }
                      }
                      ?>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalCuenta);?></td>
                        </tr>
            <?php
            						}
            ?>
                        <tr>
                          <td></td>
                          <td class="font-weight-bold">TOTAL</td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalEne);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalFeb);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalMar);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalAbr);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalMay);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalJun);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalJul);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalAgo);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalSep);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalOct);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalNov);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalDic);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalIngresos);?></td>
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
