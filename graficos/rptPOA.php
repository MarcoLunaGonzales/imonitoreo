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
$codIndicador=$_GET["codigo"];
$codGestion=$_GET["gestion"];

$nombreObjetivo=nameObjetivoxIndicador($codIndicador);
$nombreIndicador=nameIndicador($codIndicador);

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;
$_SESSION['codIndicador']=$codIndicador;

$dbh = new Conexion();
?>

<div class="content">
        <div class="container-fluid">
          <div class="container-fluid">
            <div class="header text-center">
              <h3 class="title">Reporte Seguimiento POA</h3>
              <h4 class="title">Objetivo: <?=$nombreObjetivo;?></h4>
              <h4 class="title">Indicador: <?=$nombreIndicador;?></h3>
              <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>

            </div>
            <div class="row">      
            </div>

            <?php
            $sql="SELECT iua.cod_area, iua.cod_unidadorganizacional FROM objetivos o, indicadores i, indicadores_unidadesareas iua WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and i.codigo in ($codIndicador) and o.cod_gestion='$codGestion' and i.codigo=iua.cod_indicador ";
            if($globalAdmin==0){
              $sql.=" and iua.cod_area in ($globalArea) and iua.cod_unidadorganizacional in ($globalUnidad) ";
            }
            $sql.=" group by iua.cod_area, iua.cod_unidadorganizacional";

            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $stmt->bindColumn('cod_area', $codAreaX);
            $stmt->bindColumn('cod_unidadorganizacional', $codUnidadX);
            
            while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
              $abrevArea=abrevArea($codAreaX);
              $abrevUnidad=abrevUnidad($codUnidadX);

              $planificadoMes=planificacionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,0);
              $ejecutadoMes=ejecucionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,0);
              $porcentaje=0;
              if($planificadoMes>0){
                $porcentaje=($ejecutadoMes/$planificadoMes)*100;
              }

              $planificadoMesAcum=planificacionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,1);
              $ejecutadoMesAcum=ejecucionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,1);
              $porcentajeAcum=0;
              if($planificadoMesAcum>0){
                $porcentajeAcum=($ejecutadoMesAcum/$planificadoMesAcum)*100;
              }

              $planificadoGestion=planificacionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,2);
              $ejecutadoGestion=ejecucionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,2);
              $porcentajeGestion=0;
              if($planificadoGestion>0){
                $porcentajeAcum=($ejecutadoGestion/$planificadoMesAcum)*100;
              }
            ?>

            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Datos <?=$abrevUnidad;?> - <?=$abrevArea;?>
                    </h4>
                  </div>
                  <div class="card-body">
                    <table width="100%" class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold" colspan="3"><?=$nombreMes?></th>
                          <th class="text-center font-weight-bold" colspan="3">Acum. <?=$nombreMes?></th>
                          <th class="text-center font-weight-bold" colspan="3">Gestion</th>
                        </tr>
                        <tr>
                          <th class="text-center font-weight-bold">Prog.</th>
                          <th class="text-center font-weight-bold">Ej.</th>
                          <th class="text-center font-weight-bold">%</th> 
                          <th class="text-center font-weight-bold">Prog.</th>
                          <th class="text-center font-weight-bold">Ej.</th>
                          <th class="text-center font-weight-bold">%</th>
                          <th class="text-center font-weight-bold">Prog.</th>
                          <th class="text-center font-weight-bold">Ej.</th>
                          <th class="text-center font-weight-bold">%</th>
                        </tr>
                        <tr>
                          <td class="text-right"><?=formatNumberInt($planificadoMes);?></td>
                          <td class="text-right"><?=formatNumberInt($ejecutadoMes);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentaje);?></td>
                          <td class="text-right"><?=formatNumberInt($planificadoMesAcum);?></td>
                          <td class="text-right"><?=formatNumberInt($ejecutadoMesAcum);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAcum);?></td>
                          <td class="text-right"><?=formatNumberInt($planificadoGestion);?></td>
                          <td class="text-right"><?=formatNumberInt($ejecutadoGestion);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeGestion);?></td>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    $codAreaX=$codAreaX;
                    $codUnidadX=$codUnidadX;
                    require("chartPOA.php");
                    ?>
                  </div>
                </div>
              </div>


            </div><!--ACA TERMINA ROW-->
            <?php
            }
            ?>
        </div>
      </div>
    </div>