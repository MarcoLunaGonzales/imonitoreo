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


$mes=$_GET["mes"];
$gestion=$_GET["gestion"];
$desde=nameGestion($gestion)."-01-01";
$datosMes=explode("####", $_GET["mes"]);
$gestiones[0]=$gestion;
if(count($datosMes)>0){
  $mes=$datosMes[0];
  if($datosMes[1]>0){
    $gestion=$datosMes[1];
    $gestiones[1]=$datosMes[1];
  }  
}
$stringGestiones=implode(",", $gestiones);
$diaUltimo=date("d",(mktime(0,0,0,$mes,1,nameGestion($gestion))-1));
$hasta=nameGestion($gestion)."-".$mes."-".$diaUltimo;

$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

$globalGestion=$_SESSION["globalGestion"];
$globalUsuario=$_SESSION["globalUser"];


//$sqlDetalleX="SELECT pc.codigo, m.glosa_detalle, m.fecha, m.monto, m.fondo, m.organismo, m.ml_partida, 
//(select c.abreviatura from componentessis c where c.partida=m.ml_partida limit 0,1)as codigoact from po_mayores m, po_plancuentas pc where pc.codigo=m.cuenta and m.fondo=2001 and YEAR(m.fecha)='$anio' and MONTH(m.fecha)='$mes' and m.ml_partida<>'' and pc.codigo like '5%' order by m.fecha;";
$sqlDetalleX="SELECT pc.codigo, m.glosa_detalle, m.fecha, m.monto, m.fondo, m.organismo, m.ml_partida, 
(select c.abreviatura from componentessis c where c.partida=m.ml_partida limit 0,1)as codigoact from po_mayores m, po_plancuentas pc where pc.codigo=m.cuenta and m.fondo=2001 and m.fecha BETWEEN '$desde' and '$hasta' and m.ml_partida<>'' and pc.codigo like '5%' order by m.fecha;";

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
                  <h4 class="card-title">Relacionar Gastos SIS con AccNum</h4>
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
                          <th class="text-center font-weight-bold">Codigo</th>
                          <th class="text-center font-weight-bold">Glosa</th>
                          <th class="text-center font-weight-bold">Monto</th>
                          <th class="text-center font-weight-bold">AccNumber</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                        $index=1;
                        while ($row = $stmtDetalleX->fetch(PDO::FETCH_BOUND)) {
                          //SANITIZAMOS LA CADENA PARA COMPARAR EL STRING
                          $glosaComparar=string_sanitize($glosa);
                          $gestionActual=obtenerCodigoGestionNombre(date("Y",strtotime($fecha))); 
                          $glosaCompararMostrar=$glosaComparar;
                          $cantidadCortar=120;
                          if(strlen($glosaCompararMostrar)>$cantidadCortar){
                            $glosaCompararMostrar=substr($glosaCompararMostrar, 0, $cantidadCortar);
                            $glosaCompararMostrar.="...";
                          }
                         
                          $sqlVerifica="SELECT cod_externalcost from gastos_externalcosts where fecha='$fecha' and ml_partida='$mlPartida' and glosa_detalle='$glosaComparar'";
                          //echo $sqlVerifica;
                          $stmtVerifica = $dbh->prepare($sqlVerifica);
                          $stmtVerifica->execute();
                          $codigoAccX=0;
                          while ($rowVerifica = $stmtVerifica->fetch(PDO::FETCH_ASSOC)) {
                             $codigoAccX=$rowVerifica['cod_externalcost'];
                          }

                      ?>
                      <tr>
                        <td class="text-center small"><?=$index;?></td>
                        <td class="text-center small"><?=$fecha;?></td>
                        <td class="text-center small"><?=$codigoActividad;?></td>
                        
                        <td class="text-left small"><?=$glosaCompararMostrar;?></td>
                        
                        <td class="text-right"><?=formatNumberInt($monto);?></td>
                        <td class="text-center">
                          <div class="form-group">
                          <select class="form-control" title="Seleccione una opcion" name="externalcost[]" id="externalcost[]" data-style="<?=$comboColor;?>">
                            <option disabled selected value="">AccNum</option>
                          <?php
                          $stmt = $dbh->prepare("select e.codigo, e.nombre, e.abreviatura from external_costs e where e.cod_gestion='$gestionActual' order by e.abreviatura");
                          $stmt->execute();
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $codigoX=$row['codigo'];
                            $nombreX=$row['nombre'];
                            $nombreX=substr($nombreX, 0,50)."...";
                            $abreviaturaX=$row['abreviatura'];
                          ?>
                          <option value="<?=$codigoX;?>|<?=$fecha;?>|<?=$mlPartida;?>|<?=$glosa;?>" <?=($codigoX==$codigoAccX)?"selected":"";?> ><?=$abreviaturaX?>.<?=$nombreX;?></option>
                          <?php 
                          }
                          ?>
                          </select>
                          </div>
                      </td>
                      </tr>  
                      <?php
                        $index++;
                      }
                      ?>  
                     </tbody>

                      <!--tfoot>
                        <tr>
                          <th>-</th>
                          <th>TOTALES</th>
                        </tr>
                      </tfoot-->
                    </table>
                  </div>
                </div>
  
                <div class="card-footer ml-auto mr-auto">
                  <button type="submit" class="<?=$button;?>">Guardar</button>
                </div>

              </form>

            </div>
          </div>
        </div>  
      </div>
  </div>

