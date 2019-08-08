<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

session_start();

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

//echo $globalUnidad." ".$globalArea;

$codigoIndicador=$_GET['codigo'];
$codAreaIndicador=$_GET['area'];
$codUnidadIndicador=$_GET['unidad'];

$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$table="actividades_poa";
$moduleName="Planificacion POAI";

//sacamos la periodicidad el 
$sqlDatosAdi="SELECT i.cod_periodo, p.nombre as periodo from indicadores i, tipos_resultado t, periodos p where i.cod_periodo=p.codigo and t.codigo=i.cod_tiporesultado and i.codigo=:codigoIndicador";
$stmt = $dbh->prepare($sqlDatosAdi);
$stmt->bindParam(':codigoIndicador',$codigoIndicador);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codPeriodo=$row['cod_periodo'];
	$nombrePeriodo=$row['periodo'];
}

$nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$globalUnidad,$globalArea);

?>

<div class="content">
	<div class="container-fluid">

		  <form id="form1" class="form-horizontal" action="savePOAIPlan.php" method="post">
			<input type="hidden" name="cod_indicador" id="cod_indicador" value="<?=$codigoIndicador;?>">

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Registrar <?=$moduleName;?> </h4>
					  <h6 class="card-title">Objetivo: <?=$nombreObjetivo;?></h6>
					  <h6 class="card-title">Indicador: <?=$nombreIndicador;?></h6>
					  <h6 class="card-title">Periodicidad:<?=$nombrePeriodo;?></h6>
					</div>
				</div>
				<div class="card-body ">
					<div class="row">
					  <label class="col-sm-2 col-form-label">Gestion</label>
					  <div class="col-sm-7">
						<div class="form-group">
						  <input class="form-control" type="text" name="gestion" value="<?=$globalNombreGestion;?>" id="gestion" disabled="true" />
						</div>
					  </div>
					</div>

					<?php
					$sqlLista="SELECT a.codigo, a.orden, a.nombre, a.cod_tiporesultado,
					(SELECT c.nombre from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as datoclasificador, a.cod_unidadorganizacional, a.cod_area, a.cod_periodo, a.poai
					 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and (a.cod_actividadpadre>0 or a.cod_actividadpadre=-1000) ";
					if($globalAdmin==0){
						$sqlLista.=" and a.cod_area in ($globalArea) and a.cod_unidadorganizacional in ($globalUnidad) and a.cod_personal='$globalUser'";
					}
					if($codAreaIndicador!=0 && $codUnidadIndicador!=0){
						$sqlLista.=" and a.cod_area in ($codAreaIndicador) and a.cod_unidadorganizacional in ($codUnidadIndicador) ";	
					}
					$sqlLista.=" order by a.cod_unidadorganizacional, a.cod_area, a.nombre";
					
					//echo $sqlLista;
					
					$stmtLista = $dbh->prepare($sqlLista);
					// Ejecutamos
					$stmtLista->execute();

					// bindColumn
					$stmtLista->bindColumn('codigo', $codigo);
					$stmtLista->bindColumn('orden', $orden);
					$stmtLista->bindColumn('nombre', $nombre);
					$stmtLista->bindColumn('cod_tiporesultado', $codTipoDato);
					$stmtLista->bindColumn('datoclasificador', $datoClasificador);
					$stmtLista->bindColumn('cod_unidadorganizacional', $codUnidad);
					$stmtLista->bindColumn('cod_area', $codArea);
					$stmtLista->bindColumn('cod_periodo', $codPeriodo);
					$stmtLista->bindColumn('poai', $poai);

					?>

              		<div class="table-responsive">
		                <table class="table table-condensed table-striped" id="tablePaginatorFixed">
		                  <thead>
		                    <tr>
		                      <th class="text-center">#</th>
		                      <th class="text-center">Area</th>
		                      <th>Nombre</th>
		                      <th>Ene</th>
		                      <th>Feb</th>
		                      <th>Mar</th>
		                      <th>Abr</th>
		                      <th>May</th>
		                      <th>Jun</th>
		                      <th>Jul</th>
		                      <th>Ago</th>
		                      <th>Sep</th>
		                      <th>Oct</th>
		                      <th>Nov</th>
		                      <th>Dic</th>
		                      <th>Total</th>
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
		                      <td class="text-center small"><?=$orden;?></td>
		                      <td class="text-left small"><h6><p class="text-danger"><?=$abrevUnidad;?>-<?=$abrevArea;?></p></h6></td>
		                      <td class="text-left font-weight-bold small"><?=$nombre;?></td>
		                    <?php
		                    if($codPeriodo==0 && $poai==1){
	                    		$sqlRecupera="SELECT value_numerico, fecha_planificacion from actividades_poaplanificacion where cod_actividad='$codigo' and mes=0";
	                    		//echo $sqlRecupera;
	                    		$stmtRecupera = $dbh->prepare($sqlRecupera);
								$stmtRecupera->execute();
								$valueNumero=0;
								$fechaPlanificada="";
								while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
									$valueNumero=$rowRec['value_numerico'];
									$fechaPlanificada=$rowRec['fecha_planificacion'];
								}

		                    ?>
		                    	<td class="text-center" colspan="12">
	                    			<input value="1" type="hidden" name="plan|<?=$codigo;?>|0" required>
	                    			<input class="form-control input-sm" value="<?=$fechaPlanificada;?>"  type="date" name="plandate|<?=$codigo;?>|0" required>
	                    		</td>
	                    		<td><input type="text" class="form-control" value="-" readonly="true"></td>
	                    	<?php
		                    }else{
		                    	$totalPlanificado=0;
		                    	for($i=1;$i<=12;$i++){
		                    		$sqlRecupera="SELECT value_numerico, value_string, value_booleano from actividades_poaplanificacion where cod_actividad=:cod_actividad and mes=:cod_mes";
		                    		$stmtRecupera = $dbh->prepare($sqlRecupera);
									$stmtRecupera->bindParam(':cod_actividad',$codigo);
									$stmtRecupera->bindParam(':cod_mes',$i);
									$stmtRecupera->execute();
									$valueNumero=0;
									$valueString="";
									$valueBooleano=0;
									while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
										$valueNumero=$rowRec['value_numerico'];
										$valueNumero=round($valueNumero,2);
										$totalPlanificado+=$valueNumero;
									}
	                    	?>
	                    		<td>
	                    			<input class="form-control input-sm" value="<?=$valueNumero;?>" min="0" type="number" name="plan|<?=$codigo;?>|<?=$i;?>" id="planificado<?=$index;?>" step="0.001" onChange="calcularTotalPlanificado(<?=$index;?>);" OnKeyUp="calcularTotalPlanificado(<?=$index;?>);" required>
	                    		</td>
	                    	<?php	
                    			}
                    		?>
	                    		<td><input type="text" class="form-control" name="totalPlani<?=$index;?>" id="totalPlani<?=$index;?>" value="<?=formatNumberDec($totalPlanificado);?>"  readonly="true"></td>
                    		<?php
	                    	}
		                    ?>
			                    <input type="hidden" name="tipo_dato|<?=$codigo;?>" id="tipo_dato|<?=$codigo;?>|<?=$i;?>" value="<?=$codTipoDato;?>">
		                    </tr>
					        <?php
    							$index++;
    						}
					        ?>
		                  </tbody>
		                </table>
		              </div>

		        </div>
	            
				  <div class="card-footer ml-auto mr-auto">
					<button type="submit" class="<?=$button;?>">Guardar</button>
					<a href="?opcion=listActividadesPOAI&codigo=<?=$codigoIndicador;?>&area=0&unidad=0" class="<?=$buttonCancel;?>">Cancelar</a>
				  </div>
			</div>
		  </form>
	</div>
</div>