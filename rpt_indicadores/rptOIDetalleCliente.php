<?php
require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

/*$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();*/


$anio=$_GET["anio"];

$mes=$_GET["mes"];
$unidadOrganizacional=$_GET["unidad_organizacional"];
$area=$_GET["area"];
$nameArea=nameArea($area);
$codServicio=$_GET["codServicio"];

//$mesString=implode(",", $mes);
//$unidadOrgString=implode(",", $unidadOrganizacional);

//$unidadOrgString=buscarHijosUO($unidadOrgString);

$sql="";
if($area==11){
  $sql="SELECT u.abreviatura, 
  (select c.nombre from clientes c where c.codigo=e.id_cliente)as cliente, e.d_tipo, e.cantidad, e.fecha_registro, e.fecha_factura, e.estado_servicio, sd.nombre as nombreservicio, e.monto_facturado from ext_servicios e, servicios_oi_detalle sd, unidades_organizacionales u where u.codigo=e.id_oficina and  e.idclaservicio=sd.codigo and e.id_oficina in ($unidadOrganizacional) and YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura) in ($mes) and sd.codigo=$codServicio";
}else{
  $sql="SELECT u.abreviatura, (select c.nombre from clientes c where c.codigo=e.id_cliente)as cliente, e.d_tipo, 
  e.cantidad, e.fecha_registro, e.fecha_factura, e.estado_servicio, e.monto_facturado 
  from ext_servicios e, unidades_organizacionales u where u.codigo=e.id_oficina 
  and e.id_oficina in ($unidadOrgString) and YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura) in ($mesString) and e.id_area=$area";
}

//sd.cod_servicio=$codigoClasificador and
//echo $sql;

$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('abreviatura', $unidad);
$stmt->bindColumn('cliente', $nombreCliente);
$stmt->bindColumn('d_tipo', $tipoServicio);
$stmt->bindColumn('cantidad', $cantidad);
$stmt->bindColumn('fecha_registro', $fechaRegistro);
$stmt->bindColumn('fecha_factura', $fechaFactura);
$stmt->bindColumn('estado_servicio', $estadoServicio);
if($area==11){
$stmt->bindColumn('nombreservicio', $nombreServicio);  
}
$stmt->bindColumn('monto_facturado', $montoFactura);

?>

<div class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-primary">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Detalle de Servicios por Cliente</h4>
                  <h6 class="card-title">Area: <?=$nameArea;?> </h6>
                  <h6 class="card-title"> Año: <?=$anio;?> Mes:<?=$mes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed" id="tablePaginatorReport">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th class="font-weight-bold">Unidad</th>
                          <th class="font-weight-bold">Cliente</th>
                          <th class="font-weight-bold">TipoServicio</th>
                          <th class="font-weight-bold">#</th>
                          <th class="font-weight-bold">FechaServicio</th>
                          <th class="font-weight-bold">FechaFactura</th>
                          <th class="font-weight-bold">Estado</th>
                          <th class="font-weight-bold">Nombre</th>
                          <th class="font-weight-bold">Monto</th>
                          <th class="font-weight-bold">MontoNeto</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                        $totalCantidad=0;
                        $totalMonto=0;
                        $totalNeto=0;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $montoNeto=$montoFactura*0.87;
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$unidad;?></td>
                          <td class="text-left small"><?=$nombreCliente;?></td>
                          <td class="text-left small"><?=$tipoServicio;?></td>
                          <td><?=$cantidad;?></td>
                          <td><?=$fechaRegistro;?></td>
                          <td><?=$fechaFactura;?></td>
                          <td><?=$estadoServicio;?></td>
                          <td class="text-left small"><?=($area==11)?$nombreServicio:$tipoServicio;?></td>
                          <td class="text-right"><?=formatNumberDec($montoFactura);?></td>
                          <td class="text-right"><?=formatNumberDec($montoNeto);?></td>
                        </tr>
                        <?php
                          $totalCantidad+=$cantidad;
                          $totalMonto+=$montoFactura;
                          $totalNeto+=$montoNeto;
                          $index++;
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="4"></th>
                          <th><?=$totalCantidad;?></th>
                          <th colspan="4"></th>
                          <th><?=formatNumberDec($totalMonto);?></th>
                          <th><?=formatNumberDec($totalNeto);?></th>
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
