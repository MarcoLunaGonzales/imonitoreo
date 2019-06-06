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
                  <h4 class="card-title">Seguimiento PO por Cuenta Resumen</h4>
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
                          <th class="text-center font-weight-bold">Cumplimiento %</th>
                          <th class="text-center font-weight-bold">Participacion %</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php
                        $montoTotalEjecucionIng=ejecutadoIngresosMes($fondoArray, $anio, $mes, $organismo, 0, 0);
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
                          $montoPresupuestoCuenta=presupuestoIngresosMes($fondoArray, $anio, $mes, $organismo, 0, $codigoCuenta);
                          $montoEjecucionCuenta=ejecutadoIngresosMes($fondoArray, $anio, $mes, $organismo, 0, $codigoCuenta);
                          $totalPresupuestoIngresos+=$montoPresupuestoCuenta;
                          $totalEjecutadoIngresos+=$montoEjecucionCuenta;
                          $porcentajeEjecucion=0;
                          $participacionEjecucion=0;
                          if($montoTotalEjecucionIng>0){
                            $participacionEjecucion=($montoEjecucionCuenta/$montoTotalEjecucionIng)*100;
                          }

                          if($montoPresupuestoCuenta>0){
                            $porcentajeEjecucion=($montoEjecucionCuenta/$montoPresupuestoCuenta)*100;
                          }
                          if($montoPresupuestoCuenta>0 || $montoEjecucionCuenta>0){
                            
                      ?>
                        <tr>
                          <td class="text-right small"><?=$codigoCuenta;?></td>
                          <td><p class="<?=$styleText;?>"><?=$nombreCuenta;?></p></td>
                          <td class="text-right"><?=number_format($montoPresupuestoCuenta);?></td>
                          <td class="text-right"><?=number_format($montoEjecucionCuenta);?></td>
                          <td class="text-right"><?=number_format($porcentajeEjecucion);?>%</td>     
                          <td class="text-right"><?=number_format($participacionEjecucion);?>%</td>
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
                          <td class="text-right font-weight-bold"><?=number_format($totalPorcentaje);?>%</td>
                          <td class="text-right font-weight-bold">100%</td>
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
                        $montoTotalEjecucionEg=ejecutadoEgresosMes($fondoArray,$anio,$mes,$organismo,0,0);
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
                          $montoPresupuestoCuenta=presupuestoEgresosMes($fondoArray, $anio, $mes, $organismo, 0, $codigoCuenta);
                          $montoEjecucionCuenta=ejecutadoEgresosMes($fondoArray, $anio, $mes, $organismo, 0, $codigoCuenta);
                          $totalPresupuestoEgresos+=$montoPresupuestoCuenta;
                          $totalEjecutadoEgresos+=$montoEjecucionCuenta;

                          $participacionEjecucion=0;
                          if($montoTotalEjecucionEg>0){
                            $participacionEjecucion=($montoEjecucionCuenta/$montoTotalEjecucionEg)*100;
                          }
                          $porcentajeEjecucion=0;
                          if($montoPresupuestoCuenta>0){
                            $porcentajeEjecucion=($montoEjecucionCuenta/$montoPresupuestoCuenta)*100;
                          }                          
                          if($montoPresupuestoCuenta>0 || $montoEjecucionCuenta>0){
                      ?>
                        <tr>
                          <td class="text-right small"><?=$codigoCuenta;?></td>
                          <td><p class="<?=$styleText;?>"><?=$nombreCuenta;?></p></td>
                          <td class="text-right"><?=number_format($montoPresupuestoCuenta);?></td>
                          <td class="text-right"><?=number_format($montoEjecucionCuenta);?></td>     
                          <td class="text-right"><?=number_format($porcentajeEjecucion);?>%</td>
                          <td class="text-right"><?=number_format($participacionEjecucion);?>%</td>

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
                          <td class="text-right font-weight-bold"><?=number_format($totalPorcentaje);?>%</td>
                          <td class="text-right font-weight-bold">100%</td>
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
}else if(isset($_GET['detalle'])){
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
            <h4 class="card-title">Seguimiento PO por Cuenta Detallado</h4>
            <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold">Area</th>
                    <th class="text-center font-weight-bold">CodCuenta1</th>
                    <th class="text-center font-weight-bold">Cuenta</th>
                    <th class="text-center font-weight-bold">Presupuesto</th>
                    <th class="text-center font-weight-bold">Ejecucion</th>
                  </tr>
                </thead>
                <tbody>
          <?php
        //desde aqui sacamos las areas y unidades
        $sqlFondos="SELECT codigo, nombre from po_fondos where codigo in ($fondo)";
        $stmtFondo=$dbh->prepare($sqlFondos);
        $stmtFondo->execute();
        $stmtFondo->bindColumn('codigo', $codFondoX);
        $stmtFondo->bindColumn('nombre', $nombreFondoX);
        while($rowFondo = $stmtFondo->fetch(PDO::FETCH_BOUND)){          

          $abrevFondoX=abrevFondo($codFondoX);

          $sqlOrg="SELECT codigo, nombre from po_organismos where codigo in ($organismo)";
          $stmtOrg = $dbh->prepare($sqlOrg);
          $stmtOrg->execute();

          $stmtOrg->bindColumn('codigo', $codOrganismoX);
          $stmtOrg->bindColumn('nombre', $nombreOrganismoX);
          while ($rowOrg = $stmtOrg->fetch(PDO::FETCH_BOUND)) {
          ?>

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
                    $montoPresupuestoCuenta=presupuestoIngresosMes($codFondoX, $anio, $mes, $codOrganismoX, 0, $codigoCuenta);
                    $montoEjecucionCuenta=ejecutadoIngresosMes($codFondoX, $anio, $mes, $codOrganismoX, 0, $codigoCuenta);
                    $totalPresupuestoIngresos+=$montoPresupuestoCuenta;
                    $totalEjecutadoIngresos+=$montoEjecucionCuenta;
                    if($montoPresupuestoCuenta>0 || $montoEjecucionCuenta>0){
                ?>
                  <tr>
                    <td class="text-right small"><?=$abrevFondoX;?></td>
                    <td class="text-right small"><?=$nombreOrganismoX;?></td>
                    <td class="text-right small"><?=$codigoCuenta;?></td>
                    <td><p class="<?=$styleText;?>"><?=$nombreCuenta;?></p></td>
                    <td class="text-right font-weight-bold"><?=number_format($montoPresupuestoCuenta);?></td>
                    <td class="text-right font-weight-bold"><?=number_format($montoEjecucionCuenta);?></td>
                  </tr>
                  <?php
                    }
                  }
                  ?>
                  <tr>
                    <td class="text-right small">-</td>
                    <td><p class="text-left font-weight-bold text-danger">TOTAL INGRESOS <?=$abrevFondoX;?> <?=$nombreOrganismoX;?></p></td>
                    <td class="text-right small">-</td>
                    <td class="text-right small">-</td>
                    <td class="text-right font-weight-bold"><?=number_format($totalPresupuestoIngresos);?></td>
                    <td class="text-right font-weight-bold"><?=number_format($totalEjecutadoIngresos);?></td>
                  </tr>
                  <!--DESDE ACA SON LOS EGRESOS-->
                  <?php
                  $sql="SELECT pc.codigo, pc.nombre, pc.nivel from po_plancuentas pc where pc.codigo like '5%' and pc.nivel in (3,4,5) order by pc.codigo";
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
                    $montoPresupuestoCuenta=presupuestoEgresosMes($codFondoX, $anio, $mes, $codOrganismoX, 0, $codigoCuenta);
                    $montoEjecucionCuenta=ejecutadoEgresosMes($codFondoX, $anio, $mes, $codOrganismoX, 0, $codigoCuenta);
                    $totalPresupuestoEgresos+=$montoPresupuestoCuenta;
                    $totalEjecutadoEgresos+=$montoEjecucionCuenta;
                    if($montoPresupuestoCuenta>0 || $montoEjecucionCuenta>0){
                ?>
                  <tr>
                    <td class="text-right small"><?=$abrevFondoX;?></td>
                    <td class="text-right small"><?=$nombreOrganismoX;?></td>
                    <td class="text-right small"><?=$codigoCuenta;?></td>
                    <td><p class="<?=$styleText;?>"><?=$nombreCuenta;?></p></td>
                    <td class="text-right font-weight-bold"><?=number_format($montoPresupuestoCuenta);?></td>
                    <td class="text-right font-weight-bold"><?=number_format($montoEjecucionCuenta);?></td>
                  </tr>
                  <?php
                    }
                  }
                  ?>
                  <tr>
                    <td class="text-right small">-</td>
                    <td><p class="text-left font-weight-bold text-danger">TOTAL EGRESOS <?=$abrevFondoX;?> <?=$nombreOrganismoX;?></p></td>
                    <td class="text-right small">-</td>
                    <td class="text-right small">-</td>
                    <td class="text-right font-weight-bold"><?=number_format($totalPresupuestoEgresos);?></td>
                    <td class="text-right font-weight-bold"><?=number_format($totalEjecutadoEgresos);?></td>
                  </tr>                        
          <?php
          }
        }
          ?>
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
