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

$gestion=$_GET["gestion"];
$anio=nameGestion($gestion);
$mes=$_GET["mes"];

$organismoV=$_GET["organismos"];
$organismos=implode(",", $organismoV);
$organismoArray=str_replace(',', '|', $organismos);


$cadenaOrganismos=0;
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}
$cadenaOrganismos=$organismos;

//echo $cadenaOrganismos;


$cuentaIT='';
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=3");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cuentaIT=$row['valor_configuracion'];
}

$cuentaDN='';
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=4");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cuentaDN=$row['valor_configuracion'];
}

$cuentaSA='';
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=5");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cuentaSA=$row['valor_configuracion'];
}


//FONDOS
$cadenaFondosTodo='';
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=7");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaFondosTodo=$row['valor_configuracion'];
}
?>
<script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>
<script>var filaChart=0;</script>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="card">
        <div class="card-header <?=$colorCard;?> card-header-icon">
                  <div class="card-icon">
                    <a href="../graficos/rptComposicionIngresos.php?anio=<?=$anio;?>&mes=<?=$mes;?>&codigosFondo=<?=$cadenaFondosTodo;?>" target="_blank" title="Ver Composicion Ingresos">
                      <i class="material-icons">pie_chart</i>
                    </a>
                  </div>
                  <h4 class="card-title">Reporte Seguimiento PO por Area y Regional</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?></h6>
                  <h6 class="card-title">Mes: <?=$mes;?></h6>
        </div>

        <?php
        $sqlOrganismos="SELECT o.codigo, o.nombre from po_organismos o where o.codigo in ($cadenaOrganismos)";
        $stmtOrganismo=$dbh->prepare($sqlOrganismos);
        $stmtOrganismo->execute();
        $superIndex=0;
        while($rowOrganismo=$stmtOrganismo->fetch(PDO::FETCH_ASSOC)){
          $codOrganismoX=$rowOrganismo['codigo']; 
          $nombreOrganismoX=$rowOrganismo['nombre']; 

        ?>
    <div class="row">
      
        <?php
          $montoEjecutadoGrupo1=0;
          $montoEjecutadoGrupo2=0;
          $montoEjecutadoGrupo3=0;

          $nombreGrupo1="";
          $nombreGrupo2="";
          $nombreGrupo3="";

          //for ($i=1;$i<=3;$i++) {                    
            $nombreConjunto="";
            $nombreConjunto=nameGrupoFondo(0);
            $codigosConjunto=codigosGrupoFondo(0);
          ?>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <a href="../graficos/chartTendencias.php?codigosFondo=<?=$codigosConjunto;?>&nombreFondo=<?=$nombreConjunto;?>&mes=<?=$mes;?>&anio=<?=$anio;?>&organismo=<?=$codOrganismoX;?>" target="_blank" title="Ver Reporte de Tendencias">
                <i class="material-icons">bar_chart</i>
              </a>
            </div>
            <div class="card-icon">
              <a href="../graficos/rptComposicionIngresos.php?anio=<?=$anio;?>&mes=<?=$mes;?>&codigosFondo=<?=$codigosConjunto;?>" target="_blank" title="Composicion de Ingresos">
                <i class="material-icons">pie_chart</i>
              </a>
            </div>

          </div>
          <!--div class="card-body"-->
            <table width="100%">
              <thead>
                <tr>
                  <th colspan="5" class="text-center font-weight-bold"><?=$nombreOrganismoX;?> - <?=$nombreConjunto;?></th>
                </tr>
                <tr>
                  <th class="text-center font-weight-bold">-</th>
                  <th class="text-center font-weight-bold">Pres.</th>
                  <th class="text-center font-weight-bold">Eje.</th>
                  <th class="text-center font-weight-bold">%</th>
                  <!--th class="text-center font-weight-bold">Part.</th-->
                </tr>
              </thead>
              <tbody>
              <?php
                //SACAMOSM EL DETALLE CONJUNTO
                $montoPresIngConjunto=presupuestoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $montoEjIngConjunto=ejecutadoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);


                /*BORRAR SOLO TEMPORAL PARA MAYO Y JUNIO 2022*/
                if($anio==2022 && $mes==5 && $codOrganismoX==508){
                  $montoEjIngConjunto=$montoEjIngConjunto+133632;
                }
                if($anio==2022 && $mes==6 && $codOrganismoX==508){
                  $montoEjIngConjunto=$montoEjIngConjunto-133632;
                }
                /*FIN BORRAR*/

                $porcentajeIngConjunto=0;
                if($montoPresIngConjunto>0){
                  $porcentajeIngConjunto=($montoEjIngConjunto/$montoPresIngConjunto)*100;
                }

                //SACAMOS LOS MONTOS PARA LA PARTICIPACION DE LOS INGRESOS TABLA FINAL
                  $montoEjecutadoGrupo3=$montoEjIngConjunto;
                  $nombreGrupo3=$nombreConjunto;
                

                $colorPorcentajeIngreso=colorPorcentajeIngreso($porcentajeIngConjunto);

                $valorIngresoFormat=number_format(calcularValorEnPoncentaje($montoEjIngConjunto,$montoPresIngConjunto),0,'.','');
                
                /*AQUI SACAREMOS LOS INGRESOS DEVENGADOS*/

                ?>
                <tr>
                  <td class="text-left font-weight-bold">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">Ingresos
                    </a>
                  </td>
                  <td class="text-right  font-weight-bold table-warning"><?=formatNumberInt($montoPresIngConjunto);?>
                  </td>
                  <td class="text-right font-weight-bold table-warning">
                    <?=formatNumberInt($montoEjIngConjunto);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($porcentajeIngConjunto);?></td>
                  <!--td class="text-right  font-weight-bold table-warning"><?=formatNumberInt(100);?></td-->
                </tr>

                <?php
                $codCuentaIngresos1="4010103001";
                $codCuentaIngresos2="4010103003";
                $codCuentaIngresos3="4010103004";

                $nombreCuenta1=nameCuenta($codCuentaIngresos1);
                $nombreCuenta2=nameCuenta($codCuentaIngresos2);
                $nombreCuenta3="Ingresos FOR a NO";

                $ejecutadoCuenta1=ejecutadoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 0, $codCuentaIngresos1);
                $ejecutadoCuenta2=ejecutadoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 0, $codCuentaIngresos2);
                $ejecutadoCuenta3=ejecutadoIngresosMesNOEspecial($codigosConjunto, $anio, $mes, $codOrganismoX, 0, $codCuentaIngresos1);

                $presupuestoCuenta1=presupuestoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 0, $codCuentaIngresos1);
                $presupuestoCuenta2=presupuestoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 0, $codCuentaIngresos2);
                $presupuestoCuenta3=presupuestoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 0, $codCuentaIngresos3);

                $ejecutadoCuenta1=$ejecutadoCuenta1-$ejecutadoCuenta3;  

                $porcentajeCuenta1NO=0;
                $porcentajeCuenta2NO=0;
                $porcentajeCuenta3NO=0;
                
                if($ejecutadoCuenta1>0){ $porcentajeCuenta1NO=($ejecutadoCuenta1/$presupuestoCuenta1)*100;               }
                if($ejecutadoCuenta2>0){ $porcentajeCuenta2NO=($ejecutadoCuenta2/$presupuestoCuenta2)*100;               }
                if($ejecutadoCuenta3>0){ $porcentajeCuenta3NO=($ejecutadoCuenta3/$presupuestoCuenta3)*100;;               }

                if($codOrganismoX==510){
                ?>
                <tr>
                  <td class="text-left text-muted">
                    <?=$nombreCuenta1;?>
                  </td>
                  <td class="text-center text-muted table-warning">
                    <?=formatNumberInt($presupuestoCuenta1);?></td>
                  <td class="text-right text-muted table-warning">
                    <?=formatNumberInt($ejecutadoCuenta1);?></td>
                  <td class="text-right text-muted"><?=formatNumberInt($porcentajeCuenta1NO);?></td>
                  <td class="text-center text-muted table-warning">-</td>
                </tr>
                <tr>
                  <td class="text-left text-muted">
                    <?=$nombreCuenta2;?>
                  </td>
                  <td class="text-center text-muted table-warning"><?=formatNumberInt($presupuestoCuenta2);?></td>
                  <td class="text-right text-muted table-warning">
                    <?=formatNumberInt($ejecutadoCuenta2);?></td>
                  <td class="text-right text-muted"><?=formatNumberInt($porcentajeCuenta2NO);?></td>
                  <!--td class="text-center text-muted table-warning">-</td-->
                </tr>
                <tr>
                  <td class="text-left text-muted">
                    <?=$nombreCuenta3;?>
                  </td>
                  <td class="text-center text-muted table-warning"><?=formatNumberInt($presupuestoCuenta3);?></td>
                  <td class="text-right text-muted table-warning">
                    <?=formatNumberInt($ejecutadoCuenta3);?></td>
                  <td class="text-right text-muted"><?=formatNumberInt($porcentajeCuenta3NO);?></td>
                  <!--td class="text-center text-muted table-warning">-</td-->
                </tr>                
                <?php
                }
                //SACAMOSM EL DETALLE CONJUNTO EGRESOS
                $montoPresEgConjunto=presupuestoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $montoEjEgConjunto=ejecutadoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);


                $porcentajeEgConjunto=0;
                if($montoPresEgConjunto>0){
                  $porcentajeEgConjunto=($montoEjEgConjunto/$montoPresEgConjunto)*100;
                }

                $colorPorcentajeEgreso=colorPorcentajeEgreso($porcentajeEgConjunto);
                $valorEgresoFormat=number_format(calcularValorEnPoncentaje($montoEjEgConjunto,$montoPresEgConjunto),0,'.','');
                ?>
                <tr>
                  <td class="text-left font-weight-bold">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">
                    Egresos
                    </a>  
                  </td>
                  <td class="text-right  font-weight-bold table-info"><?=formatNumberInt($montoPresEgConjunto);?></td>
                  <td class="text-right font-weight-bold table-info"><?=formatNumberInt($montoEjEgConjunto);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeEgreso;?>"><?=formatNumberInt($porcentajeEgConjunto);?></td>
                  <!--td class="text-right  font-weight-bold table-info"><?=formatNumberInt(100);?></td-->
                </tr>
                <?php
                $resultadoPres=$montoPresIngConjunto-$montoPresEgConjunto;
                $resultadoEj=$montoEjIngConjunto-$montoEjEgConjunto;
                $porcentajeResultado=0;
                if($resultadoPres>0){
                  $porcentajeResultado=($resultadoEj/$resultadoPres)*100;
                }
    ?>            
                <tr>
                  <td class="font-weight-bold">Resultado Mes</td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoPres);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoEj);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($porcentajeResultado);?></td>
                  <!--td class="text-right font-weight-bold">-</td-->
                 </tr>
                 <?php
                 //ACA SACAMOS LOS DATOS PARA LOS ACUMULADOS
                  $montoPresIngAcumulado=presupuestoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $montoEjIngAcumulado=ejecutadoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);

                  /*BORRAR SOLO TEMPORAL PARA MAYO Y JUNIO 2022*/
                  if($anio==2022 && $mes==5 && $codOrganismoX==508){
                    $montoEjIngAcumulado=$montoEjIngAcumulado+133632;
                  }
                  if($anio==2022 && $mes==6 && $codOrganismoX==508){
                    //$montoEjIngAcumulado=$montoEjIngAcumulado-133632;
                  }
                  /*FIN BORRAR*/


                  $montoPresIngGestion=presupuestoIngresosMes($codigosConjunto,$anio,12,$codOrganismoX,1,0);
  

                  $porcentajeIngAcum=0;
                  if($montoPresIngAcumulado>0){
                    $porcentajeIngAcum=($montoEjIngAcumulado/$montoPresIngAcumulado)*100;
                  }
                  $colorPorcentajeIngreso=colorPorcentajeIngreso($porcentajeIngAcum);

                  $porcentajeIngGestion=0;
                  if($montoPresIngGestion>0){
                    $porcentajeIngGestion=($montoEjIngAcumulado/$montoPresIngGestion)*100;
                  }
                  $colorPorcentajeIngresoGestion=colorPorcentajeIngreso($porcentajeIngGestion);

                 $valorIngresoFormatAcumulado=number_format(calcularValorEnPoncentaje($montoEjIngAcumulado,$montoPresIngAcumulado),0,'.','');


                 $valorPlanificadoMes=100;
                 $valorEjecutadoMes=90;

                 $valorPlanificadoAcum=200;
                 $valorEjecutadoAcum=190;
                 ?>
                 <tr>
                  <td class="font-weight-bold">
                    <a href="seguimientoPOxCuentaAcum.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">
                      Ing.Acum.
                    </a>
                  </td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoPresIngAcumulado);?></td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoEjIngAcumulado);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($porcentajeIngAcum);?></td>
                  <!--td class="text-right font-weight-bold  table-warning">-</td-->
                </tr>
                   

                <?php
                $codCuentaIngresos1="4010103001";
                $codCuentaIngresos2="4010103003";
                $codCuentaIngresos3="4010103004";

                $nombreCuenta1=nameCuenta($codCuentaIngresos1);
                $nombreCuenta2=nameCuenta($codCuentaIngresos2);
                $nombreCuenta3="Ingresos FOR a NO";

                $ejecutadoCuenta1=ejecutadoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 1, $codCuentaIngresos1);
                $ejecutadoCuenta2=ejecutadoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 1, $codCuentaIngresos2);
                $ejecutadoCuenta3=ejecutadoIngresosMesNOEspecial($codigosConjunto, $anio, $mes, $codOrganismoX, 1, $codCuentaIngresos1);

                $presupuestoCuenta1=presupuestoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 1, $codCuentaIngresos1);
                $presupuestoCuenta2=presupuestoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 1, $codCuentaIngresos2);
                $presupuestoCuenta3=presupuestoIngresosMes($codigosConjunto, $anio, $mes, $codOrganismoX, 1, $codCuentaIngresos3);

                $ejecutadoCuenta1=$ejecutadoCuenta1-$ejecutadoCuenta3;  

                $porcentajeCuenta1NO=0;
                $porcentajeCuenta2NO=0;
                $porcentajeCuenta3NO=0;
                
                if($ejecutadoCuenta1>0){ $porcentajeCuenta1NO=($ejecutadoCuenta1/$presupuestoCuenta1)*100;               }
                if($ejecutadoCuenta2>0){ $porcentajeCuenta2NO=($ejecutadoCuenta2/$presupuestoCuenta2)*100;               }
                if($ejecutadoCuenta3>0){ $porcentajeCuenta3NO=($ejecutadoCuenta3/$presupuestoCuenta3)*100;;               }

                if($codOrganismoX==510){
                ?>
                <tr>
                  <td class="text-left text-muted">
                    <?=$nombreCuenta1;?>
                  </td>
                  <td class="text-center text-muted table-warning"><?=formatNumberInt($presupuestoCuenta1);?></td>
                  <td class="text-right text-muted table-warning">
                    <?=formatNumberInt($ejecutadoCuenta1);?></td>
                  <td class="text-right text-muted"><?=formatNumberInt($porcentajeCuenta1NO);?></td>
                  <!--td class="text-center text-muted table-warning">-</td-->
                </tr>
                <tr>
                  <td class="text-left text-muted">
                    <?=$nombreCuenta2;?>
                  </td>
                  <td class="text-center text-muted table-warning"><?=formatNumberInt($presupuestoCuenta2);?></td>
                  <td class="text-right text-muted table-warning">
                    <?=formatNumberInt($ejecutadoCuenta2);?></td>
                  <td class="text-right text-muted"><?=formatNumberInt($porcentajeCuenta2NO);?></td>
                  <!--td class="text-center text-muted table-warning">-</td-->
                </tr>
                <tr>
                  <td class="text-left text-muted">
                    <?=$nombreCuenta3;?>
                  </td>
                  <td class="text-center text-muted table-warning"><?=formatNumberInt($presupuestoCuenta3);?></td>
                  <td class="text-right text-muted table-warning">
                    <?=formatNumberInt($ejecutadoCuenta3);?></td>
                  <td class="text-right text-muted"><?=formatNumberInt($porcentajeCuenta3NO);?></td>
                  <!--td class="text-center text-muted table-warning">-</td-->
                </tr>                
                <?php
                }

                 //ACA SACAMOS LOS DATOS PARA LOS ACUMULADOS
                  $montoPresEgAcumulado=presupuestoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $montoEjEgAcumulado=ejecutadoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);

                  /*CASO EXCEPCIONAL*/
                  /*$montoExtra=15000;
                  if($codOrganismoX==505){
                    $montoEjEgAcumulado=$montoEjEgAcumulado+$montoExtra;
                  }
                  if($codOrganismoX==510){
                    $montoEjEgAcumulado=$montoEjEgAcumulado-$montoExtra;
                  }*/


                  $porcentajeEgAcum=0;
                  if($montoPresEgAcumulado>0){
                    $porcentajeEgAcum=($montoEjEgAcumulado/$montoPresEgAcumulado)*100;
                  }
                  $colorPorcentajeEgreso=colorPorcentajeEgreso($porcentajeEgAcum);

                  $valorEgresoFormatAcumulado=number_format(calcularValorEnPoncentaje($montoEjEgAcumulado,$montoPresEgAcumulado),0,'.','');
                 ?>
                 <tr>
                  <td class="font-weight-bold">
                    <a href="seguimientoPOxCuentaAcum.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">Eg.Acum.
                    </a>  
                  </td>
                  <td class="text-right font-weight-bold table-info"><?=formatNumberInt($montoPresEgAcumulado);?></td>
                  <td class="text-right font-weight-bold table-info"><?=formatNumberInt($montoEjEgAcumulado);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeEgreso;?>"><?=formatNumberInt($porcentajeEgAcum);?></td>
                  <!--td class="text-right font-weight-bold table-info">-</td-->
                 </tr>

                <?php
                $resultadoPresAcum=$montoPresIngAcumulado-$montoPresEgAcumulado;
                $resultadoEjAcum=$montoEjIngAcumulado-$montoEjEgAcumulado;

                $porcentajeResultado=0;
                if($resultadoPresAcum>0){
                  $porcentajeResultado=($resultadoEjAcum/$resultadoPresAcum)*100;
                }
                ?>            
                <tr>
                  <td class="font-weight-bold">Resultado Acum.</td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoPresAcum);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoEjAcum);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($porcentajeResultado);?></td>
                  <!--td class="text-right font-weight-bold">-</td-->
               </tr>


              </tbody>
            </table>

            <table width="100%">
              <tr>
                <td class="text-center font-weight-bold table-success" colspan="2">
                  Rentabilidad Mes: <?=($montoEjIngConjunto>0)?formatNumberInt(($resultadoEj/$montoEjIngConjunto)*100):0;?> %
                </td>
                <td class="text-center font-weight-bold table-success" colspan="2">
                  Rentabilidad Acum: <?=($montoEjIngAcumulado>0)?formatNumberInt(($resultadoEjAcum/$montoEjIngAcumulado)*100):0;?> %
                </td>
              </tr>

              <tr>
                <td class="text-center font-weight-bold table-success" colspan="2">
                  -
                </td>
                <td class="text-center font-weight-bold table-success" colspan="2">
                  -
                </td>
              </tr>

              <tr>
                  <td class="font-weight-bold">
                      Ingresos GESTIÓN
                    </a>
                  </td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoPresIngGestion);?></td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoEjIngAcumulado);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeIngresoGestion;?>"><?=formatNumberInt($porcentajeIngGestion);?></td>
                </tr>
              
            </table>

          <!--/div-->
        </div>
      </div>




      <div class="col-md-5 div-center">
        <div class="card card-chart text-center">
          <div class="card-header card-header" data-header-animation="false" style="background:<?=$estiloHome?> !important;">
             <h4>Seguimiento Actividades</h4>
          </div>
        </div>  
          <?php
          $sqlActividades="SELECT e.nombre,e.planificado, e.ejecutado, e.planificado_acum, e.ejecutado_acum from ejecucion_temporal e, po_organismos po where po.codigo='$codOrganismoX' and po.cod_area=e.cod_area;";
          $stmtActividades=$dbh->prepare($sqlActividades);
          $stmtActividades->execute();
          while($rowActividades=$stmtActividades->fetch(PDO::FETCH_ASSOC)){
            $nombreActividad=$rowActividades['nombre'];
            $planificadoMes=$rowActividades['planificado']; 
            $ejecutadoMes=$rowActividades['ejecutado']; 
            
            $porcentajeActMes=($ejecutadoMes/$planificadoMes)*100;
            $colorPorcentajeAct=colorPorcentajeIngreso($porcentajeActMes);
            $colorPorcentajeAct=substr($colorPorcentajeAct, 3);
            //echo $colorPorcentajeAct;

            $planificadoMesAcum=$rowActividades['planificado_acum']; 
            $ejecutadoMesAcum=$rowActividades['ejecutado_acum']; 

            $porcentajeActMesAcum=($ejecutadoMesAcum/$planificadoMesAcum)*100;
            $colorPorcentajeActAcum=colorPorcentajeIngreso($porcentajeActMesAcum);
            $colorPorcentajeActAcum=substr($colorPorcentajeActAcum, 3);

          ?>

          <div class="row">

          <div class="col-md-6">
                <div class="card card-stats">
                  <div class="card-header card-header-<?=$colorPorcentajeAct;?> card-header-icon">
                    <div class="card-icon">
                      <h3><?=formatNumberInt($porcentajeActMes);?>%</h3>
                    </div>
                    <p class="card-category"><small>Planificado</small></p>
                    <h3 class="card-title"><?=$planificadoMes;?></h3>

                    <p class="card-category"><small>Ejecutado</small></p>
                    <h3 class="card-title"><?=$ejecutadoMes;?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">local_offer</i> <p class="font-weight-bold"><?=$nombreActividad;?> - Mes</p>
                    </div>
                  </div>
                </div>
          </div>

          <div class="col-md-6">
                <div class="card card-stats">
                  <div class="card-header card-header-<?=$colorPorcentajeActAcum;?> card-header-icon">
                    <div class="card-icon">
                      <h3><?=formatNumberInt($porcentajeActMesAcum);?>%</h3>
                    </div>
                    <p class="card-category"><small>Planificado</small></p>
                    <h3 class="card-title"><?=$planificadoMesAcum;?></h3>

                    <p class="card-category"><small>Ejecutado</small></p>
                    <h3 class="card-title"><?=$ejecutadoMesAcum;?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">local_offer</i> <b><?=$nombreActividad;?> - Acumulado</b>
                    </div>
                  </div>
                </div>
          </div>
          
          </div>

          <?php          
          }
          ?>

          <?php
          if($codOrganismoX==505){
          ?>
          <div class="row">
            <div class="card card-stats">
                  <div class="card-header card-header" data-header-animation="false" style="background:<?=$estiloHome?> !important;">
                      <h4>Certificaciones <?php echo $nombreOrganismoX;?></h4>

        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr class="text-left font-weight-bold">
              <th colspan="4"><small>CERTIFICACION SISTEMAS DE GESTIÓN (TCS)</small></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th class="text-left" colspan="1">Descripcion</th>
              <th class="text-left" colspan="1">Contratos Firmados</th>
              <th class="text-left" colspan="1">Empresas Certificadas</th>
              <th class="text-left" colspan="1">Certificados</th>
            </tr>
            <tr>
              <td class="text-left">Cierre Diciembre 2022</td>
              <td class="text-right">135</td>
              <td class="text-right">128</td>
              <td class="text-right">200</td>
            </tr>
            <tr>
              <td class="text-left">Acumulado Marzo 2023</td>
              <td class="text-right">133</td>
              <td class="text-right">129</td>
              <td class="text-right">202</td>
            </tr>
            <tr>
              <td class="text-left">Nuevas Abril (SG)</td>
              <td class="text-right">2</td>
              <td class="text-right">2</td>
              <td class="text-right">2</td>
            </tr>
            <tr>
              <td class="text-left">Retiradas Abril (SG)</td>
              <td class="text-right">2</td>
              <td class="text-right">2</td>
              <td class="text-right">2</td>
            </tr>
            <tr>
              <td class="text-left">Suspendidas Abril (SG)</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <th class="text-left">Totales</th>
              <th class="text-right">133</th>
              <th class="text-right">129</th>
              <th class="text-right">202</th>
            </tr>
          </tbody>
        </table>

                  </div>
            </div>   
          </div>
          <?php
          }
          ?>

          <?php
          if($codOrganismoX==506){
          ?>
          <div class="row">
            <div class="card card-stats">
                  <div class="card-header card-header" data-header-animation="false" style="background:<?=$estiloHome?> !important;">
                      <h4>Certificaciones <?php echo $nombreOrganismoX;?></h4>

        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr class="text-left font-weight-bold">
              <th colspan="4"><small>CERTIFICACIONES SELLO PRODUCTO Y BPM (TCP)</small></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="1">Descripcion (Producto)</th>
              <th colspan="1">Contratos Firmados</th>
              <th colspan="1">Empresas Certificadas</th>
              <th colspan="1">Certificados</th>
            </tr>
            <tr>
              <td class="text-left">Cierre Diciembre 2022</td>
              <td class="text-right">47</td>
              <td class="text-right">47</td>
              <td class="text-right">231</td>
            </tr>
            <tr>
              <td class="text-left">Acumulado Marzo 2023</td>
              <td class="text-right">46</td>
              <td class="text-right">46</td>
              <td class="text-right">232</td>
            </tr>
            <tr>
              <td class="text-left">Nuevas Abril</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <td class="text-left">Retiradas Abril (SG)</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <td class="text-left">Suspendidas Abril (SG)</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <th class="text-left">Totales</th>
              <th class="text-right">46</th>
              <th class="text-right">46</th>
              <th class="text-right">232</th>
            </tr>

            <tr>
              <th colspan="1">Descripcion (BPM)</th>
              <th colspan="1">Contratos Firmados</th>
              <th colspan="1">Empresas Certificadas</th>
              <th colspan="1">Certificados</th>
            </tr>
            <tr>
              <td class="text-left">Cierre Diciembre 2022</td>
              <td class="text-right">19</td>
              <td class="text-right">17</td>
              <td class="text-right">23</td>
            </tr>
            <tr>
              <td class="text-left">Acumulado Marzo 2023</td>
              <td class="text-right">17</td>
              <td class="text-right">17</td>
              <td class="text-right">23</td>
            </tr>
            <tr>
              <td class="text-left">Nuevas Abril (BPM)</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <td class="text-left">Retiradas Abril (BPM)</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <td class="text-left">Suspendidas Abril (BPM)</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
              <td class="text-right">0</td>
            </tr>
            <tr>
              <th class="text-left">Totales</th>
              <th class="text-right">17</th>
              <th class="text-right">17</th>
              <th class="text-right">23</th>
            </tr>

            <tr>
              <th class="text-left">Totales (Producto & BPM)</th>
              <th class="text-right">63</th>
              <th class="text-right">63</th>
              <th class="text-right">255</th>
            </tr>
          </tbody>
        </table>

                  </div>
            </div>   
          </div>
          <?php
          }
          ?>


          <?php
          if($codOrganismoX==508){
          ?>
          <div class="row">
            <div class="card card-stats">
                  <div class="card-header card-header" data-header-animation="false" style="background:<?=$estiloHome?> !important;">
                      <h4>DETALLE <?php echo $nombreOrganismoX;?></h4>

        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr class="text-left font-weight-bold">
              <th colspan="5"><small>FORMACION CURSOS</small></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center text-danger">Abril</td>
              <td class="text-center text-danger">Planificado</td>
              <td class="text-center text-danger">Ejecutado</td>
              <td class="text-center text-danger">%</td>
            </tr>

            <tr>
              <td class="text-left">Programas Formación</td>
              <td class="text-center">17</td>
              <td class="text-center">16</td>
              <td class="text-center">94 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos Cortos</td>
              <td class="text-center">15</td>
              <td class="text-center">14</td>
              <td class="text-center">93 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos a Medida</td>
              <td class="text-center">5</td>
              <td class="text-center">5</td>
              <td class="text-center">100 %</td>
            </tr>  
            <tr>
              <td class="text-left">Cursos Internacionales</td>
              <td class="text-center">1</td>
              <td class="text-center">1</td>
              <td class="text-center">100 %</td>
            </tr>              
            <tr>
              <td class="text-left">Total Mes</td>
              <td class="text-center">38</td>
              <td class="text-center">36</td>
              <td class="text-center">95 %</td>
            </tr>              

            <tr>
              <td class="text-center text-danger">Acumulado a Abril</td>
              <td class="text-center text-danger">Planificado</td>
              <td class="text-center text-danger">Ejecutado</td>
              <td class="text-center text-danger">%</td>
            </tr>

            <tr>
              <td class="text-left">Programas Formación</td>
              <td class="text-center">68</td>
              <td class="text-center">63</td>
              <td class="text-center">93 %</td>
            </tr>
\            <tr>
              <td class="text-left">Cursos Cortos</td>
              <td class="text-center">57</td>
              <td class="text-center">48</td>
              <td class="text-center">84 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos a Medida</td>
              <td class="text-center">14</td>
              <td class="text-center">13</td>
              <td class="text-center">93 %</td>
            </tr>  
            <tr>
              <td class="text-left">Cursos Internacionales</td>
              <td class="text-center">3</td>
              <td class="text-center">3</td>
              <td class="text-center">100 %</td>
            </tr>                          
            <tr>
              <td class="text-left">Total Acumulado</td>
              <td class="text-center">142</td>
              <td class="text-center">127</td>
              <td class="text-center">89 %</td>
            </tr>                          
          </tbody>
        </table>



        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr class="text-left font-weight-bold">
              <th colspan="5"><small>FORMACION ALUMNOS</small></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center text-danger">Abril</td>
              <td class="text-center text-danger">Planificado</td>
              <td class="text-center text-danger">Ejecutado</td>
              <td class="text-center text-danger">%</td>
            </tr>

            <tr>
              <td class="text-left">Programas Formación</td>
              <td class="text-center">381</td>
              <td class="text-center">389</td>
              <td class="text-center">102 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos Cortos</td>
              <td class="text-center">300</td>
              <td class="text-center">289</td>
              <td class="text-center">96 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos a Medida</td>
              <td class="text-center">125</td>
              <td class="text-center">153</td>
              <td class="text-center">122 %</td>
            </tr>  
            <tr>
              <td class="text-left">Cursos Internacionales</td>
              <td class="text-center">18</td>
              <td class="text-center">12</td>
              <td class="text-center">67 %</td>
            </tr>              
            <tr>
              <td class="text-left">Total Mes</td>
              <td class="text-center">824</td>
              <td class="text-center">843</td>
              <td class="text-center">102 %</td>
            </tr>    

            <tr>
              <td class="text-center text-danger">Acumulado a Abril</td>
              <td class="text-center text-danger">Planificado</td>
              <td class="text-center text-danger">Ejecutado</td>
              <td class="text-center text-danger">%</td>
            </tr>

            <tr>
              <td class="text-left">Programas Formación</td>
              <td class="text-center">1668</td>
              <td class="text-center">1509</td>
              <td class="text-center">90 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos Cortos</td>
              <td class="text-center">1720</td>
              <td class="text-center">2050</td>
              <td class="text-center">119 %</td>
            </tr>
            <tr>
              <td class="text-left">Cursos a Medida</td>
              <td class="text-center">395</td>
              <td class="text-center">339</td>
              <td class="text-center">86 %</td>
            </tr>  
            <tr>
              <td class="text-left">Cursos Internacionales</td>
              <td class="text-center">63</td>
              <td class="text-center">47</td>
              <td class="text-center">75 %</td>
            </tr>              
            <tr>
              <td class="text-left">Total Acumulado</td>
              <td class="text-center">3846</td>
              <td class="text-center">3945</td>
              <td class="text-center">103 %</td>
            </tr>    
            <tr>              
          </tbody>
        </table>
                  </div>
            </div>   
          </div>
          <?php
          }
          ?>

          <!--div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i><small id="actualizado_ingresos<?=$superIndex?>"></small>
            </div>
          </div-->        
      </div>
           <?php 
               $fondoTemporal=$codigosConjunto;
               $nombreFondo=$nombreConjunto;
               $mesTemporal=$mes;
               $anioTemporal=$anio;
               $organismoTemporal=$codOrganismoX;
               $filaTemporal=$superIndex;

               
           ?>
           <div class="col-md-4">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Tendencia de Ingresos
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                      
                    include("../graficos/chartIngresosTendenciaVarios.php");
                    ?>
                  </div>
                </div>
              </div>               
          <?php
          //}
          ?>

    </div>  

    <?php
    $montoIngresosTotalGrupos=$montoEjecutadoGrupo1+$montoEjecutadoGrupo2+$montoEjecutadoGrupo3;
    $participacion1=($montoEjecutadoGrupo1/$montoIngresosTotalGrupos)*100;
    $participacion2=($montoEjecutadoGrupo2/$montoIngresosTotalGrupos)*100;
    $participacion3=($montoEjecutadoGrupo3/$montoIngresosTotalGrupos)*100;
    ?>
        <?php
        $superIndex++;
        }
        ?>


      </div>
    </div>  
  </div>
</div>
