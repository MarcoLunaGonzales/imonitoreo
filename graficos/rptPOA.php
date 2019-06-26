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
$versionPOA=$_GET["version"];


$nombreObjetivo=nameObjetivoxIndicador($codIndicador);
$nombreIndicador=nameIndicador($codIndicador);

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalUnidadesReports=$_SESSION["globalUnidadesReports"];
$globalAreasReports=$_SESSION["globalAreasReports"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;
$_SESSION['codIndicador']=$codIndicador;

$dbh = new Conexion();

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=8");
$stmt->execute();
$codIndicadorIngresos=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codIndicadorIngresos=$row['valor_configuracion'];
}
$arrayCodIngresos=explode(",", $codIndicadorIngresos);
$indiceBuscador=in_array($codIndicador,$arrayCodIngresos);


$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=9");
$stmt->execute();
$codIndicadoresExcepcion=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codIndicadoresExcepcion=$row['valor_configuracion'];
}

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=10");
$stmt->execute();
$codIndicadorTotalPOA=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codIndicadorTotalPOA=$row['valor_configuracion'];
}

//echo "indicadodrTotal: ".$codIndicadorTotalPOA." indicadornoraml: ".$codIndicador;

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
            if($codIndicadorTotalPOA!=$codIndicador){ 

              $sql="SELECT iua.cod_area, iua.cod_unidadorganizacional FROM objetivos o, indicadores i, indicadores_unidadesareas iua WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and i.codigo in ($codIndicador) and o.cod_gestion='$codGestion' and i.codigo=iua.cod_indicador";
              if($globalAdmin==0){
                $sql.=" and iua.cod_area in ($globalAreasReports) and iua.cod_unidadorganizacional in ($globalUnidadesReports) ";
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
                  $porcentajeGestion=($ejecutadoGestion/$planificadoGestion)*100;
                }
            ?>

              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header card-header-icon card-header-info">
                      <div class="card-icon">
                        <a href="detalleActividadPOA.php?codIndicador=<?=$codIndicador?>&area=<?=$codAreaX?>&unidad=<?=$codUnidadX;?>" target="_BLANK">
                          <i class="material-icons">list</i>
                        </a>
                      </div>
                      <h4 class="card-title">Datos POA: <?=$abrevUnidad;?> - <?=$abrevArea;?>
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
                      <h5 class="card-title">Grafica POA: <?=$abrevUnidad;?> - <?=$abrevArea;?></h5>
                    </div>
                    <div class="card-body">
                      <?php
                      $codAreaX=$codAreaX;
                      $codUnidadX=$codUnidadX;
                      $codVersionX=$versionPOA;
                      if($versionPOA>0){
                        require("chartPOAVersion.php");
                      }else{
                        require("chartPOA.php");                        
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div><!--ACA TERMINA ROW-->


              <!--ESTA PARTE ES PAR EL INDICADOR 13 O LOS CONFIGURADOS-->  
              <?php
              if($indiceBuscador==true){
                $codFondo=buscarHijosUO($codUnidadX);
                $codFondo=obtenerFondosReport($codFondo);
                $codOrganismo=obtenerOrganismosReport($codAreaX);

                //echo "fondo:".$codFondo;
                //echo "organismo:".$codOrganismo;

                $planificadoMes=presupuestoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                $ejecutadoMes=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                $porcentaje=0;
                if($planificadoMes>0){
                  $porcentaje=($ejecutadoMes/$planificadoMes)*100;
                }

                $planificadoMesAcum=presupuestoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);
                $ejecutadoMesAcum=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);
                $porcentajeAcum=0;
                if($planificadoMesAcum>0){
                  $porcentajeAcum=($ejecutadoMesAcum/$planificadoMesAcum)*100;
                }

              ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header card-header-icon card-header-success">
                      <div class="card-icon">
                        <i class="material-icons">bar_chart</i>
                      </div>
                      <h4 class="card-title">DatosPO: <?=$abrevUnidad;?> - <?=$abrevArea;?>
                      </h4>
                    </div>
                    <div class="card-body">
                      <table width="100%" class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center font-weight-bold" colspan="3"><?=$nombreMes?></th>
                            <th class="text-center font-weight-bold" colspan="3">Acum. <?=$nombreMes?></th>
                          </tr>
                          <tr>
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
                    <div class="card-header card-header-icon card-header-success">
                      <div class="card-icon">
                        <i class="material-icons">bar_chart</i>
                      </div>
                      <h5 class="card-title">GraficaPO: <?=$abrevUnidad;?> - <?=$abrevArea;?></h5>
                    </div>
                    <div class="card-body">
                      <?php
                      $codFondoX=$codFondo;
                      $codOrganismoX=$codOrganismo;
                      require("chartIngresosParam.php");
                      ?>
                    </div>
                  </div>
                </div>
              </div><!--ACA TERMINA ROW-->
              <!--FIN EXCEPCION EN LOS INDICADORES-->  
              <?php
              }//FIN DEL IF PARA INDICADORES EXCEPCION
            }
          }
          else{
          //ESTA ES LA PARTE PARA EL INDICADOR DE ACTIVIDADES TOTALES POR UNIDAD
          $sql="SELECT iua.cod_unidadorganizacional FROM objetivos o, indicadores i, indicadores_unidadesareas iua WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and i.codigo in ($codIndicador) and o.cod_gestion='$codGestion' and i.codigo=iua.cod_indicador";
          /*if($globalAdmin==0){
            $sql.=" and iua.cod_area in ($globalArea) and iua.cod_unidadorganizacional in ($globalUnidad) ";
          }*/
          $sql.=" group by iua.cod_unidadorganizacional";
          //echo $sql;
          $stmt = $dbh->prepare($sql);
          $stmt->execute();
          $stmt->bindColumn('cod_unidadorganizacional', $codUnidadX);
          
          while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
            $abrevUnidad=abrevUnidad($codUnidadX);

            $sqlArea="SELECT iua.cod_area FROM objetivos o, indicadores i, indicadores_unidadesareas iua WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and i.codigo in ($codIndicador) and o.cod_gestion='$codGestion' and iua.cod_unidadorganizacional in ($codUnidadX) and i.codigo=iua.cod_indicador";
            /*if($globalAdmin==0){
              $sql.=" and iua.cod_area in ($globalArea) and iua.cod_unidadorganizacional in ($globalUnidad) ";
             }*/
            $sqlArea.=" group by iua.cod_area";
            //echo $sqlArea;
            $stmtArea = $dbh->prepare($sqlArea);
            $stmtArea->execute();
            $stmtArea->bindColumn('cod_area', $codAreaX);
          ?>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header card-header-icon card-header-primary">
                  <div class="card-icon">
                    <i class="material-icons">list</i>
                  </div>
                  <h4 class="card-title">Datos POA: <?=$abrevUnidad;?>
                  </h4>
                </div>
                <div class="card-body">
                  <table width="100%" class="table table-condensed">
                    <thead>
                      <tr>
                        <th class="text-center font-weight-bold">Area</th>
                        <th class="text-center font-weight-bold" colspan="3"><?=$nombreMes?></th>
                        <th class="text-center font-weight-bold" colspan="3">Acum. <?=$nombreMes?></th>
                        <th class="text-center font-weight-bold" colspan="3">Gestion</th>
                      </tr>
                      <tr>
                        <th class="text-center font-weight-bold">-</th>
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
                      <?php
                      while($rowArea=$stmtArea->fetch(PDO::FETCH_BOUND)){
                        $abrevArea=abrevArea($codAreaX);

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
                          $porcentajeGestion=($ejecutadoGestion/$planificadoGestion)*100;
                        }              
                      ?>
                      <tr>
                        <td class="text-left"><a href="detalleActividadPOA.php?codIndicador=<?=$codIndicador;?>&unidad=<?=$codUnidadX;?>&area=<?=$codAreaX;?>&codActividad=0" target="_blank"><?=$abrevArea;?></a></td>
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
                      <?php
                      }
                      ?>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header card-header-icon card-header-primary">
                  <div class="card-icon">
                    <i class="material-icons">timeline</i>
                  </div>
                  <h5 class="card-title">Grafica POA: <?=$abrevUnidad;?></h5>
                </div>
                <div class="card-body">
                  <?php
                  $codUnidadX=$codUnidadX;
                  require("chartPOATotalAct.php");
                  ?>
                </div>
              </div>
            </div>
          </div><!--ACA TERMINA ROW-->
          <?php
          }
        }
          ?>

        </div>
      </div>
    </div>