<?php
error_reporting(E_ALL);
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

$gestion=$_GET["gestion"];
$anio=nameGestion($gestion);
$mes=$_GET["mes"];

$organismoV=$_GET["organismos"];
$organismos=implode(",", $organismoV);
$organismoArray=str_replace(',', '|', $organismos);


$cadenaOrganismos=0;
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}
$cadenaOrganismos=$organismos;

//echo $cadenaOrganismos;


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


//FONDOS
$cadenaFondosTodo='';
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=7");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaFondosTodo=$row['valor_configuracion'];
}

?>

<div class="content">
	<div class="container-fluid">
    <div class="row">
      <div class="card">
        <div class="card-header <?=$colorCard;?> card-header-icon">
                  <div class="card-icon">
                    <a href="../graficos/rptComposicionIngresos.php?anio=<?=$anio;?>&mes=<?=$mes;?>&codigosFondo=<?=$cadenaFondosTodo;?>" target="_blank" title="Ver Composicion Ingresos">
                      <i class="material-icons">pie_chart</i>
                    </a>
                  </div>
                  <h4 class="card-title">Reporte Seguimiento PO por Area y Regional</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?></h6>
                  <h6 class="card-title">Mes: <?=$mes;?></h6>
        </div>

        <?php
        $sqlOrganismos="SELECT o.codigo, o.nombre from po_organismos o where o.codigo in ($cadenaOrganismos)";
        $stmtOrganismo=$dbh->prepare($sqlOrganismos);
        $stmtOrganismo->execute();
        while($rowOrganismo=$stmtOrganismo->fetch(PDO::FETCH_ASSOC)){
          $codOrganismoX=$rowOrganismo['codigo']; 
          $nombreOrganismoX=$rowOrganismo['nombre']; 

          //SACAMOS EL TOTAL A DISTRIBUIR
          $montoTotalDNMes=distribucionDNSA($cadenaFondosTodo,$anio,$mes,$codOrganismoX,0,1);
          $montoTotalSAMes=distribucionDNSA($cadenaFondosTodo,$anio,$mes,$codOrganismoX,0,2);

          $montoTotalDNAcumulado=distribucionDNSA($cadenaFondosTodo,$anio,$mes,$codOrganismoX,1,1);
          $montoTotalSAAcumulado=distribucionDNSA($cadenaFondosTodo,$anio,$mes,$codOrganismoX,1,2);

          //echo $montoTotalDNMes." ".$montoTotalSAMes."<br>";
          $montoTotalDNADistribuir=$montoTotalSAMes+$montoTotalDNMes;
          $montoTotalDNADistribuirAcumulado=$montoTotalSAAcumulado+$montoTotalDNAcumulado;

          //$montoTotalDNADistribuir=0;
          //$montoTotalDNADistribuirAcumulado=0;

        ?>
    <div class="row">
      
        <?php
          $montoEjecutadoGrupo1=0;
          $montoEjecutadoGrupo2=0;
          $montoEjecutadoGrupo3=0;

          $nombreGrupo1="";
          $nombreGrupo2="";
          $nombreGrupo3="";

          for ($i=1;$i<=3;$i++) {                    
            $nombreConjunto="";
            $nombreConjunto=nameGrupoFondo($i);
            $codigosConjunto=codigosGrupoFondo($i);
          ?>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <a href="../graficos/chartTendencias.php?codigosFondo=<?=$codigosConjunto;?>&nombreFondo=<?=$nombreConjunto;?>&mes=<?=$mes;?>&anio=<?=$anio;?>&organismo=<?=$codOrganismoX;?>" target="_blank" title="Ver Reporte de Tendencias">
                <i class="material-icons">bar_chart</i>
              </a>
            </div>
            <div class="card-icon">
              <a href="../graficos/rptComposicionIngresos.php?anio=<?=$anio;?>&mes=<?=$mes;?>&codigosFondo=<?=$codigosConjunto;?>" target="_blank" title="Composicion de Ingresos">
                <i class="material-icons">pie_chart</i>
              </a>
            </div>

          </div>
          <!--div class="card-body"-->
            <table width="100%">
              <thead>
                <tr>
                  <th colspan="5" class="text-center font-weight-bold"><?=$nombreOrganismoX;?> - <?=$nombreConjunto;?></th>
                </tr>
                <tr>
                  <th class="text-center font-weight-bold">-</th>
                  <th class="text-center font-weight-bold">Pres.</th>
                  <th class="text-center font-weight-bold">Eje.</th>
                  <th class="text-center font-weight-bold">%</th>
                  <th class="text-center font-weight-bold">Part.</th>
                </tr>
              </thead>
              <tbody>
              <?php
                //SACAMOSM EL DETALLE CONJUNTO
                $montoPresIngConjunto=presupuestoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $montoEjIngConjunto=ejecutadoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $porcentajeIngConjunto=0;
                if($montoPresIngConjunto>0){
                  $porcentajeIngConjunto=($montoEjIngConjunto/$montoPresIngConjunto)*100;
                }

                //SACAMOS LOS MONTOS PARA LA PARTICIPACION DE LOS INGRESOS TABLA FINAL
                if($i==1){
                  $montoEjecutadoGrupo1=$montoEjIngConjunto;
                  $nombreGrupo1=$nombreConjunto;
                }
                if($i==2){
                  $montoEjecutadoGrupo2=$montoEjIngConjunto;
                  $nombreGrupo2=$nombreConjunto;
                }
                if($i==3){
                  $montoEjecutadoGrupo3=$montoEjIngConjunto;
                  $nombreGrupo3=$nombreConjunto;
                }
                $colorPorcentajeIngreso=colorPorcentajeIngreso($porcentajeIngConjunto);
                ?>
                <tr>
                  <td class="text-left font-weight-bold">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">Ingresos
                    </a>
                  </td>
                  <td class="text-right  font-weight-bold table-warning"><?=formatNumberInt($montoPresIngConjunto);?>
                  </td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoEjIngConjunto);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($porcentajeIngConjunto);?></td>
                  <td class="text-right  font-weight-bold table-warning"><?=formatNumberInt(100);?></td>
                </tr>
                <?php
                //ACA EMPEZAMOS EL DETALLE POR REGIONAL
                $sqlFondos="SELECT distinct(f.codigo), f.abreviatura as nombre from po_fondos f where f.cod_grupo in ($i) order by 2";
                $stmtFondo = $dbh->prepare($sqlFondos);
                $stmtFondo->execute();
                $stmtFondo->bindColumn('codigo', $codFondo);
                $stmtFondo->bindColumn('nombre', $nombreFondo);
                while($rowFondo = $stmtFondo->fetch(PDO::FETCH_BOUND)){
                  $montoPresIng=presupuestoIngresosMes($codFondo,$anio,$mes,$codOrganismoX,0,0);
                  $montoEjIng=ejecutadoIngresosMes($codFondo,$anio,$mes,$codOrganismoX,0,0);
                  
                  $porcentajeIng=0;
                  if($montoPresIng>0){
                    $porcentajeIng=($montoEjIng/$montoPresIng)*100;
                  }

                  $participacionIng=0;
                  if($montoEjIngConjunto>0){
                    $participacionIng=($montoEjIng/$montoEjIngConjunto)*100;        
                  }

                  $colorPorcentajeIngreso="";
                  if($montoPresIng>0){
                    $colorPorcentajeIngreso=colorPorcentajeIngreso($porcentajeIng);                    
                  }
              ?>
                <!--tr>
                  <td class="text-left">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codFondo;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank"><?=$nombreFondo;?>
                    </a>

                    <a href="../graficos/chartTendencias.php?codigosFondo=<?=$codFondo;?>&nombreFondo=<?=$nombreFondo;?>&mes=<?=$mes;?>&anio=<?=$anio;?>&organismo=<?=$codOrganismoX;?>" target="_blank" title="Ver Reporte de Tendencias">
                      <i class="material-icons icon-red">bar_chart</i>
                    </a>

                  </td>
                  <td class="text-right table-warning"><?=formatNumberInt($montoPresIng);?></td>
                  <td class="text-right table-warning"><?=formatNumberInt($montoEjIng);?></td>
                  <td class="text-right <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($porcentajeIng);?></td>
                  <td class="text-right table-warning"><?=formatNumberInt($participacionIng);?></td>
                </tr-->
    <?php
    						}
                //SACAMOSM EL DETALLE CONJUNTO EGRESOS
                $montoPresEgConjunto=presupuestoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);
                $montoEjEgConjunto=ejecutadoEgresosMesSinRedist($codigosConjunto,$anio,$mes,$codOrganismoX,0,0);

                /********DIVIDIDO EN 3 LPZ 30 % CBBA 30 % SCZ 40% *******/
                if($i==1){
                  $montoEjEgConjunto=$montoEjEgConjunto+($montoTotalDNADistribuir*0.3);
                }
                if($i==2){
                  $montoEjEgConjunto=$montoEjEgConjunto+($montoTotalDNADistribuir*0.3);
                }
                if($i==3){
                  $montoEjEgConjunto=$montoEjEgConjunto+($montoTotalDNADistribuir*0.4);
                }
                /******** FIN DIVIDIDO EN 3 LPZ 30 % CBBA 30 % SCZ 40%   *******/


                $porcentajeEgConjunto=0;
                if($montoPresEgConjunto>0){
                  $porcentajeEgConjunto=($montoEjEgConjunto/$montoPresEgConjunto)*100;
                }

                $colorPorcentajeEgreso=colorPorcentajeEgreso($porcentajeEgConjunto);
                ?>
                <tr>
                  <td class="text-left font-weight-bold">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">
                    Egresos
                    </a>  
                  </td>
                  <td class="text-right  font-weight-bold table-info"><?=formatNumberInt($montoPresEgConjunto);?></td>
                  <td class="text-right font-weight-bold table-info"><?=formatNumberInt($montoEjEgConjunto);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeEgreso;?>"><?=formatNumberInt($porcentajeEgConjunto);?></td>
                  <td class="text-right  font-weight-bold table-info"><?=formatNumberInt(100);?></td>
                </tr>
                <?php
                //ACA EMPEZAMOS EL DETALLE POR REGIONAL
                $sqlFondos="SELECT distinct(f.codigo), f.abreviatura as nombre from po_fondos f where f.cod_grupo in ($i) order by 2";
                $stmtFondo = $dbh->prepare($sqlFondos);
                $stmtFondo->execute();
                $stmtFondo->bindColumn('codigo', $codFondo);
                $stmtFondo->bindColumn('nombre', $nombreFondo);
                while($rowFondo = $stmtFondo->fetch(PDO::FETCH_BOUND)){
                  $montoPresEg=presupuestoEgresosMes($codFondo,$anio,$mes,$codOrganismoX,0,0);
                  $montoEjEg=ejecutadoEgresosMes($codFondo,$anio,$mes,$codOrganismoX,0,0);
                  
                  $porcentajeEg=0;
                  if($montoPresEg>0){
                    $porcentajeEg=($montoEjEg/$montoPresEg)*100;
                  }

                  $participacionEg=0;
                  if($montoEjEgConjunto>0){
                    $participacionEg=($montoEjEg/$montoEjEgConjunto)*100;        
                  }
                  $colorPorcentajeEgreso="";
                  if($montoPresEg>0){
                    $colorPorcentajeEgreso=colorPorcentajeEgreso($porcentajeEg);
                  }
              ?>
                <!--tr>
                  <td class="text-left">
                    <a href="seguimientoPOxCuenta.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codFondo;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">
                      <?=$nombreFondo;?>
                    </a>

                    <a href="../graficos/chartTendencias.php?codigosFondo=<?=$codFondo;?>&nombreFondo=<?=$nombreFondo;?>&mes=<?=$mes;?>&anio=<?=$anio;?>&organismo=<?=$codOrganismoX;?>" target="_blank" title="Ver Reporte de Tendencias">
                      <i class="material-icons icon-green">bar_chart</i>
                    </a>
                  </td>
                  <td class="text-right table-info"><?=formatNumberInt($montoPresEg);?></td>
                  <td class="text-right table-info"><?=formatNumberInt($montoEjEg);?></td>
                  <td class="text-right <?=$colorPorcentajeEgreso;?>"><?=formatNumberInt($porcentajeEg);?></td>
                  <td class="text-right table-info"><?=formatNumberInt($participacionEg);?></td>
                </tr-->
    <?php
                }
                $resultadoPres=$montoPresIngConjunto-$montoPresEgConjunto;
                $resultadoEj=$montoEjIngConjunto-$montoEjEgConjunto;
                $porcentajeResultado=0;
                if($resultadoPres>0){
                  $porcentajeResultado=($resultadoEj/$resultadoPres)*100;
                }
    ?>            
                <tr>
                  <td class="font-weight-bold">Resultado Mes</td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoPres);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoEj);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($porcentajeResultado);?></td>
                  <td class="text-right font-weight-bold">-</td>
                 </tr>
                 <?php
                 //ACA SACAMOS LOS DATOS PARA LOS ACUMULADOS
                  $montoPresIngAcumulado=presupuestoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $montoEjIngAcumulado=ejecutadoIngresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $porcentajeIngAcum=0;
                  if($montoPresIngAcumulado>0){
                    $porcentajeIngAcum=($montoEjIngAcumulado/$montoPresIngAcumulado)*100;
                  }
                  $colorPorcentajeIngreso=colorPorcentajeIngreso($porcentajeIngAcum);
                 ?>
                 <tr>
                  <td class="font-weight-bold">
                    <a href="seguimientoPOxCuentaAcum.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">
                      Ing.Acum.
                    </a>
                  </td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoPresIngAcumulado);?></td>
                  <td class="text-right font-weight-bold table-warning"><?=formatNumberInt($montoEjIngAcumulado);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($porcentajeIngAcum);?></td>
                  <td class="text-right font-weight-bold  table-warning">-</td>


                  <?php
                 //ACA SACAMOS LOS DATOS PARA LOS ACUMULADOS
                  $montoPresEgAcumulado=presupuestoEgresosMes($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);
                  $montoEjEgAcumulado=ejecutadoEgresosMesSinRedist($codigosConjunto,$anio,$mes,$codOrganismoX,1,0);

                  /********DIVIDIDO EN 3 LPZ 30 % CBBA 30 % SCZ 40% *******/
                  if($i==1){
                    $montoEjEgAcumulado=$montoEjEgAcumulado+($montoTotalDNADistribuirAcumulado*0.3);
                  }
                  if($i==2){
                    $montoEjEgAcumulado=$montoEjEgAcumulado+($montoTotalDNADistribuirAcumulado*0.3);
                  }
                  if($i==3){
                    $montoEjEgAcumulado=$montoEjEgAcumulado+($montoTotalDNADistribuirAcumulado*0.4);
                  }
                  /******** FIN DIVIDIDO EN 3 LPZ 30 % CBBA 30 % SCZ 40%   *******/


                  $porcentajeEgAcum=0;
                  if($montoPresEgAcumulado>0){
                    $porcentajeEgAcum=($montoEjEgAcumulado/$montoPresEgAcumulado)*100;
                  }
                  $colorPorcentajeEgreso=colorPorcentajeEgreso($porcentajeEgAcum);
                 ?>
                 <tr>
                  <td class="font-weight-bold">
                    <a href="seguimientoPOxCuentaAcum.php?gestion=<?=$gestion;?>&mes=<?=$mes;?>&fondo[]=<?=$codigosConjunto;?>&organismo[]=<?=$codOrganismoX;?>&resumen=" target="_blank">Eg.Acum.
                    </a>  
                  </td>
                  <td class="text-right font-weight-bold table-info"><?=formatNumberInt($montoPresEgAcumulado);?></td>
                  <td class="text-right font-weight-bold table-info"><?=formatNumberInt($montoEjEgAcumulado);?></td>
                  <td class="text-right font-weight-bold <?=$colorPorcentajeEgreso;?>"><?=formatNumberInt($porcentajeEgAcum);?></td>
                  <td class="text-right font-weight-bold table-info">-</td>
                 </tr>

                <?php
                $resultadoPresAcum=$montoPresIngAcumulado-$montoPresEgAcumulado;
                $resultadoEjAcum=$montoEjIngAcumulado-$montoEjEgAcumulado;

                $porcentajeResultado=0;
                if($resultadoPresAcum>0){
                  $porcentajeResultado=($resultadoEjAcum/$resultadoPresAcum)*100;
                }
                ?>            
                <tr>
                  <td class="font-weight-bold">Resultado Acum.</td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoPresAcum);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($resultadoEjAcum);?></td>
                  <td class="text-right font-weight-bold"><?=formatNumberInt($porcentajeResultado);?></td>
                  <td class="text-right font-weight-bold">-</td>
                 </tr>
              </tbody>
            </table>

            <table width="100%">
              <tr>
                <td class="text-center font-weight-bold table-success" colspan="2">
                  Rentabilidad Mes: <?=($montoEjIngConjunto>0)?formatNumberInt(($resultadoEj/$montoEjIngConjunto)*100):0;?> %
                </td>
                <td class="text-center font-weight-bold table-success" colspan="2">
                  Rentabilidad Acum: <?=($montoEjIngAcumulado>0)?formatNumberInt(($resultadoEjAcum/$montoEjIngAcumulado)*100):0;?> %
                </td>
              </tr>
            </table>

          <!--/div-->
        </div>
      </div>
          <?php
          }
          ?>

    </div>  

    <?php
    $montoIngresosTotalGrupos=$montoEjecutadoGrupo1+$montoEjecutadoGrupo2+$montoEjecutadoGrupo3;
    $participacion1=($montoEjecutadoGrupo1/$montoIngresosTotalGrupos)*100;
    $participacion2=($montoEjecutadoGrupo2/$montoIngresosTotalGrupos)*100;
    $participacion3=($montoEjecutadoGrupo3/$montoIngresosTotalGrupos)*100;

    ?>
    <div class="row">
    <table width="100%">
      <tr>
        <th class="text-center font-weight-bold table-success">
          Total Ingresos <?=$nombreOrganismoX;?>
        </th>        
        <th class="text-center font-weight-bold table-success">
          <?=$nombreGrupo1;?>
        </th>        
        <th class="text-center font-weight-bold table-success">
          <?=$nombreGrupo2;?>
        </th>        
        <th class="text-center font-weight-bold table-success">
          <?=$nombreGrupo3;?>
        </th>
      </tr>
      <tr>
        <td class="text-center font-weight-bold table-success">
          <?=formatNumberInt($montoIngresosTotalGrupos);?>
        </td>        
        <td class="text-center font-weight-bold table-success">
          <?=formatNumberInt($participacion1);?> %
        </td>        
        <td class="text-center font-weight-bold table-success">
          <?=formatNumberInt($participacion2);?> %
        </td>
        <td class="text-center font-weight-bold table-success">
          <?=formatNumberInt($participacion3);?> %
        </td>
      </tr>
    </table>
    </div></br></br></br> 
        <?php
        }
        ?>


      </div>
    </div>  
  </div>
</div>
