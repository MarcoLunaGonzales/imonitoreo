<?php
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$fondoV=$_GET["fondo"];
$fondo=implode(",", $fondoV);
$fondoArray=str_replace(',', '|', $fondo);
$nameFondo=abrevFondo($fondo);


$organismoV=$_GET["organismo"];
$organismo=implode(",", $organismoV);
$nameOrganismo=abrevOrganismo($organismo);

//echo  $organismo." ".$nameOrganismo;

$gestion=$_GET["gestion"];
$mes=$_GET["mes"];
$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

/*
else if(isset($_POST['detalle']))
{
  echo "HOLA DETALLE";
} */ 

if(isset($_GET['resumen'])){  
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
                  <h4 class="card-title">Seguimiento PO por Cuenta Acumulado</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>
                  <h6 class="card-title">Unidad:<?=$nameFondo;?></h6>
                  <h6 class="card-title">Area:<?=$nameOrganismo;?></h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">CodCuenta1</th>
                          <th class="text-center font-weight-bold">Cuenta</th>
                          <th class="text-center font-weight-bold">Presupuesto</th>
                          <th class="text-center font-weight-bold">Ejecucion</th>
                          <th class="text-center font-weight-bold">%</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php
                        $sql="SELECT pc.codigo, pc.nombre, pc.nivel from po_plancuentas pc where pc.codigo like '4%' and pc.nivel in (3,4,5) order by pc.codigo";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();

                        // bindColumn
                        $stmt->bindColumn('codigo', $codigoCuenta);
                        $stmt->bindColumn('nombre', $nombreCuenta);
                        $stmt->bindColumn('nivel', $nivelCuenta);
                        $totalPresupuestoIngresos=0;
                        $totalEjecutadoIngresos=0;
                        while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          if($nivelCuenta==3){
                            $styleText="text-left font-weight-bold text-danger";
                          }
                          if($nivelCuenta==4){
                            $styleText="text-left font-weight-bold text-primary";
                          }
                          if($nivelCuenta==5){
                            $styleText="text-left font-weight-bold small";
                          }                          
                          $montoPresupuestoCuenta=presupuestoIngresosMes($fondoArray, $anio, $mes, $organismo, 1, $codigoCuenta);
                          $montoEjecucionCuenta=ejecutadoIngresosMes($fondoArray, $anio, $mes, $organismo, 1, $codigoCuenta);
                          $totalPresupuestoIngresos+=$montoPresupuestoCuenta;
                          $totalEjecutadoIngresos+=$montoEjecucionCuenta;
                          $porcentajeEjecucion=0;
                          if($montoPresupuestoCuenta>0){
                            $porcentajeEjecucion=($montoEjecucionCuenta/$montoPresupuestoCuenta)*100;
                          }
                          if($montoPresupuestoCuenta>0 || $montoEjecucionCuenta>0){
                      ?>
                        <tr>
                          <td class="text-right small"><?=$codigoCuenta;?></td>
                          <td><p class="<?=$styleText;?>"><?=$nombreCuenta;?></p></td>
                          <td class="text-right font-weight-bold"><?=number_format($montoPresupuestoCuenta);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($montoEjecucionCuenta);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($porcentajeEjecucion);?></td>
                        </tr>
                        <?php
                          }
                        }
                        $totalPorcentaje=0;
                        if($totalPresupuestoIngresos>0){
                          $totalPorcentaje=($totalEjecutadoIngresos/$totalPresupuestoIngresos)*100;
                        }
                        ?>
                        <tr>
                          <td class="text-right small">-</td>
                          <td><p class="text-left font-weight-bold text-danger">TOTAL INGRESOS</p></td>
                          <td class="text-right font-weight-bold"><?=number_format($totalPresupuestoIngresos);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($totalEjecutadoIngresos);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($totalPorcentaje);?></td>
                        </tr>
                        <!--DESDE ACA SON LOS EGRESOS-->
                        <?php
                        $sql="SELECT pc.codigo, pc.nombre, pc.nivel from po_plancuentas pc where pc.codigo like '5%' and pc.nivel in (3,4,5) order by pc.codigo";
                        //echo $sql;
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute();

                        // bindColumn
                        $stmt->bindColumn('codigo', $codigoCuenta);
                        $stmt->bindColumn('nombre', $nombreCuenta);
                        $stmt->bindColumn('nivel', $nivelCuenta);
                        $totalPresupuestoEgresos=0;
                        $totalEjecutadoEgresos=0;
                        while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          if($nivelCuenta==3){
                            $styleText="text-left font-weight-bold text-danger";
                          }
                          if($nivelCuenta==4){
                            $styleText="text-left font-weight-bold text-primary";
                          }
                          if($nivelCuenta==5){
                            $styleText="text-left font-weight-bold small";
                          }                          
                          $montoPresupuestoCuenta=presupuestoEgresosMes($fondoArray, $anio, $mes, $organismo, 1, $codigoCuenta);
                          $montoEjecucionCuenta=ejecutadoEgresosMes($fondoArray, $anio, $mes, $organismo, 1, $codigoCuenta);
                          $totalPresupuestoEgresos+=$montoPresupuestoCuenta;
                          $totalEjecutadoEgresos+=$montoEjecucionCuenta;

                          $porcentajeEjecucion=0;
                          if($montoPresupuestoCuenta>0){
                            $porcentajeEjecucion=($montoEjecucionCuenta/$montoPresupuestoCuenta)*100;
                          }                          
                          if($montoPresupuestoCuenta>0 || $montoEjecucionCuenta>0){
                      ?>
                        <tr>
                          <td class="text-right small"><?=$codigoCuenta;?></td>
                          <td><p class="<?=$styleText;?>"><?=$nombreCuenta;?></p></td>
                          <td class="text-right font-weight-bold"><?=number_format($montoPresupuestoCuenta);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($montoEjecucionCuenta);?></td>                          
                          <td class="text-right font-weight-bold"><?=number_format($porcentajeEjecucion);?></td>

                        </tr>
                        <?php
                          }
                        }
                        $totalPorcentaje=0;
                        if($totalPresupuestoEgresos>0){
                          $totalPorcentaje=($totalEjecutadoEgresos/$totalPresupuestoEgresos)*100;
                        }
                        ?>
                        <tr>
                          <td class="text-right small">-</td>
                          <td><p class="text-left font-weight-bold text-danger">TOTAL EGRESOS</p></td>
                          <td class="text-right font-weight-bold"><?=number_format($totalPresupuestoEgresos);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($totalEjecutadoEgresos);?></td>
                          <td class="text-right font-weight-bold"><?=number_format($totalPorcentaje);?></td>
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

<?php
}
?>