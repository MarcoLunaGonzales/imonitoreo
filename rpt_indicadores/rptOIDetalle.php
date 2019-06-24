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
$codArea=$_GET["codArea"];
$codServicio=$_GET["codServicio"];

$nombreArea=nameArea($codArea);


$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=11");
$stmt->execute();
$cadenaUnidades="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaUnidades=$row['valor_configuracion'];
}

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Detalle por Servicio <?=$nombreArea;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title"># & Monto de Servicios Detalle
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center">Indice</th>
                    <th class="text-center font-weight-bold">Servicio</th>
                    <?php
                      $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                      $stmtU = $dbh->prepare($sqlU);
                      $stmtU->execute();
                      $stmtU->bindColumn('codigo', $codigoX);
                      $stmtU->bindColumn('abreviatura', $abrevX);

                      while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    ?>
                    <th class="text-center font-weight-bold" colspan="2"><?=$abrevX?></th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold" colspan="2">Total</th>
                  </tr>
                  <tr>
                    <th class="text-center">-</th>
                    <th class="text-center font-weight-bold">-</th>
                    <?php
                      $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                      $stmtU = $dbh->prepare($sqlU);
                      $stmtU->execute();
                      $stmtU->bindColumn('codigo', $codigoX);
                      $stmtU->bindColumn('abreviatura', $abrevX);

                      while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    ?>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">Bs.</th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">Bs.</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql="SELECT sd.codigo, sd.nombre, sum(e.cantidad)as totalCantidadServicios, sum(e.monto_facturado)as montoTotalFactura from ext_servicios e, servicios_oi_detalle sd, servicios_oi so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anioTemporal and MONTH(e.fecha_factura)=$mesTemporal and so.codigo=$codServicio group by sd.codigo, sd.nombre order by 4 desc";
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('codigo', $codigoServicio);
                  $stmt->bindColumn('nombre', $nombreServicio);
                  $stmt->bindColumn('totalCantidadServicios', $totalCantidadServicios);
                  $stmt->bindColumn('montoTotalFactura', $totalServicioFacturado);

                  $indice=1;
                  while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-center"><?=$indice?></td>
                    <td class="text-left"><?=$nombreServicio;?></td>
                    <?php
                    $stmtU->execute();
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantidadServicios=serviciosPorUnidadDetalle($codigoX,$anioTemporal,$mesTemporal,0,$codigoServicio,1);
                      $montoServicios=serviciosPorUnidadDetalle($codigoX,$anioTemporal,$mesTemporal,0,$codigoServicio,2);
                    ?>
                    <td class="text-right"><a href="rptOIDetalleCliente.php?area=<?=$codArea;?>&codServicio=<?=$codigoServicio;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&unidad_organizacional=<?=$codigoX;?>" target="_blank"><?=($cantidadServicios=="")?"-":formatNumberInt($cantidadServicios);?></a></td>
                    <td class="text-right"><a href="rptOIDetalleCliente.php?area=<?=$codArea;?>&codServicio=<?=$codigoServicio;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&unidad_organizacional=<?=$codigoX;?>" target="_blank"><?=($montoServicios=="")?"-":formatNumberInt($montoServicios);?></a></td>
                    <?php
                    }    
                    ?>                
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalCantidadServicios);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalServicioFacturado);?></td>
                  </tr>
                  <?php
                    $indice++;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <th>-</th>
                    <th class="text-center font-weight-bold">Totales</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>


<script type="text/javascript">
  totalesRptOIServ1();
</script>