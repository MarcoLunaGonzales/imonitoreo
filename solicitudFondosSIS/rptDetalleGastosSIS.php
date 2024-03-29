<?php

error_reporting(E_ALL);

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
$gestionOficial=$gestion;

$desde=nameGestion($gestion)."-01-01";
$datosMes=explode("####", $_GET["mes"]);
$gestiones[0]=$gestion;
if(count($datosMes)>0 && $datosMes[1]!="NONE"){
  $mes=$datosMes[0];
  if($datosMes[1]>0){
    $gestion=$datosMes[1];
    $gestiones[1]=$datosMes[1];
  }  
}else{
  $mes=$datosMes[0];
}

$stringGestiones=implode(",", $gestiones);
$diaUltimo=date("d",(mktime(0,0,0,$mes,1,nameGestion($gestion))-1));
$hasta=nameGestion($gestion)."-".$mes."-01";

$hasta=date('Y-m-d',strtotime($hasta.'+1 month'));
$hasta=date('Y-m-d',strtotime($hasta.'-1 day'));

$codigo_proy=$_GET["codigo_proy"];
$nombre_proyecto=obtener_nombre_proyecto($codigo_proy);



$anio=nameGestion($gestion);
$nombreMes=nameMes($mes);

$globalGestion=$_SESSION["globalGestion"];
$globalUsuario=$_SESSION["globalUser"];

//$globalGestion=1205;

//LLAMAMOS A UN SP QUE ORDENA LOS COMPONENTES O ACTIVIDADES SIS
$sql = 'CALL ordenar_componentes(?,?,?)';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $globalUsuario, PDO::PARAM_INT, 10);
$stmt->bindParam(2, $globalGestion, PDO::PARAM_INT, 10);
$stmt->bindParam(3, $codigo_proy, PDO::PARAM_INT, 10);
$stmt->execute();


//echo $globalUsuario." ".$globalGestion." ".$codigo_proy;

$sql="SELECT codigo, partida, nombre, abreviatura, nivel from componentessis_orden 
  where cod_usuario='$globalUsuario' ORDER BY indice";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigoComponente);
$stmt->bindColumn('partida', $partidaComponente);
$stmt->bindColumn('nombre', $nombreComponente);
$stmt->bindColumn('abreviatura', $abreviaturaComponente);
$stmt->bindColumn('nivel', $nivelComponente);

//echo $codigoComponente."<br>";
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
                  <h4 class="card-title">Detalle de Gastos SIS</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes: <?=$nombreMes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="main">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">Codigo</th>
                          <th class="text-center font-weight-bold">Actividad</th>
                          <th class="text-center font-weight-bold">Ejecucion</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                        $indice=0;
                        $montoEjecucionComponente=0;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          if($nivelComponente==1){
                            $styleText="text-left font-weight-bold text-danger";
                          }
                          if($nivelComponente==2){
                            $styleText="text-left font-weight-bold text-primary";
                          }
                          if($nivelComponente==3){
                            $styleText="text-left font-weight-bold small";
                          }      
                          $montoEjecucionComponente=0;
                          $montoAnteriorEjecucion=0;
                          if(isset($gestiones[1])){                          
                            $montoAnteriorEjecucion=montoEjecucionComponente($gestionOficial,nameGestion($gestiones[0]),12,$codigoComponente,$nivelComponente);
                          }                          
                          $montoEjecucionComponente=$montoAnteriorEjecucion+montoEjecucionComponente($gestionOficial,$anio,$mes,$codigoComponente, $nivelComponente);                    
                          //$montoEjecucionComponente=montoEjecucionComponente($anio,$mes,$codigoComponente, $nivelComponente);

                          if($montoEjecucionComponente>0){
                      ?>
                        <tr>
                          <td class="<?=$styleText;?>"><?=$abreviaturaComponente;?></td>

                          <td><p class="<?=$styleText;?>"><?=$nombreComponente;?></p></td>

                          <td class="text-right font-weight-bold"><?=formatNumberDec($montoEjecucionComponente);?></td>
                        </tr>
                      <?php
                          }
                        $sqlDetalle="";
                        if($partidaComponente==''){
                          $partidaComponente='-100';
                        }
                        $sqlDetalle="SELECT p.codigo, p.nombre, sum(m.monto)as monto from po_mayores m, po_plancuentas p where m.ml_partida in ($partidaComponente) and m.cuenta=p.codigo and m.fecha BETWEEN '$desde' and '$hasta' group by p.codigo, p.nombre order by 2";
                        
                        //echo "cod: ".$codigoComponente." ".$sqlDetalle;
                        
                        $stmtDetalle = $dbh->prepare($sqlDetalle);
                        $stmtDetalle->execute();
                        $stmtDetalle->bindColumn('codigo', $codigo);
                        $stmtDetalle->bindColumn('nombre', $nombre);
                        $stmtDetalle->bindColumn('monto', $montoDetalle);
                        
                        while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_BOUND)) {
                          $indice++;
                      ?>
                      <tr>
                        <td class="text-right small">&nbsp;</td>
                        <td class="text-left">
                        <div id="accordion<?=$indice;?>" role="tablist">
                            <div class="card-collapse">
                              <div class="card-header" role="tab" id="heading<?=$indice;?>">
                                <h5 class="mb-0">
                                  <a data-toggle="collapse" href="#collapse<?=$indice;?>" aria-expanded="false" aria-controls="collapse<?=$indice;?>" class="collapsed">
                                    <?=$nombre;?>
                                    <i class="material-icons">keyboard_arrow_down</i>
                                  </a>
                                </h5>
                              </div>
                              <div id="collapse<?=$indice;?>" class="collapse" role="tabpanel" aria-labelledby="heading<?=$indice;?>" data-parent="#accordion<?=$indice;?>" style="">
                                <div class="card-body">
                                  <?php
                                  $sqlDetalleX="SELECT s.indice, s.glosa_detalle, s.fecha, s.monto, s.ml_partida from po_mayores s, po_plancuentas pc where pc.codigo=s.cuenta and s.fondo=2001 and s.fecha BETWEEN '$desde' and '$hasta' and s.ml_partida='$partidaComponente' and pc.codigo='$codigo' order by s.fecha;";
                                  
                                  //echo $sqlDetalle;
                                  
                                  $stmtDetalleX = $dbh->prepare($sqlDetalleX);
                                  $stmtDetalleX->execute();

                                  // bindColumn
                                  $stmtDetalleX->bindColumn('indice', $indiceMayores);
                                  $stmtDetalleX->bindColumn('glosa_detalle', $glosa);
                                  $stmtDetalleX->bindColumn('fecha', $fecha);
                                  $stmtDetalleX->bindColumn('monto', $monto);
                                  $stmtDetalleX->bindColumn('ml_partida', $mlPartida);

                                  ?>
                                  <table width="100%">
                                    <tr>
                                      <th>Fecha</th>
                                      <th>Detalle</th>
                                      <th class="text-center font-weight-bold">AccNum</th>
                                      <th class="text-center font-weight-bold">ExternalCost</th>
                                      <th>Monto</th>
                                    </tr>
                                  <?php
                                  while ($rowDetalleX = $stmtDetalleX->fetch(PDO::FETCH_BOUND)) {
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
                                  ?>
                                  <tr>
                                    <td><?=$fecha;?></td>
                                    <td class="text-left small"><?=$glosa;?></td>
                                    <td class="text-left small"><?=$abrevAccX;?></td>
                                    <td class="text-left small"><?=$nombreAccX;?></td>
                                    <td class="text-right"><?=formatNumberDec($monto);?></td>
                                  </tr>
                                  <?php    
                                  }
                                  ?>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="text-right"><?=formatNumberDec($montoDetalle);?></td>
                      </tr>    
                      <?php
                        }
                      }
                      ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>-</th>
                          <th>TOTALES</th>
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
  totalesSIS3();
</script>