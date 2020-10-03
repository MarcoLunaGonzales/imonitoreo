<?php
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

session_start();

$fondoV=$_POST["fondo"];
$fondo=implode(",", $fondoV);

$fondoArray=str_replace(',', '|', $fondo);
$nombreFondo=abrevFondo($fondo);

$gestion=$_POST["gestion"];
$mes=$_POST["mes"];
$anio=nameGestion($gestion);

$anioAnt=$anio-1;

$dbh = new Conexion();
$moduleName="Seguimiento al Presupuesto Operativo - $mes $anio";

//DEFINIMOS VARIABLES DE SESION
//echo $fondoArray."fondoArray";
$_SESSION['fondoTemporal']=$fondoArray;
$_SESSION['anioTemporal']=$anio;
$_SESSION['mesTemporal']=$mes;


//require("chartNacional.php");
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
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">-</th>
                          <th class="text-center font-weight-bold">Tipo</th>
                          <th class="text-center font-weight-bold">Pres <?=$anio;?></th>
                          <th class="text-center font-weight-bold">Eje <?=$anio;?></th>
                          <th class="text-center font-weight-bold">%</th>
                          <th class="text-center font-weight-bold">Pres <?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold">Eje <?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold">%</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>Diferencia</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>%</th>
                          <th rowspan="4" class="text-middle">
                            <a href="seguimientoPOPorServicio.php?fondo=<?=$fondoArray?>&anio=<?=$anio;?>&mes=<?=$mes;?>" rel="tooltip" class="<?=$buttonDetail;?>" title="Ver Detalle Por Servicio" target="_blank"> 
                              <i class="material-icons">trending_up</i>
                            </a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          //INGRESOS
                          $montoPresIngresoAnt=presupuestoIngresosMes($fondoArray,$anioAnt,$mes,0,0,0);
                          $montoPresIngreso=presupuestoIngresosMes($fondoArray,$anio,$mes,0,0,0);

                          $montoEjIngresoAnt=ejecutadoIngresosMes($fondoArray,$anioAnt,$mes,0,0,0);
                          $montoEjIngreso=ejecutadoIngresosMes($fondoArray,$anio,$mes,0,0,0);

                          //$porcIngresoAnt=(($montoEjIngresoAnt-$montoPresIngresoAnt)/$montoPresIngresoAnt)*100;
                          $porcIngresoAnt=($montoEjIngresoAnt/$montoPresIngresoAnt)*100;
                          //$porcIngreso=(($montoEjIngreso-$montoPresIngreso)/$montoPresIngreso)*100;
                          $porcIngreso=($montoEjIngreso/$montoPresIngreso)*100;
                        
                          $colorPorcIngAnt=colorPorcentajeIngreso($porcIngresoAnt);
                          $colorPorcIng=colorPorcentajeIngreso($porcIngreso);


                          //EGRESOS
                          $montoPresEgresoAnt=presupuestoEgresosMes($fondoArray,$anioAnt,$mes,0,0,0);
                          $montoPresEgreso=presupuestoEgresosMes($fondoArray,$anio,$mes,0,0,0);
                          
                          $montoEjEgresoAnt=ejecutadoEgresosMes($fondoArray,$anioAnt,$mes,0,0,0);
                          $montoEjEgreso=ejecutadoEgresosMes($fondoArray,$anio,$mes,0,0,0);

                          //$porcEgresoAnt=(($montoEjEgresoAnt-$montoPresEgresoAnt)/$montoPresEgresoAnt)*100;
                          $porcEgresoAnt=($montoEjEgresoAnt/$montoPresEgresoAnt)*100;
                          //$porcEgreso=(($montoEjEgreso-$montoPresEgreso)/$montoPresEgresoAnt)*100;
                          $porcEgreso=($montoEjEgreso/$montoPresEgreso)*100;
                          
                          $colorPorcEgAnt=colorPorcentajeEgreso($porcEgresoAnt);
                          $colorPorcEg=colorPorcentajeEgreso($porcEgreso);

                          //RESULTADOS
                          $resultadoPresAnt=$montoPresIngresoAnt-$montoPresEgresoAnt;
                          $resultadoEjAnt=$montoEjIngresoAnt-$montoEjEgresoAnt;

                          $resultadoPres=$montoPresIngreso-$montoPresEgreso;
                          $resultadoEj=$montoEjIngreso-$montoEjEgreso;

                          $porcResultadoAnt=(($resultadoEjAnt-$resultadoPresAnt)/$resultadoPresAnt)*100;
                          $porcResultado=(($resultadoEj-$resultadoPres)/$resultadoPres)*100;

                          $diferenciaAniosIngresos=$montoEjIngreso-$montoEjIngresoAnt;
                          $porcentajeAniosIngresos=($montoEjIngreso/$montoEjIngresoAnt)*100;

                          $diferenciaAniosEgresos=$montoEjEgreso-$montoEjEgresoAnt;
                          $porcentajeAniosEgresos=($montoEjEgreso/$montoEjEgresoAnt)*100;

                          $diferenciaAniosResult=$resultadoEj-$resultadoEjAnt;
                          $porcentajeAniosResult=($resultadoEj/$resultadoEjAnt)*100;

                      ?>
                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreFondo;?></td>
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

                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreFondo;?></td>
                          <td class="text-left">Egresos</td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgreso);?></td>
                          <td class="text-right <?=$colorPorcEg;?>"><?=formatNumberInt($porcEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgresoAnt);?></td>
                          <td class="text-right <?=$colorPorcEgAnt;?>"><?=formatNumberInt($porcEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosEgresos);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosEgresos);?></td>
                        </tr>

                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreFondo;?></td>
                          <td class="text-left">Resultado</td>
                          <td class="text-right"><?=formatNumberInt($resultadoPres);?></td>
                          <td class="text-right"><?=formatNumberInt($resultadoEj);?></td>
                          <!--td class="text-right"><?=formatNumberInt($porcResultado);?></td-->
                          <td class="text-right">-</td>
                          <td class="text-right"><?=formatNumberInt($resultadoPresAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($resultadoEjAnt);?></td>
                          <!--td class="text-right"><?=formatNumberInt($porcResultadoAnt);?></td-->
                          <td class="text-right">-</td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosResult);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosResult);?></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>  
        </div>







        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header <?=$colorCard;?> card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title"><?=$moduleName?> Acumulado</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">-</th>
                          <th class="text-left font-weight-bold">Tipo</th>
                          <th class="text-center font-weight-bold">Pres <?=$anio;?></th>
                          <th class="text-center font-weight-bold">Eje <?=$anio;?></th>
                          <th class="text-center font-weight-bold">%</th>
                          <th class="text-center font-weight-bold">Pres <?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold">Eje <?=$anioAnt;?></th>
                          <th class="text-center font-weight-bold">%</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>Diferencia</th>
                          <th class="text-center font-weight-bold"><?=$anio;?>/<?=$anioAnt?><br>%</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          //INGRESOS
                          $montoPresIngresoAnt=presupuestoIngresosMes($fondoArray,$anioAnt,$mes,0,1,0);
                          $montoPresIngreso=presupuestoIngresosMes($fondoArray,$anio,$mes,0,1,0);

                          $montoEjIngresoAnt=ejecutadoIngresosMes($fondoArray,$anioAnt,$mes,0,1,0);
                          $montoEjIngreso=ejecutadoIngresosMes($fondoArray,$anio,$mes,0,1,0);

                          //$porcIngresoAnt=(($montoEjIngresoAnt-$montoPresIngresoAnt)/$montoPresIngresoAnt)*100;
                          $porcIngresoAnt=($montoEjIngresoAnt/$montoPresIngresoAnt)*100;
                          //$porcIngreso=(($montoEjIngreso-$montoPresIngreso)/$montoPresIngreso)*100;
                          $porcIngreso=($montoEjIngreso/$montoPresIngreso)*100;

                          $colorPorcIngAnt=colorPorcentajeIngreso($porcIngresoAnt);
                          $colorPorcIng=colorPorcentajeIngreso($porcIngreso);

                          //EGRESOS
                          $montoPresEgresoAnt=presupuestoEgresosMes($fondoArray,$anioAnt,$mes,0,1,0);
                          $montoPresEgreso=presupuestoEgresosMes($fondoArray,$anio,$mes,0,1,0);
                          
                          $montoEjEgresoAnt=ejecutadoEgresosMes($fondoArray,$anioAnt,$mes,0,1,0);
                          $montoEjEgreso=ejecutadoEgresosMes($fondoArray,$anio,$mes,0,1,0);

                          //$porcEgresoAnt=(($montoEjEgresoAnt-$montoPresEgresoAnt)/$montoPresEgresoAnt)*100;
                          $porcEgresoAnt=($montoEjEgresoAnt/$montoPresEgresoAnt)*100;
                          //$porcEgreso=(($montoEjEgreso-$montoPresEgreso)/$montoPresEgresoAnt)*100;
                          $porcEgreso=($montoEjEgreso/$montoPresEgreso)*100;
                          
                          $colorPorcEgAnt=colorPorcentajeEgreso($porcEgresoAnt);
                          $colorPorcEg=colorPorcentajeEgreso($porcEgreso);

                          //RESULTADOS
                          $resultadoPresAnt=$montoPresIngresoAnt-$montoPresEgresoAnt;
                          $resultadoEjAnt=$montoEjIngresoAnt-$montoEjEgresoAnt;

                          $resultadoPres=$montoPresIngreso-$montoPresEgreso;
                          $resultadoEj=$montoEjIngreso-$montoEjEgreso;

                          $porcResultadoAnt=(($resultadoEjAnt-$resultadoPresAnt)/$resultadoPresAnt)*100;
                          $porcResultado=(($resultadoEj-$resultadoPres)/$resultadoPres)*100;

                          $diferenciaAniosIngresos=$montoEjIngreso-$montoEjIngresoAnt;
                          $porcentajeAniosIngresos=($montoEjIngreso/$montoEjIngresoAnt)*100;

                          $diferenciaAniosEgresos=$montoEjEgreso-$montoEjEgresoAnt;
                          $porcentajeAniosEgresos=($montoEjEgreso/$montoEjEgresoAnt)*100;

                          $diferenciaAniosResult=$resultadoEj-$resultadoEjAnt;
                          $porcentajeAniosResult=($resultadoEj/$resultadoEjAnt)*100;


                      ?>
                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreFondo;?></td>
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

                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreFondo;?></td>
                          <td class="text-left">Egresos</td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgreso);?></td>
                          <td class="text-right <?=$colorPorcEg;?>"><?=formatNumberInt($porcEgreso);?></td>
                          <td class="text-right"><?=formatNumberInt($montoPresEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($montoEjEgresoAnt);?></td>
                          <td class="text-right <?=$colorPorcEgAnt;?>"><?=formatNumberInt($porcEgresoAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosEgresos);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosEgresos);?></td>
                        </tr>

                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreFondo;?></td>
                          <td class="text-left">Resultado</td>
                          <td class="text-right"><?=formatNumberInt($resultadoPres);?></td>
                          <td class="text-right"><?=formatNumberInt($resultadoEj);?></td>
                          <!--td class="text-right"><?=formatNumberInt($porcResultado);?></td-->
                          <td class="text-right">-</td>
                          <td class="text-right"><?=formatNumberInt($resultadoPresAnt);?></td>
                          <td class="text-right"><?=formatNumberInt($resultadoEjAnt);?></td>
                          <!--td class="text-right"><?=formatNumberInt($porcResultadoAnt);?></td-->
                          <td class="text-right">-</td>
                          <td class="text-right"><?=formatNumberInt($diferenciaAniosResult);?></td>
                          <td class="text-right"><?=formatNumberInt($porcentajeAniosResult);?></td>
                        </tr>


                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div> 

          <script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/chartjs-plugin-labels.js"></script>
<script>
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
var coloresRandom = []; 
for (var i = 1; i <=6; i++) { //cantidad de organizaciones
     coloresRandom.push(getRandomColor());   
};
var filaChart=0;
</script>
<?php
$_SESSION["nombreFondoTemporal"]="";
$_SESSION["organismoTemporal"]="503,505,506,507,508,510";
$_SESSION["organismoTemporalAgrupado"]="503,505,506,507";
$_SESSION["nombreTemporalAgrupado"]="EC";
?>
<div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">pie_chart</i>
                    </div>
                    <h4 class="card-title">PARTICIPACION INGRESOS
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    $_SESSION["filaTemporal"]=1;
                    $_SESSION["acumuladoTemporal"]=0;  
                    include ("../graficos/chartIngresosParticipacion.php");
                    ?>
                  </div>
                </div>
              </div> 
             <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">pie_chart</i>
                    </div>
                    <h4 class="card-title">PARTICIPACION INGRESOS
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    $_SESSION["filaTemporal"]=2;
                    $_SESSION["acumuladoTemporal"]=1;    
                    include ("../graficos/chartIngresosParticipacion.php");
                    ?>
                  </div>
                </div>
              </div> 
</div> 
        </div>
    </div>

