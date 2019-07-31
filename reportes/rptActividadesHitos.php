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

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$gestion=$_GET["gestion"];
$codAreaX=$_GET["area"];
$codUnidadX=$_GET["unidad_organizacional"];
$hitoX=$_GET["hito"];

$codUnidadArray=implode(",", $codUnidadX);
$codAreaArray=implode(",", $codAreaX);
$codHitoArray=implode(",", $hitoX);

$nameHito=nameHito($codHitoArray);

$codActividad=0;



$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON

$table="actividades_poa";
$moduleName="Detalle de Actividades por Hito";

?>

<div class="content">
	<div class="container-fluid">

		  <form id="form1" class="form-horizontal" action="poa/savePlan.php" method="post">

			<div class="card">
				<div class="card-header card-header-info card-header-text">
					<div class="card-text">
					  <h4 class="card-title small">Detalle de Actividades por Hito</h4>
					  <h6 class="card-title small">Hito: <?=$nameHito;?></h6>
					</div>
				</div>
				<div class="card-body ">
					<?php
					$sqlLista="SELECT distinct(a.codigo)as codigo, a.orden, a.nombre, a.cod_tiporesultado,
					a.cod_unidadorganizacional, a.cod_area, (SELECT h.nombre from hitos h where h.codigo=a.cod_hito)as hito, 
					(SELECT i.nombre from indicadores i where i.codigo=a.cod_indicador)as indicador 
					 from actividades_poa a where  a.cod_estado=1 and a.cod_area in ($codAreaArray) and a.cod_unidadorganizacional in ($codUnidadArray) and a.cod_hito in ($codHitoArray) ";
					if($codActividad>0){
						$sqlLista.=" and a.codigo in ($codActividad) ";
					}
					$sqlLista.=" order by hito, a.cod_unidadorganizacional, a.cod_area, a.nombre";
					
					//echo $sqlLista;
					
					$stmtLista = $dbh->prepare($sqlLista);
					// Ejecutamos
					$stmtLista->execute();

					// bindColumn
					$stmtLista->bindColumn('codigo', $codigo);
					$stmtLista->bindColumn('orden', $orden);
					$stmtLista->bindColumn('nombre', $nombre);
					$stmtLista->bindColumn('cod_tiporesultado', $codTipoDato);
					$stmtLista->bindColumn('cod_unidadorganizacional', $codUnidad);
					$stmtLista->bindColumn('cod_area', $codArea);
					$stmtLista->bindColumn('hito', $nombreHitoActividad);
					$stmtLista->bindColumn('indicador', $nombreIndicadorActividad);

					?>

              		<div class="table-responsive">
		                <table class="table table-condensed" id="tablePaginatorReport">
		                  <thead>
		                    <tr>
		                      <th class="text-center">#</th>
		                      <th class="text-center">Area</th>
		                      <th class="text-center">Indicador</th>
		                      <th class="text-center">Hito</th>
		                      <th class="text-center">Nombre</th>
		                      <th colspan="2" class="text-center">Ene</th>
		                      <th colspan="2" class="text-center">Feb</th>
		                      <th colspan="2" class="text-center">Mar</th>
		                      <th colspan="2" class="text-center">Abr</th>
		                      <th colspan="2" class="text-center">May</th>
		                      <th colspan="2" class="text-center">Jun</th>
		                      <th colspan="2" class="text-center">Jul</th>
		                      <th colspan="2" class="text-center">Ago</th>
		                      <th colspan="2" class="text-center">Sep</th>
		                      <th colspan="2" class="text-center">Oct</th>
		                      <th colspan="2" class="text-center">Nov</th>
		                      <th colspan="2" class="text-center">Dic</th>
		                      <th colspan="2" class="text-center">Total</th>
		                    </tr>
		                    <tr>
		                      <th class="text-center">-</th>
		                      <th class="text-center">-</th>
		                      <th class="text-center">-</th>
		                      <th class="text-center">-</th>
		                      <th class="text-center">-</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
  		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
  		                      <th>P</th>
		                      <th>E</th>
		                      <th>P</th>
		                      <th>E</th>
  		                      <th>Total P</th>
		                      <th>Total E</th>
  		                    </tr>
		                    
		                  </thead>
		                  <tbody>
		                  <?php
		                    $index=1;
		                  	while ($row = $stmtLista->fetch(PDO::FETCH_BOUND)) {
	                  			$abrevArea=abrevArea($codArea);
                          		$abrevUnidad=abrevUnidad($codUnidad);
		                  ?>
		                    <tr>
		                      <td class="text-center"><?=$index;?></td>
		                      <td class="text-center font-weight-bold small"><h6><p class="text-danger"><?=$abrevUnidad;?>-<?=$abrevArea;?></p></h6></td>
		                      <td class="text-left font-weight-bold small"><?=$nombreIndicadorActividad;?></td>
		                      <td class="text-left font-weight-bold small"><?=$nombreHitoActividad;?></td>
		                      <td class="text-left font-weight-bold small"><?=$nombre;?></td>
		                    <?php
		                    	$totalPlani=0;
		                    	$totalEje=0;
		                    	for($i=1;$i<=12;$i++){
		                    		$sqlRecupera="SELECT value_numerico from actividades_poaplanificacion where cod_actividad=$codigo and mes=$i";
		                    		$stmtRecupera = $dbh->prepare($sqlRecupera);
									$stmtRecupera->execute();
									$valueNumero=0;
									while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
										$valueNumero=$rowRec['value_numerico'];
									}

									$sqlRecuperaEj="SELECT value_numerico, descripcion from actividades_poaejecucion where cod_actividad=$codigo and mes=$i";
		                    		$stmtRecupera = $dbh->prepare($sqlRecuperaEj);
									$stmtRecupera->execute();
									$valueEj=0;
									$descEj="";
									while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
										$valueEj=$rowRec['value_numerico'];
										$descEj=$rowRec['descripcion'];
									}
									$totalPlani+=$valueNumero;
									$totalEje+=$valueEj;

									?>
		                    		<td class="text-right small">
		                    			<?=($valueNumero>0)?formatNumberInt($valueNumero):"-";?>
		                    		</td>
		                    		<td class="text-right text-primary small" title="<?=($descEj!='')?$descEj:'';?>" bgcolor="<?=($descEj!='')?'#f28972':'';?>">
		                    			<?=($valueEj>0)?formatNumberInt($valueEj):"-";?>
		                    		</td>
	                    	<?php	
                    			}
		                    ?>
		                    <td class="text-right small">
		                    			<?=($totalPlani>0)?formatNumberInt($totalPlani):"-";?>
                    		</td>
                    		<td class="text-right text-primary small">
                    			<?=($totalEje>0)?formatNumberInt($totalEje):"-";?>
                    		</td>
		                    </tr>
					        <?php
    							$index++;
    						}
					        ?>
		                  </tbody>
		                  <tfoot>
	                        <tr>
	                          <th>-</th>
	                          <th>-</th>
	                          <th>TOTALES</th>
	                        </tr>
	                      </tfoot>
		                </table>
		              </div>
		        </div>
			</div>
		  </form>
	</div>
</div>

<h6>Nota: Las celdas coloreadas contienen observaciones de la ejecucion registrada del mes.</h6>

<script type="text/javascript">
  totalesDetallePOA();
</script>