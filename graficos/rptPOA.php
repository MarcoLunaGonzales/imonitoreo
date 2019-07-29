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
$codigoPerspectiva=$_GET["perspectiva"];

$nombreObjetivo=nameObjetivoxIndicador($codIndicador);
$nombreIndicador=nameIndicador($codIndicador);

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalPerfil=$_SESSION["globalPerfil"];

$globalUnidadesReports=$_SESSION["globalUnidadesReports"];
$globalAreasReports=$_SESSION["globalAreasReports"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;
$_SESSION['codIndicador']=$codIndicador;

$dbh = new Conexion();


$codIndicadorIngresos=obtieneValorConfig(8);
$arrayCodIngresos=explode(",", $codIndicadorIngresos);
$indiceBuscador=in_array($codIndicador,$arrayCodIngresos);

$codIndicadoresExcepcion=obtieneValorConfig(9);
$codIndicadorTotalPOA=obtieneValorConfig(10);

$indiceBuscadorClientes=false;
$codIndicadorClientesExcepcion=obtieneValorConfig(21);
$arrayCodClientes=explode(",", $codIndicadorClientesExcepcion);
$indiceBuscadorClientes=in_array($codIndicador,$arrayCodClientes);

$codAreasServicio="";
$codAreasServicio=obtieneValorConfig(22);

$codUnidadesServicio="";
$codUnidadesServicio=obtieneValorConfig(25);

$codIndicadorIncrementoClientes=obtieneValorConfig(23);
$codIndicadorRetencionClientes=obtieneValorConfig(24);

//echo $codIndicadorClientesExcepcion." array: ".$arrayCodClientes." indiceBus: ".$indiceBuscadorClientes;
//echo $indiceBuscadorClientes;

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
              
              <h6 class="text-left">
              <table><tr><td bgcolor="#FBB1E9">Nota: En las tablas la fila coloreada contiene la información de la version anterior.</td></tr></table>
              </h6>


            </div>
            <div class="row">      
            </div>


            <?php
            if($codIndicadorTotalPOA!=$codIndicador && $indiceBuscadorClientes==false){

              $sql="SELECT iua.cod_area, iua.cod_unidadorganizacional FROM objetivos o, indicadores i, indicadores_unidadesareas iua WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and i.codigo in ($codIndicador) and o.cod_gestion='$codGestion' and i.codigo=iua.cod_indicador";
                //PARA DIRECTOR NACIONAL EN CLIENTES Y PROCESOS INTERNOS SOLO AREAS DE SERVICIO
                if( $globalPerfil==7 && ($codigoPerspectiva==2 || $codigoPerspectiva==4) ){
                  $sql.=" and iua.cod_area in ($codAreasServicio) and iua.cod_unidadorganizacional in ($codUnidadesServicio)";
                }else{
                  $sql.=" and iua.cod_area in ($globalAreasReports) and iua.cod_unidadorganizacional in ($globalUnidadesReports) ";
                }
              $sql.=" group by iua.cod_area, iua.cod_unidadorganizacional ";

              $stmt = $dbh->prepare($sql);
              $stmt->execute();
              $stmt->bindColumn('cod_area', $codAreaX);
              $stmt->bindColumn('cod_unidadorganizacional', $codUnidadX);
              
              while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                $abrevArea=abrevArea($codAreaX);
                $abrevUnidad=abrevUnidad($codUnidadX);
                $nameUnidad=nameUnidad($codUnidadX);

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


                if($versionPOA>0){
                  $planificadoMesV=planificacionPorIndicadorVersion($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,0,$versionPOA);
                  $ejecutadoMesV=ejecucionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,0);
                  $porcentajeV=0;
                  if($planificadoMesV>0){
                    $porcentajeV=($ejecutadoMesV/$planificadoMesV)*100;
                  }

                  $planificadoMesAcumV=planificacionPorIndicadorVersion($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,1,$versionPOA);
                  $ejecutadoMesAcumV=ejecucionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,1);
                  $porcentajeAcumV=0;
                  if($planificadoMesAcumV>0){
                    $porcentajeAcumV=($ejecutadoMesAcumV/$planificadoMesAcumV)*100;
                  }

                  $planificadoGestionV=planificacionPorIndicadorVersion($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,2,$versionPOA);
                  $ejecutadoGestionV=ejecucionPorIndicador($codIndicador,$codAreaX,$codUnidadX,$mesTemporal,2);
                  $porcentajeGestionV=0;
                  if($planificadoGestionV>0){
                    $porcentajeGestionV=($ejecutadoGestionV/$planificadoGestionV)*100;
                  }
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
                      <h4 class="card-title">Datos POA: <?=$nameUnidad;?> - <?=$abrevArea;?>
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
                          <?php
                          if($versionPOA>0){
                          ?>
                          <tr>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($planificadoMesV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($ejecutadoMesV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($porcentajeV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($planificadoMesAcumV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($ejecutadoMesAcumV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($porcentajeAcumV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($planificadoGestionV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($ejecutadoGestionV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($porcentajeGestionV);?></td>
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
                    <div class="card-header card-header-icon card-header-info">
                      <div class="card-icon">
                        <i class="material-icons">timeline</i>
                      </div>
                      <h5 class="card-title">Grafica POA: <?=$nameUnidad;?> - <?=$abrevArea;?></h5>
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

                if($versionPOA>0){
                  $planificadoMesV=presupuestoIngresosMesVersion($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0,$versionPOA);
                  $ejecutadoMesV=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                  $porcentajeV=0;
                  if($planificadoMesV>0){
                    $porcentajeV=($ejecutadoMesV/$planificadoMesV)*100;
                  }

                  $planificadoMesAcumV=presupuestoIngresosMesVersion($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0,$versionPOA);
                  $ejecutadoMesAcumV=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);
                  $porcentajeAcumV=0;
                  if($planificadoMesAcumV>0){
                    $porcentajeAcumV=($ejecutadoMesAcumV/$planificadoMesAcumV)*100;
                  }
                }

              ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header card-header-icon card-header-success">
                      <div class="card-icon">
                        <i class="material-icons">bar_chart</i>
                      </div>
                      <h4 class="card-title">DatosPO: <?=$nameUnidad;?> - <?=$abrevArea;?>
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
                          <?php
                          if($versionPOA>0){
                          ?>
                          <tr>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($planificadoMesV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($ejecutadoMesV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($porcentajeV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($planificadoMesAcumV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($ejecutadoMesAcumV);?></td>
                            <td class="text-right" bgcolor="#FBB1E9"><?=formatNumberInt($porcentajeAcumV);?></td>
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
                    <div class="card-header card-header-icon card-header-success">
                      <div class="card-icon">
                        <i class="material-icons">bar_chart</i>
                      </div>
                      <h5 class="card-title">GraficaPO: <?=$nameUnidad;?> - <?=$abrevArea;?></h5>
                    </div>
                    <div class="card-body">
                      <?php
                      $codFondoX=$codFondo;
                      $codOrganismoX=$codOrganismo;
                      $codVersionX=$versionPOA;
                      if($versionPOA>0){
                        require("chartIngresosParamVersion.php");
                      }else{
                        require("chartIngresosParam.php");
                      }  
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

          if($codIndicadorTotalPOA==$codIndicador){
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
                  <h4 class="card-title">Datos POA: <?=$nameUnidad;?>
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
                  <h5 class="card-title">Grafica POA: <?=$nameUnidad;?></h5>
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

      <div class="row">
          <?php
          if($indiceBuscadorClientes==true && $codIndicador==$codIndicadorIncrementoClientes){
            
            $cadenaAreas=obtieneValorConfig(22);
            $cadenaUnidades=obtieneValorConfig(11);

            $sqlAreas="SELECT codigo, abreviatura from areas where codigo in ($cadenaAreas) order by 2";
            $stmtArea = $dbh->prepare($sqlAreas);
            $stmtArea->execute();
            $stmtArea->bindColumn('codigo', $codAreaX);
            $stmtArea->bindColumn('abreviatura', $nombreAreaX);
            while($rowArea = $stmtArea -> fetch(PDO::FETCH_BOUND)){
          ?>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Incremento de Clientes <?=$nombreAreaX;?>
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal-1;?></th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal;?></th>
                    <th class="text-center font-weight-bold">% Incremento</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);
                  $totalClientesAnt=0;
                  $totalClientes=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadClientesAnt=calcularClientesPeriodo($codigoX,$codAreaX,$mesTemporal,$anioTemporal-1);
                    $cantidadClientes=calcularClientesPeriodo($codigoX,$codAreaX,$mesTemporal,$anioTemporal);
                    $porcentajeCrec=0;
                    if($cantidadClientesAnt>0){
                      $porcentajeCrec=(($cantidadClientes-$cantidadClientesAnt)/$cantidadClientesAnt)*100;
                    }
                    $totalClientesAnt+=$cantidadClientesAnt;
                    $totalClientes+=$cantidadClientes;
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><a href="../rpt_indicadores/rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codAreaX;?>" target="_blank"><?=formatNumberInt($cantidadClientesAnt);?></a></td>
                    <td class="text-right"><a href="../rpt_indicadores/rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codAreaX;?>" target="_blank"><?=formatNumberInt($cantidadClientes);?></a></td>
                    <td class="text-center font-weight-bold text-primary"><?=formatNumberInt($porcentajeCrec);?> %</td>
                  </tr>
                  <?php
                  }
                  $porcentajeCrecTotal=0;
                  if($totalClientesAnt>0){
                    $porcentajeCrecTotal=(($totalClientes-$totalClientesAnt)/$totalClientesAnt)*100;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientesAnt);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientes);?></td>
                    <td class="text-center font-weight-bold"><?=formatNumberInt($porcentajeCrecTotal);?> %</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <?php
          }
        }
        ?>

        <?php
          if($indiceBuscadorClientes==true && $codIndicador==$codIndicadorRetencionClientes){
            
            $cadenaAreas=obtieneValorConfig(22);
            $cadenaUnidades=obtieneValorConfig(11);

            $sqlAreas="SELECT codigo, abreviatura from areas where codigo in ($cadenaAreas) order by 2";
            $stmtArea = $dbh->prepare($sqlAreas);
            $stmtArea->execute();
            $stmtArea->bindColumn('codigo', $codAreaX);
            $stmtArea->bindColumn('abreviatura', $nombreAreaX);
            while($rowArea = $stmtArea -> fetch(PDO::FETCH_BOUND)){
          ?>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Retencion de Clientes <?=$nombreAreaX;?>
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal;?></th>
                    <th class="text-center font-weight-bold">Clientes Retenidos</th>
                    <th class="text-center font-weight-bold">% Retencion</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);
                  $totalClientesRetenidos=0;
                  $totalClientes=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadClientes=calcularClientesPeriodo($codigoX,$codAreaX,$mesTemporal,$anioTemporal);
                    $cantidadRetenidos=calcularClientesRetenidos($codigoX,$codAreaX,$mesTemporal,$anioTemporal);
                    $porcentajeCrec=0;
                    if($cantidadClientes>0){
                      $porcentajeCrec=($cantidadRetenidos/$cantidadClientes)*100;
                    }
                    $totalClientesRetenidos+=$cantidadRetenidos;
                    $totalClientes+=$cantidadClientes;
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><a href="../rpt_indicadores/rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codAreaX;?>" target="_blank"><?=formatNumberInt($cantidadClientes);?></a></td>
                    <td class="text-right"><a href="../rpt_indicadores/rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codAreaX;?>" target="_blank"><?=formatNumberInt($cantidadRetenidos);?></a></td>
                    <td class="text-center font-weight-bold text-primary"><?=formatNumberInt($porcentajeCrec);?> %</td>
                  </tr>
                  <?php
                  }
                  $porcentajeCrecTotal=0;
                  if($totalClientes>0){
                    $porcentajeCrecTotal=($totalClientesRetenidos/$totalClientes)*100;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientes);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientesRetenidos);?></td>
                    <td class="text-center font-weight-bold"><?=formatNumberInt($porcentajeCrecTotal);?> %</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <?php
          }
        }
        ?>



        </div>
      </div>
    </div>