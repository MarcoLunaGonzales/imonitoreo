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

$gestion=$_GET["gestion"];
$mes=$_GET["mes"];
$tiporeporte=$_GET["tiporeporte"];

$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

$globalGestion=$_SESSION["globalGestion"];
$globalUsuario=$_SESSION["globalUser"];


$sqlDetalleX="SELECT pc.codigo, m.glosa_detalle, m.fecha, m.monto, m.fondo, m.organismo, m.ml_partida, 
(select c.abreviatura from componentessis c where c.partida=m.ml_partida limit 0,1)as codigoact from po_mayores m, po_plancuentas pc where pc.codigo=m.cuenta and m.fondo=2001 and YEAR(m.fecha)='$anio' and m.ml_partida<>'' and m.cuenta like '5%'";
if($tiporeporte==0){
  $sqlDetalleX.=" and MONTH(m.fecha)='$mes' order by m.fecha;";  
}else if($tiporeporte==1){
  $sqlDetalleX.=" and MONTH(m.fecha)<='$mes' order by m.fecha;";  
}

//echo $sqlDetalleX;

$stmtDetalleX = $dbh->prepare($sqlDetalleX);
$stmtDetalleX->execute();

// bindColumn
$stmtDetalleX->bindColumn('codigo', $codigoCuenta);
$stmtDetalleX->bindColumn('glosa_detalle', $glosa);
$stmtDetalleX->bindColumn('fecha', $fecha);
$stmtDetalleX->bindColumn('monto', $monto);
$stmtDetalleX->bindColumn('fondo', $fondo);
$stmtDetalleX->bindColumn('organismo', $organismo);
$stmtDetalleX->bindColumn('ml_partida', $mlPartida);
$stmtDetalleX->bindColumn('codigoact', $codigoActividad);

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
                  <h4 class="card-title">Reporte Gastos SIS con AccNum</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>
                </div>

                <form id="form1" class="form-horizontal" action="saveRelacionarGastosSIS.php" method="POST">

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="main" width="100">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">-</th>
                          <th class="text-center font-weight-bold">Fecha</th>
                          <th class="text-center font-weight-bold">CodActividad</th>
                          <th class="text-center font-weight-bold">AccNum</th>
                          <th class="text-center font-weight-bold">ExternalCost</th>
                          <th class="text-center font-weight-bold">Glosa</th>
                          <th class="text-center font-weight-bold">Monto</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                        $index=1;
                        $totalGastos=0;
                        while ($row = $stmtDetalleX->fetch(PDO::FETCH_BOUND)) {
                          //SANITIZAMOS LA CADENA PARA COMPARAR EL STRING
                          $glosaComparar=string_sanitize($glosa);
                         
                          $sqlVerifica="SELECT cod_externalcost from gastos_externalcosts where fecha='$fecha' and ml_partida='$mlPartida' and glosa_detalle='$glosaComparar'";
                          //echo $sqlVerifica;
                          $stmtVerifica = $dbh->prepare($sqlVerifica);
                          $stmtVerifica->execute();
                          $codigoAccX=0;
                          while ($rowVerifica = $stmtVerifica->fetch(PDO::FETCH_ASSOC)) {
                             $codigoAccX=$rowVerifica['cod_externalcost'];
                          }
                          $abrevAccX=abrevAccNum($codigoAccX);
                          $nombreAccX=nameAccNum($codigoAccX);
                          $totalGastos+=$monto;

                      ?>
                      <tr>
                        <td class="text-center small"><?=$index;?></td>
                        <td class="text-center small"><?=$fecha;?></td>
                        <td class="text-center small"><?=$codigoActividad;?></td>
                        <td class="text-center table-success small"><?=$abrevAccX;?></td>
                        <td class="text-left table-success small"><?=$nombreAccX;?></td>
                        <td class="text-left small"><?=$glosa;?></td>
                        <td class="text-right"><?=formatNumberDec($monto);?></td>
                        <td class="text-center"></td>
                      </tr>  
                      <?php
                        $index++;
                      }
                      ?>  
                     </tbody>

                      <tfoot>
                        <tr>
                          <th>-</th>
                          <th colspan="5" class="text-right">TOTALES</th>
                          <th class="text-right"><?=formatNumberDec($totalGastos);?></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
  

              </form>

            </div>
          </div>
        </div>  
      </div>
  </div>

