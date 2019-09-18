<?php
require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$nameGestion=$_GET["anio"];
$mes=$_GET["mes"];

$unidadOrganizacional=$_GET["unidad_organizacional"];
$codigoServicio=$_GET["codigoServicio"];
$area=$_GET["area"];

//$mesString=implode(",", $mes);
//$unidadOrgString=implode(",", $unidadOrganizacional);

$unidadOrgString=buscarHijosUO($unidadOrganizacional);
//echo $unidadOrgString;
$abreviaturaServicio=buscarAbreviaturaServicio($codigoServicio);
$sql="SELECT e.doficina, e.dcliente, e.cantidad, e.fecha, e.fechaestado, e.destado, e.dserviciocurso, e.grandetalle, montobs from ext_solicitudfacturacion e where e.codigoserviciocurso like '%$abreviaturaServicio%' and YEAR(e.fecha)='$nameGestion' and MONTH(e.fecha)='$mes' and e.idestado not in (266) and e.idoficina in ($unidadOrgString)";  

//echo $sql;

$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('doficina', $unidad);
$stmt->bindColumn('dcliente', $nombreCliente);
$stmt->bindColumn('cantidad', $cantidad);
$stmt->bindColumn('fecha', $fechaRegistro);
$stmt->bindColumn('fechaestado', $fechaFactura);
$stmt->bindColumn('destado', $estadoServicio);
$stmt->bindColumn('dserviciocurso', $nroServicio);

$stmt->bindColumn('grandetalle', $nombreServicio);  
$stmt->bindColumn('montobs', $montoFacturado);

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
                  <h4 class="card-title">Reporte de Servicios</h4>
                  <h6 class="card-title">Gestion: <?=$nameGestion;?> Mes:<?=$mes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed id="tablePaginatorReport">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th class="font-weight-bold">Unidad</th>
                          <th class="font-weight-bold">Cliente</th>
                          <th class="font-weight-bold">TipoServicio</th>
                          <th class="font-weight-bold">#</th>
                          <th class="font-weight-bold">Fecha</th>
                          <th class="font-weight-bold">FechaEstado</th>
                          <th class="font-weight-bold">Estado</th>
                          <th class="font-weight-bold">CodigoServicio</th>
                          <th class="font-weight-bold">Nombre</th>
                          <th class="font-weight-bold">Facturado</th>
                          <th class="font-weight-bold">Neto</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                        $totalCantidad=0;
                        $totalMonto=0;
                        $totalNeto=0;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $montoNeto=$montoFacturado*0.87;
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$unidad;?></td>
                          <td class="text-left small"><?=$nombreCliente;?></td>
                          <td class="text-left small"><?=$abreviaturaServicio;?></td>
                          <td><?=$cantidad;?></td>
                          <td><?=$fechaRegistro;?></td>
                          <td><?=$fechaFactura;?></td>
                          <td><?=$estadoServicio;?></td>
                          <td class="text-left small"><?=($area==11)?$nombreServicio:$tipoServicio;?></td>
                          <td><?=$nroServicio;?></td>
                          <td><?=formatNumberDec($montoFacturado);?></td>
                          <td><?=formatNumberDec($montoNeto);?></td>
                        </tr>
                        <?php
                          $index++;
                          $totalCantidad+=$cantidad;
                          $totalMonto+=$montoFacturado;
                          $totalNeto+=$montoNeto;
                        }
                        ?>
                        <tr>
                          <th colspan="4"></th>
                          <th><?=$totalCantidad;?></th>
                          <th colspan="5"></th>
                          <th><?=formatNumberDec($totalMonto);?></th>
                          <th><?=formatNumberDec($totalNeto);?></th>
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
