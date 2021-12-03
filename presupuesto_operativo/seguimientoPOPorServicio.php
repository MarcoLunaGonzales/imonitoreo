<?php
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();
session_start();

$fondo=$_GET["fondo"];
$fondoArray=str_replace('|', ',', $fondo);
$nombreFondo=abrevFondo($fondoArray);

//SACAMOS LA CONFIGURACINO PARA REDISTRIBUIR EL IT
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=1");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $banderaRedistIT=$row['valor_configuracion'];
}

//SACAMOS LA CONFIGURACINO PARA LOS ORGANISMOS
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}


$anio=$_GET["anio"];
$mes=$_GET["mes"];

$anioAnt=$anio-1;


$moduleName="Seguimiento al PO Por Area - $mes $anio";
$moduleName2="Seguimiento al PO Por Area Acumulado - $mes $anio";

//DEFINIMOS VARIABLES DE SESION
//echo $fondoArray."fondoArray";
$_SESSION['fondoTemporal']=$fondoArray;
$_SESSION['anioTemporal']=$anio;
$_SESSION['mesTemporal']=$mes;


require("chartPorServicio.php");
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
                  <h4 class="card-title"><?=$moduleName?></h4>
                  <h4 class="card-title">Agencia(s): <?=$nombreFondo;?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold" width="12.5%">-</th>
                          <th class="text-center font-weight-bold" width="12.5%">Tipo</th>
                          <th class="text-center font-weight-bold" width="12.5%">Pres.<?=$anio;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">Eje.<?=$anio;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">%</th>
                          <th class="text-center font-weight-bold" width="12.5%">Pres.<?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">Eje.<?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">%</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>Diferencia</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>%</th>
                        </tr>
                      </thead>
                      <tbody>

                  <!--DESDE ACA LA TABLA-->
                  <?php
                  $sqlServicios="SELECT codigo, nombre from po_organismos where codigo in ($cadenaOrganismos) order by 2";
                  $stmtServicios = $dbh->prepare($sqlServicios);
                  $stmtServicios->execute();
                  while ($rowServicios= $stmtServicios->fetch(PDO::FETCH_ASSOC)) {
                      $codigoServicio=$rowServicios['codigo'];
                      $nombreServicio=$rowServicios['nombre'];
                  
                  ?>
                      <?php
                          //INGRESOS
                          $montoPresIngresoAnt=presupuestoIngresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,0,0);
                          $montoPresIngreso=presupuestoIngresosMes($fondoArray,$anio,$mes,$codigoServicio,0,0);

                          $montoEjIngresoAnt=ejecutadoIngresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,0,0);
                          $montoEjIngreso=ejecutadoIngresosMes($fondoArray,$anio,$mes,$codigoServicio,0,0);

                          $porcIngresoAnt=0;
                          $porcIngreso=0;
                          if($montoPresIngresoAnt>0){
                            //$porcIngresoAnt=(($montoEjIngresoAnt-$montoPresIngresoAnt)/$montoPresIngresoAnt)*100;
                            $porcIngresoAnt=($montoEjIngresoAnt/$montoPresIngresoAnt)*100;             
                          }
                          if($montoPresIngreso>0){
                            //$porcIngreso=(($montoEjIngreso-$montoPresIngreso)/$montoPresIngreso)*100;
                            $porcIngreso=($montoEjIngreso/$montoPresIngreso)*100;
                          }
                          $colorPorcIngAnt=colorPorcentajeIngreso($porcIngresoAnt);
                          $colorPorcIng=colorPorcentajeIngreso($porcIngreso);

                      ?>
                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreServicio;?></td>
                          <td class="text-left font-weight-bold">Ingresos</td>
                          <td class="text-right"><?=formatNumberInt($montoPresIngreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjIngreso);?></td>
                          <td class="text-right <?=$colorPorcIng;?>"><?=formatNumberInt($porcIngreso);?></td>
                          <td class="text-right "><?=formatNumberInt($montoPresIngresoAnt);?></td>
                          <td class="text-right "><?=formatNumberInt($montoEjIngresoAnt);?></td>
                          <td class="text-right <?=$colorPorcIngAnt;?>"><?=formatNumberInt($porcIngresoAnt);?></td>
                          <td class="text-right "><?=formatNumberInt($diferenciaAniosIngresos);?></td>
                          <td class="text-right "><?=formatNumberInt($porcentajeAniosIngresos);?></td>
                        </tr>

                  <?php
                  }
                  ?>
                        <!--tr>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                        </tr-->

                  <?php
                  /*$sqlServicios="SELECT codigo, nombre from po_organismos where codigo in ($cadenaOrganismos) order by 2";
                  $stmtServicios = $dbh->prepare($sqlServicios);
                  $stmtServicios->execute();
                  while ($rowServicios= $stmtServicios->fetch(PDO::FETCH_ASSOC)) {
                      $codigoServicio=$rowServicios['codigo'];
                      $nombreServicio=$rowServicios['nombre'];                  

                          //EGRESOS
                          $montoPresEgresoAnt=presupuestoEgresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,0,0);
                          $montoPresEgreso=presupuestoEgresosMes($fondoArray,$anio,$mes,$codigoServicio,0,0);
                          
                          $montoEjEgresoAnt=ejecutadoEgresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,0,0);
                          $montoEjEgreso=ejecutadoEgresosMes($fondoArray,$anio,$mes,$codigoServicio,0,0);

                          $porcEgreso=0;
                          $porcEgresoAnt=0;
                          if($montoPresEgresoAnt>0){
                            //$porcEgresoAnt=(($montoEjEgresoAnt-$montoPresEgresoAnt)/$montoPresEgresoAnt)*100;
                            $porcEgresoAnt=($montoEjEgresoAnt/$montoPresEgresoAnt)*100;
                          }
                          if($montoPresEgreso){
                            //$porcEgreso=(($montoEjEgreso-$montoPresEgreso)/$montoPresEgreso)*100;
                            $porcEgreso=($montoEjEgreso/$montoPresEgreso)*100;
                          }
                          $colorPorcEgAnt=colorPorcentajeEgreso($porcEgresoAnt);
                          $colorPorcEg=colorPorcentajeEgreso($porcEgreso);*/

                      ?>
                        <!--tr>
                          <td class="text-left font-weight-bold"><?=$nombreServicio;?></td>
                          <td class="text-left">Egresos</td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgreso);?></td>
                          <td class="text-right <?=$colorPorcEg;?>"><?=formatNumberInt($porcEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgresoAnt);?></td>
                          <td class="text-right <?=$colorPorcEgAnt;?>"><?=formatNumberInt($porcEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosEgresos);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosEgresos);?></td>
                        </tr-->

                  <?php
                  //}
                  ?>
                      </tbody>
                    </table>
                  </div>
                  <!--HASTA AQUI LA TABLA-->
                  
                </div>
              </div>
            </div>
        </div>  



        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header <?=$colorCard2;?> card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title"><?=$moduleName2;?></h4>
                  <h4 class="card-title">Agencia(s): <?=$nombreFondo;?></h4>
                </div>
                <div class="card-body">

                  <!--DESDE ACA LA TABLA-->
                  <div class="table-responsive">
                    <table class="table table-condensed">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold" width="12.5%">-</th>
                          <th class="text-center font-weight-bold" width="12.5%">Tipo</th>
                          <th class="text-center font-weight-bold" width="12.5%">Pres.<?=$anio;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">Eje.<?=$anio;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">%</th>
                          <th class="text-center font-weight-bold" width="12.5%">Pres.<?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">Eje.<?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold" width="12.5%">%</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>Diferencia</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>%</th>
                        </tr>
                      </thead>
                      <tbody>

                  <?php
                  $sqlServicios="SELECT codigo, nombre from po_organismos where codigo in ($cadenaOrganismos) order by 2";
                  $stmtServicios = $dbh->prepare($sqlServicios);
                  $stmtServicios->execute();
                  while ($rowServicios= $stmtServicios->fetch(PDO::FETCH_ASSOC)) {
                      $codigoServicio=$rowServicios['codigo'];
                      $nombreServicio=$rowServicios['nombre'];
                  
                  ?>
                      <?php
                          //INGRESOS
                          $montoPresIngresoAnt=presupuestoIngresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,1,0);
                          $montoPresIngreso=presupuestoIngresosMes($fondoArray,$anio,$mes,$codigoServicio,1,0);

                          $montoEjIngresoAnt=ejecutadoIngresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,1,0);
                          $montoEjIngreso=ejecutadoIngresosMes($fondoArray,$anio,$mes,$codigoServicio,1,0);

                          $porcIngresoAnt=0;
                          $porcIngreso=0;
                          if($montoPresIngresoAnt>0){
                            //$porcIngresoAnt=(($montoEjIngresoAnt-$montoPresIngresoAnt)/$montoPresIngresoAnt)*100;
                            $porcIngresoAnt=($montoEjIngresoAnt/$montoPresIngresoAnt)*100;             
                          }
                          if($montoPresIngreso>0){
                            //$porcIngreso=(($montoEjIngreso-$montoPresIngreso)/$montoPresIngreso)*100;
                            $porcIngreso=($montoEjIngreso/$montoPresIngreso)*100;
                          }
                          $colorPorcIngAnt=colorPorcentajeIngreso($porcIngresoAnt);
                          $colorPorcIng=colorPorcentajeIngreso($porcIngreso);

                      ?>
                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreServicio;?></td>
                          <td class="text-left">Ingresos</td>
                          <td class="text-right"><?=formatNumberInt($montoPresIngreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjIngreso);?></td>
                          <td class="text-right <?=$colorPorcIng;?>"><?=formatNumberInt($porcIngreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoPresIngresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjIngresoAnt);?></td>
                          <td class="text-right <?=$colorPorcIngAnt;?>"><?=formatNumberInt($porcIngresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosIngresos);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosIngresos);?></td>
                        </tr>

                  <?php
                  }
                  ?>
                   <!--tr>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                          <td class="text-center">-</td>
                        </tr-->
                  <?php
                  /*
                  $sqlServicios="SELECT codigo, nombre from po_organismos where codigo in ($cadenaOrganismos) order by 2";
                  $stmtServicios = $dbh->prepare($sqlServicios);
                  $stmtServicios->execute();
                  while ($rowServicios= $stmtServicios->fetch(PDO::FETCH_ASSOC)) {
                      $codigoServicio=$rowServicios['codigo'];
                      $nombreServicio=$rowServicios['nombre'];
                  
                  ?>
                      <?php
                          //EGRESOS
                          $montoPresEgresoAnt=presupuestoEgresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,1,0);
                          $montoPresEgreso=presupuestoEgresosMes($fondoArray,$anio,$mes,$codigoServicio,1,0);
                          
                          $montoEjEgresoAnt=ejecutadoEgresosMes($fondoArray,$anioAnt,$mes,$codigoServicio,1,0);
                          $montoEjEgreso=ejecutadoEgresosMes($fondoArray,$anio,$mes,$codigoServicio,1,0);

                          $porcEgreso=0;
                          $porcEgresoAnt=0;
                          if($montoPresEgresoAnt>0){
                            //$porcEgresoAnt=(($montoEjEgresoAnt-$montoPresEgresoAnt)/$montoPresEgresoAnt)*100;
                            $porcEgresoAnt=($montoEjEgresoAnt/$montoPresEgresoAnt)*100;
                          }
                          if($montoPresEgreso){
                            //$porcEgreso=(($montoEjEgreso-$montoPresEgreso)/$montoPresEgreso)*100;
                            $porcEgreso=($montoEjEgreso/$montoPresEgreso)*100;
                          }
                          $colorPorcEgAnt=colorPorcentajeEgreso($porcEgresoAnt);
                          $colorPorcEg=colorPorcentajeEgreso($porcEgreso);
                          */
                      ?>
                        <!--tr>
                          <td class="text-left font-weight-bold"><?=$nombreServicio;?></td>
                          <td class="text-left">Egresos</td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgreso);?></td>
                          <td class="text-right <?=$colorPorcEg;?>"><?=formatNumberInt($porcEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgresoAnt);?></td>
                          <td class="text-right <?=$colorPorcEgAnt;?>"><?=formatNumberInt($porcEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosEgresos);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosEgresos);?></td>
                        </tr-->

                  <?php
                  //}                  
                  ?>
                      </tbody>
                    </table>
                  </div>
                  <!--HASTA AQUI LA TABLA-->

                </div>
              </div>
            </div>
        </div>  


  </div>


        </div>
    </div>

