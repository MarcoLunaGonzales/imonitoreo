<?php

set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

session_start();
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();
$mes=$_GET["mes"];
$gestion=$_GET["gestion"];
$datosMes=explode("####", $_GET["mes"]);
if(count($datosMes)>0){
  $mes=$datosMes[0];
  if($datosMes[1]>0){
    $gestion=$datosMes[1];
  }  
}




$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

$globalGestion=$_SESSION["globalGestion"];
$globalUsuario=$_SESSION["globalUser"];
$codigo_proy=$_GET["codigo_proy"];
$nombre_proyecto=obtener_nombre_proyecto($codigo_proy);



//LLAMAMOS A UN SP QUE ORDENA LOS COMPONENTES O ACTIVIDADES SIS
$sql = 'CALL ordenar_componentes(?,?,?)';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $globalUsuario, PDO::PARAM_INT, 10);
$stmt->bindParam(2, $globalGestion, PDO::PARAM_INT, 10);
$stmt->bindParam(3, $codigo_proy, PDO::PARAM_INT, 10);
$stmt->execute();


$sql="SELECT codigo, nombre, abreviatura, nivel, cod_padre, cod_estado, partida, indice, cod_usuario from componentessis_orden 
  where cod_usuario='$globalUsuario' ORDER BY indice";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigoComponente);
$stmt->bindColumn('partida', $partidaComponente);
$stmt->bindColumn('nombre', $nombreComponente);
$stmt->bindColumn('abreviatura', $abreviaturaComponente);
$stmt->bindColumn('nivel', $nivelComponente);

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
                  <h4 class="card-title">Reporte Seguimiento Detallado de Proyecto <?=$nombre_proyecto?></h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="main">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                          <?php
                          $sqlSolicitudes="SELECT count(*)as nroregistros from solicitud_fondos s where s.cod_estado=1 and s.cod_gestion='$gestion' and YEAR(s.fecha)='$anio' and MONTH(s.fecha)<='$mes' order by s.fecha;";
                          $stmtSolicitudes = $dbh->prepare($sqlSolicitudes);
                          $stmtSolicitudes->execute();
                          $stmtSolicitudes->bindColumn('nroregistros', $nroRegistros);
                          while($rowSolicitudes = $stmtSolicitudes->fetch(PDO::FETCH_BOUND)) {
                          ?>
                          <th class="text-center font-weight-bold" colspan="<?=$nroRegistros;?>">Solicitud de Fondos</th>
                          <?php
                          }
                          ?>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                          <th class="text-center font-weight-bold">&nbsp;</th>
                        </tr>

                        <tr>
                          <th class="text-center font-weight-bold">Codigo</th>
                          <th class="text-center font-weight-bold">Actividad</th>
                          <th class="text-center font-weight-bold">Presupuesto</th>
                          <?php
                          $sqlSolicitudes="SELECT s.codigo, s.fecha from solicitud_fondos s where s.cod_estado=1 and s.cod_gestion='$gestion' and YEAR(s.fecha)='$anio' and MONTH(s.fecha)<='$mes' order by s.fecha;";
                          $stmtSolicitudes = $dbh->prepare($sqlSolicitudes);
                          $stmtSolicitudes->execute();
                          $stmtSolicitudes->bindColumn('codigo', $codSolicitud);
                          $stmtSolicitudes->bindColumn('fecha', $fechaSolicitud);
                          while($rowSolicitudes = $stmtSolicitudes->fetch(PDO::FETCH_BOUND)) {
                          ?>
                          <th class="text-center font-weight-bold"><?=$fechaSolicitud;?></th>
                          <?php
                          }
                          ?>
                          <th class="text-center font-weight-bold">Total</br>Sol.Fondos</th>
                          <th class="text-center font-weight-bold">Ejecucion</th>
                          <th class="text-center font-weight-bold">Diferencia</th>
                          <th class="text-center font-weight-bold">% Ejecucion</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {

                          $responsable=obtenerResponsableSIS($codigoComponente);

                          if($nivelComponente==1){
                            $styleText="text-left font-weight-bold text-danger";
                          }
                          if($nivelComponente==2){
                            $styleText="text-left font-weight-bold text-primary";
                          }
                          if($nivelComponente==3){
                            $styleText="text-left font-weight-bold small";
                          }
                          
                          $montoPresComponente=montoPresupuestoComponente($gestion,$anio,$mes,$codigoComponente,$nivelComponente);
                          $montoEjecucionComponente=montoEjecucionComponente($anio,$mes,$codigoComponente, $nivelComponente);
                      ?>
                        <tr>
                          <td class="<?=$styleText;?>" ><?=$abreviaturaComponente;?></td>
                          <td><p class="<?=$styleText;?>" ><?=$nombreComponente;?></p><p class="text-left font-weight-bold text-primary small"><?=$responsable;?></p></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($montoPresComponente,2);?></td>
                          <?php
                          $stmtSolicitudes->execute();
                          $totalSolicitudes=0;
                          while($rowSolicitudes = $stmtSolicitudes->fetch(PDO::FETCH_BOUND)) {
                            $montoSolicitudComponente=montoSolicitudComponente($codSolicitud, $codigoComponente,$nivelComponente);
                            $totalSolicitudes+=$montoSolicitudComponente;
                          ?>
                          <td class="text-right"><?=formatNumberInt($montoSolicitudComponente,2);?></td><?php
                          }
                          ?>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($totalSolicitudes,2);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberDec($montoEjecucionComponente,2);?></td>
                          <td class="text-right"><?=formatNumberDec(($totalSolicitudes-$montoEjecucionComponente),2);?></td>
                          <?php
                          $porcentajeEjecucion=0;
                          if($montoPresComponente>0){
                            $porcentajeEjecucion=($montoEjecucionComponente/$montoPresComponente)*100;
                          }
                          ?>
                          <td class="text-right"><?=formatNumberDec($porcentajeEjecucion,2);?>%</td>
                        </tr>
                      <?php
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
  totalesSIS();
</script>