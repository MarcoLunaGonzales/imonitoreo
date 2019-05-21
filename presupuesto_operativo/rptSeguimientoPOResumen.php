<?php
error_reporting(E_ALL);
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

$gestion=$_POST["gestion"];
$anio=nameGestion($gestion);
$mes=$_POST["mes"];

$fondoV=$_POST["fondo"];
$fondo=implode(",", $fondoV);
$fondoArray=str_replace(',', '|', $fondo);
$nameFondo=abrevFondo($fondo);

$cadenaOrganismos=0;
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}

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


$sql="SELECT pf.codigo, pf.nombre from po_fondos pf where pf.codigo in ($fondo)";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$stmt->bindColumn('codigo', $codFondo);
$stmt->bindColumn('nombre', $nombreFondo);
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
                  <h4 class="card-title">Reporte Seguimiento Presupuesto Operativo Resumen</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?></h6>
                  <h6 class="card-title">Mes: <?=$mes;?></h6>


                </div>
                <div class="card-body">
                  <?php
                  while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                    $totalPresIng=0;
                    $totalEjIng=0;
                    $totalPresIngAcum=0;
                    $totalEjIngAcum=0;

                    $totalPresEg=0;
                    $totalEjEg=0;
                    $totalEjEgIT=0;
                    $totalEjEgDN=0;
                    $totalEjEgSA=0;
                    $totalEjEgMenosOtros=0;
                    $totalPresEgAcum=0;
                    $totalEjEgAcum=0;

                  ?>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th colspan="15" class="text-center font-weight-bold"><?=$nombreFondo;?></th>
                        </tr>
                        <tr>
                          <th class="text-center font-weight-bold">Area</th>
                          <th class="text-center font-weight-bold">Pres.Ing.</th>
                          <th class="text-center font-weight-bold">Ej.Ing.</th>
                          <th class="text-center font-weight-bold">Pres.Ing.Acum.</th>
                          <th class="text-center font-weight-bold">Ej.Ing.Acum.</th>
                          <th class="text-center font-weight-bold">Pres.Eg.</th>
                          <th class="text-center font-weight-bold">Ej.Eg.Op.</th>
                          <th class="text-center font-weight-bold">Ej.Eg.IT</th>
                          <th class="text-center font-weight-bold">Ej.Eg.DN</th>
                          <th class="text-center font-weight-bold">Ej.Eg.SA</th>
                          <th class="text-center font-weight-bold">TotalEj.Eg.</th>
                          <th class="text-center font-weight-bold">Pres.Eg.Acum.</th>
                          <th class="text-center font-weight-bold">Ej.Eg.Acum</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $sqlOrganismo="SELECT distinct(o.codigo), o.nombre from po_organismos o where o.codigo in ($cadenaOrganismos) order by 2";
                        $stmtOrg = $dbh->prepare($sqlOrganismo);
                        $stmtOrg->execute();
                        $stmtOrg->bindColumn('codigo', $codOrganismo);
                        $stmtOrg->bindColumn('nombre', $nombreOrganismo);
                        while($rowOrg = $stmtOrg->fetch(PDO::FETCH_BOUND)){
                          //echo $nombre."<br>";
                          $montoPresIng=presupuestoIngresosMes($codFondo,$anio,$mes,$codOrganismo,0,0);
                          $montoEjIng=ejecutadoIngresosMes($codFondo,$anio,$mes,$codOrganismo,0,0);
                          $montoPresIngAcum=presupuestoIngresosMes($codFondo,$anio,$mes,$codOrganismo,1,0);
                          $montoEjIngAcum=ejecutadoIngresosMes($codFondo,$anio,$mes,$codOrganismo,1,0);

                          $montoPresEg=presupuestoEgresosMes($codFondo,$anio,$mes,$codOrganismo,0,0);
                          $montoEjEg=ejecutadoEgresosMes($codFondo,$anio,$mes,$codOrganismo,0,0);

                          $montoEjEgIT=ejecutadoEgresosMes($codFondo,$anio,$mes,$codOrganismo,0,$cuentaIT);
                          $montoEjEgDN=ejecutadoEgresosMes($codFondo,$anio,$mes,$codOrganismo,0,$cuentaDN);
                          $montoEjEgSA=ejecutadoEgresosMes($codFondo,$anio,$mes,$codOrganismo,0,$cuentaSA);

                          $montoEjEgMenosOtros=$montoEjEg-$montoEjEgIT-$montoEjEgDN-$montoEjEgSA;

                          $montoPresEgAcum=presupuestoEgresosMes($codFondo,$anio,$mes,$codOrganismo,1,0);
                          $montoEjEgAcum=ejecutadoEgresosMes($codFondo,$anio,$mes,$codOrganismo,1,0);
                          
                          $totalPresIng+=$montoPresIng;
                          $totalEjIng+=$montoEjIng;
                          $totalPresIngAcum+=$montoPresIngAcum;
                          $totalEjIngAcum+=$montoEjIngAcum;

                          $totalPresEg+=$montoPresEg;
                          $totalEjEg+=$montoEjEg;
                          $totalEjEgIT+=$montoEjEgIT;
                          $totalEjEgSA+=$montoEjEgSA;
                          $totalEjEgDN+=$montoEjEgDN;
                          $totalEjEgMenosOtros+=$montoEjEgMenosOtros;
                          $totalPresEgAcum+=$montoPresEgAcum;
                          $totalEjEgAcum+=$montoEjEgAcum;

                      ?>
                        <tr>
                          <td class="text-left font-weight-bold"><?=$nombreOrganismo;?></td>
                      <?php
                      ?>
                          <td class="text-right table-warning"><?=formatNumberInt($montoPresIng);?></td>
                          <td class="text-right table-warning"><?=formatNumberInt($montoEjIng);?></td>
                          <td class="text-right bg-warning"><?=formatNumberInt($montoPresIngAcum);?></td>
                          <td class="text-right bg-warning"><?=formatNumberInt($montoEjIngAcum);?></td>

                          <td class="text-right table-primary"><?=formatNumberInt($montoPresEg);?></td>
                          <td class="text-right table-primary"><?=formatNumberInt($montoEjEgMenosOtros);?></td>
                          <td class="text-right table-primary"><?=formatNumberInt($montoEjEgIT);?></td>
                          <td class="text-right table-primary"><?=formatNumberInt($montoEjEgDN);?></td>
                          <td class="text-right table-primary"><?=formatNumberInt($montoEjEgSA);?></td>
                          <td class="text-right table-primary"><?=formatNumberInt($montoEjEg);?></td>
                          
                          <td class="text-right bg-primary"><?=formatNumberInt($montoPresEgAcum);?></td>
                          <td class="text-right bg-primary"><?=formatNumberInt($montoEjEgAcum);?></td>

                        </tr>
            <?php
            						}
            ?>
                        <tr>
                          <td class="font-weight-bold">TOTALES</td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalPresIng);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjIng);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalPresIngAcum);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjIngAcum);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalPresEg);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjEgMenosOtros);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjEgIT);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjEgDN);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjEgSA);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjEg);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalPresEgAcum);?></td>
                          <td class="text-right font-weight-bold"><?=formatNumberInt($totalEjEgAcum);?></td>
                         </tr>

                      </tbody>
                    </table>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>  
        </div>
    </div>
