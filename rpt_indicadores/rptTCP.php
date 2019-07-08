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
$codGestion=$_GET["gestion"];
$codArea=$_GET["codArea"];
$nombreArea=nameArea($codArea);

$tablaServicios="";
$tablaServiciosDet="";
if($codArea==38){
  $tablaServicios="servicios_tcs";
  $tablaServiciosDet="servicios_tcs_detalle";
}
if($codArea==39){
  $tablaServicios="servicios_tcp";
  $tablaServiciosDet="servicios_tcp_detalle";
}
if($codArea==40){
  $tablaServicios="servicios_tlq";
  $tablaServiciosDet="servicios_tlq_detalle";
}

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
        <h3 class="title">Indicadores <?=$nombreArea;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title"># & Monto de Servicios por Tipo
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center">Indice</th>
                    <th class="text-center font-weight-bold">TipoServicio</th>
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

                  $sql="SELECT so.codigo, so.nombre, so.abreviatura, sum(e.cantidad)as totalCantidadServicios, sum(e.monto_facturado)as montoTotalFactura from ext_servicios e, $tablaServiciosDet sd, $tablaServicios so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anioTemporal and MONTH(e.fecha_factura)=$mesTemporal group by so.codigo, so.nombre, so.abreviatura order by 4 desc";
                  //echo $sql;
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('codigo', $codigoServicio);
                  $stmt->bindColumn('nombre', $nombreServicio);
                  $stmt->bindColumn('abreviatura', $abreviaturaServicio);
                  $stmt->bindColumn('totalCantidadServicios', $totalCantidadServicios);
                  $stmt->bindColumn('montoTotalFactura', $totalServicioFacturado);

                  $indice=1;
                  while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-center"><?=$indice?></td>
                    <td class="text-left"><a href="rptTCPDetalle.php?codArea=<?=$codArea;?>&codServicio=<?=$codigoServicio;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>" target="_blank"><?=$nombreServicio;?></a></td>
                    <?php
                    $stmtU->execute();
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantidadServicios=serviciosPorUnidadTCP($codigoX,$codArea,$anioTemporal,$mesTemporal,0,$codigoServicio,1);
                      $montoServicios=serviciosPorUnidadTCP($codigoX,$codArea,$anioTemporal,$mesTemporal,0,$codigoServicio,2);
                    ?>
                    <td class="text-right"><?=($cantidadServicios=="")?"-":formatNumberInt($cantidadServicios);?></td>
                    <td class="text-right"><?=($montoServicios=="")?"-":formatNumberInt($montoServicios);?></td>
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
      
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title"># & Monto de Servicios por Tipo</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartServiciosTCPNivel1.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->
        


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Ingresos y Egresos
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold" colspan="3"><?=$nombreMes?></th>
                    <th class="text-center font-weight-bold" colspan="3">Acum. <?=$nombreMes?></th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold">Ingresos</th>
                    <th class="text-center font-weight-bold">Egresos</th>
                    <th class="text-center font-weight-bold">Resultado</th>
                    <th class="text-center font-weight-bold">Ingresos</th>
                    <th class="text-center font-weight-bold">Egresos</th>
                    <th class="text-center font-weight-bold">Resultado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  $totalIngresos=0;
                  $totalIngresosAcum=0;
                  $totalEgresos=0;
                  $totalEgresosAcum=0;
                  $totalResultado=0;
                  $totalResultadoAcum=0;

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $codFondo=obtenerFondosReport($codigoX);
                    $codOrganismo=obtenerOrganismosReport($codArea);
                    $ingresosMes=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                    $ingresosMesAcum=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);

                    $egresosMes=ejecutadoEgresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                    $egresosMesAcum=ejecutadoEgresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);

                    $resultado=$ingresosMes-$egresosMes;
                    $resultadoAcum=$ingresosMesAcum-$egresosMesAcum;

                    $totalIngresos+=$ingresosMes;
                    $totalIngresosAcum+=$ingresosMesAcum;
                    $totalEgresos+=$egresosMes;
                    $totalEgresosAcum+=$egresosMesAcum;
                    $totalResultado+=$resultado;
                    $totalResultadoAcum+=$resultadoAcum;

                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><?=formatNumberInt($ingresosMes);?></td>
                    <td class="text-right"><?=formatNumberInt($egresosMes);?></td>
                    <td class="text-right font-weight-bold text-primary"><?=formatNumberInt($resultado);?></td>
                    <td class="text-right"><?=formatNumberInt($ingresosMesAcum);?></td>
                    <td class="text-right"><?=formatNumberInt($egresosMesAcum);?></td>
                    <td class="text-right font-weight-bold text-primary"><?=formatNumberInt($resultadoAcum);?></td>
                  </tr>
                  <?php
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalIngresos);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalEgresos);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalResultado);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalIngresosAcum);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalEgresosAcum);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalResultadoAcum);?></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Ingresos y Egresos</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartIngEgSEC.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->  

      

      <div class="row">
        
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Top Clientes</h5>
            </div>
            <div class="card-body">
            
              <div class="row">
              <?php
              $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
              $stmtU = $dbh->prepare($sqlU);
              $stmtU->execute();
              $stmtU->bindColumn('codigo', $codigoX);
              $stmtU->bindColumn('abreviatura', $abrevX);

              while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
              ?>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-header card-header-icon card-header-info">
                      <!--div class="card-icon">
                        <i class="material-icons">timeline</i>
                      </div-->
                      <h5 class="card-title"><?=$abrevX;?></h5>
                    </div>
                    <div class="card-body">
                      <table width="100%" class="table table-condensed">
                        <thead>
                          <tr>
                            <th class="text-center font-weight-bold">-</th>
                            <th class="text-center font-weight-bold">Cliente</th>
                            <th class="text-center font-weight-bold">Acum(Bs.)</th>
                            <th class="text-center font-weight-bold">Part.</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sqlTotal="SELECT sum(e.monto_facturado)monto from ext_servicios e where YEAR(e.fecha_factura)=$anioTemporal and MONTH(e.fecha_factura)<=$mesTemporal and e.id_area=$codArea and e.id_oficina in ($codigoX)";
                        $stmtT = $dbh->prepare($sqlTotal);
                        $stmtT->execute();
                        $stmtT->bindColumn('monto', $montoTotalClientes);
                        while($rowT = $stmtT -> fetch(PDO::FETCH_BOUND)){
                        }

                        $sqlClientes="SELECT e.id_cliente, (select c.nombre from clientes c where c.codigo=e.id_cliente)nombrecliente, sum(e.monto_facturado)monto from ext_servicios e where YEAR(e.fecha_factura)=$anioTemporal and MONTH(e.fecha_factura)<=$mesTemporal and e.id_area=$codArea and e.id_oficina in ($codigoX) group by id_cliente, nombrecliente order by 3 desc limit 0,5";
                        //echo $sqlClientes;
                        $stmtC = $dbh->prepare($sqlClientes);
                        $stmtC->execute();
                        $stmtC->bindColumn('id_cliente', $codClienteX);
                        $stmtC->bindColumn('nombrecliente', $nombreClienteX);
                        $stmtC->bindColumn('monto', $montoClienteX);
                        $indice=1;
                        while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                          $participacionCliente=($montoClienteX/$montoTotalClientes)*100;
                        ?>
                         <tr>
                            <td class="text-center small"><?=$indice;?></th>
                            <td class="text-left small"><?=$nombreClienteX;?></th>
                            <td class="text-right small"><?=formatNumberInt($montoClienteX);?></th>
                            <td class="text-right small"><?=formatNumberInt($participacionCliente);?>%</th>
                          </tr>
                        <?php  
                          $indice++;
                        }
                        ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
              </div>
            
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Incremento de Clientes 
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal-1;?></th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal;?></th>
                    <th class="text-center font-weight-bold">% Incremento</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);
                  $totalClientesAnt=0;
                  $totalClientes=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadClientesAnt=calcularClientesPeriodo($codigoX,$codArea,$mesTemporal,$anioTemporal-1);
                    $cantidadClientes=calcularClientesPeriodo($codigoX,$codArea,$mesTemporal,$anioTemporal);
                    $porcentajeCrec=0;
                    if($cantidadClientesAnt>0){
                      $porcentajeCrec=(($cantidadClientes-$cantidadClientesAnt)/$cantidadClientesAnt)*100;
                    }
                    $totalClientesAnt+=$cantidadClientesAnt;
                    $totalClientes+=$cantidadClientes;
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadClientesAnt);?></a></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadClientes);?></a></td>
                    <td class="text-center font-weight-bold text-primary"><?=formatNumberInt($porcentajeCrec);?> %</td>
                  </tr>
                  <?php
                  }
                  $porcentajeCrecTotal=0;
                  if($totalClientesAnt>0){
                    $porcentajeCrecTotal=(($totalClientes-$totalClientesAnt)/$totalClientesAnt)*100;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientesAnt);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientes);?></td>
                    <td class="text-center font-weight-bold"><?=formatNumberInt($porcentajeCrecTotal);?> %</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Retencion de Clientes</h5>
            </div>
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal;?></th>
                    <th class="text-center font-weight-bold">Clientes Retenidos</th>
                    <th class="text-center font-weight-bold">% Retencion</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);
                  $totalClientesRetenidos=0;
                  $totalClientes=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadClientes=calcularClientesPeriodo($codigoX,$codArea,$mesTemporal,$anioTemporal);
                    $cantidadRetenidos=calcularClientesRetenidos($codigoX,$codArea,$mesTemporal,$anioTemporal);
                    $porcentajeCrec=0;
                    if($cantidadClientes>0){
                      $porcentajeCrec=($cantidadRetenidos/$cantidadClientes)*100;
                    }
                    $totalClientesRetenidos+=$cantidadRetenidos;
                    $totalClientes+=$cantidadClientes;
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadClientes);?></a></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadRetenidos);?></a></td>
                    <td class="text-center font-weight-bold text-primary"><?=formatNumberInt($porcentajeCrec);?> %</td>
                  </tr>
                  <?php
                  }
                  $porcentajeCrecTotal=0;
                  if($totalClientes>0){
                    $porcentajeCrecTotal=($totalClientesRetenidos/$totalClientes)*100;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientes);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientesRetenidos);?></td>
                    <td class="text-center font-weight-bold"><?=formatNumberInt($porcentajeCrecTotal);?> %</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->  

    </div>
  </div>
</div>


<script type="text/javascript">
  totalesRptOIServ1();
</script>