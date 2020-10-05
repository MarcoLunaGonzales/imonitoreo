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
      <div class="col-md-4">
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
                  <th class="text-center font-weight-bold">Part.</th>
                </tr>
              </thead>
              <tbody>
              <?php
                //SACAMOSM EL DETALLE CONJUNTO
                $montoPresIngConjunto=presupuestoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $montoEjIngConjunto=ejecutadoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);


                $porcentajeIngConjunto=0;
                if($montoPresIngConjunto>0){
                  $porcentajeIngConjunto=($montoEjIngConjunto/$montoPresIngConjunto)*100;
                }

                //SACAMOS LOS MONTOS PARA LA PARTICIPACION DE LOS INGRESOS TABLA FINAL
                  $montoEjecutadoGrupo3=$montoEjIngConjunto;
                  $nombreGrupo3=$nombreConjunto;
                

                $colorPorcentajeIngreso=colorPorcentajeIngreso($porcentajeIngConjunto);

                $valorIngresoFormat=number_format(calcularValorEnPoncentaje($montoEjIngConjunto,$montoPresIngConjunto),0,'.','');
                ?>
                <tr>
                  <td class="text-left font-weight-bold">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">Ingresos
                    </a>
                  </td>
                  <td class="text-right  font-weight-bold table-warning"><?=formatNumberInt($montoPresIngConjunto);?>
                  </td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoEjIngConjunto);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($porcentajeIngConjunto);?></td>
                  <td class="text-right  font-weight-bold table-warning"><?=formatNumberInt(100);?></td>
                </tr>
                <?php
                
                //SACAMOSM EL DETALLE CONJUNTO EGRESOS
                $montoPresEgConjunto=presupuestoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $montoEjEgConjunto=ejecutadoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);

                /*******************   BORRAR DESPUES *****************/
                //echo $codOrganismoX." ";
                $montoExtra=15000;
                if($codOrganismoX==505){
                  $montoEjEgConjunto=$montoEjEgConjunto+$montoExtra;
                }
                if($codOrganismoX==510){
                  $montoEjEgConjunto=$montoEjEgConjunto-$montoExtra;
                }
                /*******************   BORRAR DESPUES *****************/


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
                  <td class="text-right  font-weight-bold table-info"><?=formatNumberInt(100);?></td>
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
                  <td class="text-right font-weight-bold">-</td>
                 </tr>
                 <?php
                 //ACA SACAMOS LOS DATOS PARA LOS ACUMULADOS
                  $montoPresIngAcumulado=presupuestoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $montoEjIngAcumulado=ejecutadoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);

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
                  <td class="text-right font-weight-bold  table-warning">-</td>


                  <?php
                 //ACA SACAMOS LOS DATOS PARA LOS ACUMULADOS
                  $montoPresEgAcumulado=presupuestoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $montoEjEgAcumulado=ejecutadoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);

                  $montoExtra=15000;
                  if($codOrganismoX==505){
                    $montoEjEgAcumulado=$montoEjEgAcumulado+$montoExtra;
                  }
                  if($codOrganismoX==510){
                    $montoEjEgAcumulado=$montoEjEgAcumulado-$montoExtra;
                  }


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
                  <td class="text-right font-weight-bold table-info">-</td>
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
                  <td class="text-right font-weight-bold">-</td>
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
                          <div class="col-md-4 div-center">
                            <div class="card card-chart text-center">
                              <div class="card-header card-header-rose" data-header-animation="false" style="background:<?=$estiloHome?> !important;">
                                 <h4>INGRESOS Y EGRESOS</h4>
                              </div>
                              <div class="card-body">
                                <div class="card-actions">  
                                </div>
                                <center>
                                  <h4 class="card-title">INGRESOS</h4>
                                  <div id="ingreso_general_chart<?=$superIndex?>" class="div-center"></div>
                                  <h4 class="card-title">EGRESOS</h4>
                                  <div id="ingreso_general_chart_eg<?=$superIndex?>" class="div-center"></div>
                                </center>                                
                                
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                  <i class="material-icons">access_time</i><small id="actualizado_ingresos<?=$superIndex?>"></small>
                                </div>
                              </div>
                            </div>
                          </div>
           <?php 
               $fondoTemporal=$codigosConjunto;
               $nombreFondo=$nombreConjunto;
               $mesTemporal=$mes;
               $anioTemporal=$anio;
               $organismoTemporal=$codOrganismoX;
               $filaTemporal=$superIndex;

               /*$_SESSION["fondoTemporal"]=$fondoTemporal;
               $_SESSION["nombreFondoTemporal"]=$nombreFondo;
               $_SESSION["mesTemporal"]=$mesTemporal;
               $_SESSION["anioTemporal"]=$anioTemporal;
               $_SESSION["organismoTemporal"]=$organismoTemporal;
               $_SESSION["filaTemporal"]=$superIndex;*/
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
    <!--div class="row">
    <table width="80%">
      <tr>
        <th class="text-center font-weight-bold table-success">
          Total Ingresos <?=$nombreOrganismoX;?>
        </th>        
        <th class="text-center font-weight-bold table-success">
          <?=$nombreGrupo3;?>
        </th>
      </tr>
      <tr>
        <td class="text-center font-weight-bold table-success">
          <?=formatNumberInt($montoIngresosTotalGrupos);?>
        </td>        
        <td class="text-center font-weight-bold table-success">
          <?=formatNumberInt($participacion3);?> %
        </td>
      </tr>
    </table>
    </div-->

    </br></br></br> 
    <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Mes', <?=$valorIngresoFormat?>],
          ['Acumulado', <?=$valorIngresoFormatAcumulado?>]
        ]);
        var dataEg = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Mes', <?=$valorEgresoFormat?>],
          ['Acumulado', <?=$valorEgresoFormatAcumulado?>]
        ]);
        var options = {
          width: 270, height: 270,
          redFrom: 0, redTo: 80,
          yellowFrom:80, yellowTo: 95,
          greenFrom:95, greenTo: 100,
          minorTicks: 5
        };
        var options1 = {
          width: 270, height: 270,
          greenFrom: 0, greenTo: 80,
          yellowFrom:80, yellowTo: 95,
          redFrom:95, redTo: 100,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('ingreso_general_chart<?=$superIndex?>'));
        chart.draw(data, options);
        var chartEg = new google.visualization.Gauge(document.getElementById('ingreso_general_chart_eg<?=$superIndex?>'));
        chartEg.draw(dataEg, options1);
          $('#actualizado_ingresos<?=$superIndex?>').html(obtenerHoraFechaActualFormato());
      }
    </script>
        <?php
        $superIndex++;
        }
        ?>


      </div>
    </div>  
  </div>
</div>
