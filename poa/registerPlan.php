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

$codigoIndicador=$_GET['codigo'];
$areaIndicador=$_GET['area'];
$unidadIndicador=$_GET['unidad'];
$sectorIndicador=$_GET['sector'];

$nameSector="-";
if($sectorIndicador!=0){
  $nameSector=nameSectorEconomico($sectorIndicador);
}


$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);

$dbh = new Conexion();


$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON

$codigoIndicadorPON=obtenerCodigoPON();


//SACAMOS EL ESTADO DEL POA PARA LA GESTION
$codEstadoPOAGestion=estadoPOAGestion($globalGestion);

//echo "estado poa: ".$codEstadoPOAGestion;

$table="actividades_poa";
$moduleName="Planificacion de Actividades";

//sacamos la periodicidad el 
$sqlDatosAdi="SELECT i.cod_periodo, p.nombre as periodo from indicadores i, tipos_resultado t, periodos p where i.cod_periodo=p.codigo and t.codigo=i.cod_tiporesultado and i.codigo=:codigoIndicador";
$stmt = $dbh->prepare($sqlDatosAdi);
$stmt->bindParam(':codigoIndicador',$codigoIndicador);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codPeriodo=$row['cod_periodo'];
	$nombrePeriodo=$row['periodo'];
}

//SACAMOS LA TABLA RELACIONADA
$sqlClasificador="SELECT c.tabla FROM indicadores i, clasificadores c where i.codigo='$codigoIndicador' and i.cod_clasificador=c.codigo";
$stmtClasificador = $dbh->prepare($sqlClasificador);
$stmtClasificador->execute();
$nombreTablaClasificador="";
while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
  $nombreTablaClasificador=$rowClasificador['tabla'];
}
if($nombreTablaClasificador==""){$nombreTablaClasificador="areas";}//ESTO PARA QUE NO DE ERROR

?>

<div class="content">
	<div class="container-fluid">

		  <form id="form1" class="form-horizontal" action="savePlan.php" method="post">
			<input type="hidden" name="cod_indicador" id="cod_indicador" value="<?=$codigoIndicador;?>">

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Registrar <?=$moduleName;?> </h4>
					  <h6 class="card-title">Objetivo: <?=$nombreObjetivo;?></h6>
					  <h6 class="card-title">Indicador: <?=$nombreIndicador;?></h6>
					  <h6 class="card-title">Sector: <?=$nameSector;?></h6>
					</div>
				</div>
				<span class="text-center font-weight-bold text-primary">Nota: Los montos de ejecucion se visualizan debajo de la caja de texto en color morado.</span>
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
					$sqlLista="SELECT a.codigo, a.orden, a.nombre, a.producto_esperado,
					(SELECT c.nombre from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as datoclasificador, a.cod_unidadorganizacional, a.cod_area
					 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1";
					if($globalAdmin==0){
						$sqlLista.=" and a.cod_area in ($globalArea) and a.cod_unidadorganizacional in ($globalUnidad) ";
					}
					if($areaIndicador!=0 && $unidadIndicador!=0){
						$sqlLista.=" and a.cod_area in ($areaIndicador) and a.cod_unidadorganizacional in ($unidadIndicador) ";	
					}
					if($codEstadoPOAGestion==2 || $codEstadoPOAGestion==3){
						$sqlLista.=" and a.actividad_extra=1 ";
					}
					if($sectorIndicador!=0){
						$sqlLista.=" and a.cod_normapriorizada in ($sectorIndicador) ";
					}
					$sqlLista.=" order by a.cod_unidadorganizacional, a.cod_area, a.nombre ";
					
					//echo $sqlLista;

					$stmtLista = $dbh->prepare($sqlLista);
					// Ejecutamos
					$stmtLista->execute();

					// bindColumn
					$stmtLista->bindColumn('codigo', $codigo);
					$stmtLista->bindColumn('orden', $orden);
					$stmtLista->bindColumn('nombre', $nombre);
					$stmtLista->bindColumn('producto_esperado', $productoEsperado);
					$stmtLista->bindColumn('datoclasificador', $datoClasificador);
					$stmtLista->bindColumn('cod_unidadorganizacional', $codUnidad);
					$stmtLista->bindColumn('cod_area', $codArea);

					$anchoColumna="100px";
	
					?>


              		<div class="table-responsive">
		                <table class="table table-striped table-condensed" id="tablePaginatorFixed" width="100%">
		                  <thead>
		                    <tr>
		                      <th class="text-center">#</th>
		                      <th class="text-center">Area</th>
		                      <th>Nombre</th>
		                      <th>Prod.Esperado</th>
		                      <th width="<?=$anchoColumna;?>">Ene</th>
		                      <th width="<?=$anchoColumna;?>">Feb</th>
		                      <th width="<?=$anchoColumna;?>">Mar</th>
		                      <th width="<?=$anchoColumna;?>">Abr</th>
		                      <th width="<?=$anchoColumna;?>">May</th>
		                      <th width="<?=$anchoColumna;?>">Jun</th>
		                      <th width="<?=$anchoColumna;?>">Jul</th>
		                      <th width="<?=$anchoColumna;?>">Ago</th>
		                      <th width="<?=$anchoColumna;?>">Sep</th>
		                      <th width="<?=$anchoColumna;?>">Oct</th>
		                      <th width="<?=$anchoColumna;?>">Nov</th>
		                      <th width="<?=$anchoColumna;?>">Dic</th>
		                      <th width="<?=$anchoColumna;?>">Total</th>
		                    </tr>
		                  </thead>
		                  <tbody>
		                  <?php
		                    $index=1;

		                    $sumaVerticalEne=0;
		                    $sumaVerticalFeb=0;
		                    $sumaVerticalMar=0;
		                    $sumaVerticalAbr=0;
		                    $sumaVerticalMay=0;
		                    $sumaVerticalJun=0;
		                    $sumaVerticalJul=0;
		                    $sumaVerticalAgo=0;
		                    $sumaVerticalSep=0;
		                    $sumaVerticalOct=0;
		                    $sumaVerticalNov=0;
		                    $sumaVerticalDic=0;

		                    $sumaTotalTotal=0;

		                  	while ($row = $stmtLista->fetch(PDO::FETCH_BOUND)) {
	                  			$abrevArea=abrevArea($codArea);
                          		$abrevUnidad=abrevUnidad($codUnidad);
		                  ?>
		                    <tr>
		                      <td class="text-center"><?=$index;?></td>
		                      <td class="text-center font-weight-bold"><h6><p class="text-danger"><?=$abrevUnidad;?>-<?=$abrevArea;?></p></h6></td>
		                      <td class="text-left font-weight-bold small"><?=$nombre;?></td>
		                      <td class="text-left small"><?=$productoEsperado;?></td>
		                    <?php
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
									$valueString=$rowRec['value_string'];
									$valueBooleano=$rowRec['value_booleano'];
								}
								$totalPlanificado=$totalPlanificado+$valueNumero;
								$sumaTotalTotal+=$valueNumero;

								if($i==1){$sumaVerticalEne+=$valueNumero;}
								if($i==2){$sumaVerticalFeb+=$valueNumero;}
								if($i==3){$sumaVerticalMar+=$valueNumero;}
								if($i==4){$sumaVerticalAbr+=$valueNumero;}
								if($i==5){$sumaVerticalMay+=$valueNumero;}
								if($i==6){$sumaVerticalJun+=$valueNumero;}
								if($i==7){$sumaVerticalJul+=$valueNumero;}
								if($i==8){$sumaVerticalAgo+=$valueNumero;}
								if($i==9){$sumaVerticalSep+=$valueNumero;}
								if($i==10){$sumaVerticalOct+=$valueNumero;}
								if($i==11){$sumaVerticalNov+=$valueNumero;}
								if($i==12){$sumaVerticalDic+=$valueNumero;}

								//OBTENEMOS LA EJECUCION
								$valorEj=0;
								$descripcionEj="";
								$sqlRecupera="SELECT a.value_numerico, a.descripcion from actividades_poaejecucion a where a.cod_actividad='$codigo' and a.mes='$i'";
	                          	$stmtRecupera = $dbh->prepare($sqlRecupera);
	                          	$stmtRecupera->execute();
	                          	$estadoPonEj="";
	                          	while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
	                            	$valorEj=$rowRec['value_numerico'];
		                            $descripcionEj=$rowRec['descripcion'];
	                          	}
	                          	//FIN EJECUCION
	                          	$mesHexa=dechex($i);
	                    	?>
	                    		<td>
	                    			<input class="form-control" value="<?=$valueNumero;?>" min="0" type="number" name="plan|<?=$codigo;?>|<?=$i;?>" id="planificado<?=$index;?>|mes<?=$mesHexa;?>" onChange="calcularTotalPlanificado('<?=$index;?>','<?=$mesHexa;?>');" OnKeyUp="calcularTotalPlanificado('<?=$index;?>','<?=$mesHexa;?>');" step="0.01" required>
	                    			<span class="text-center font-weight-bold text-primary" title="<?=$descripcionEj?>"><?=($valorEj)>0?formatNumberDec($valorEj):"-";?></span>
	                    		</td>
	                    	<?php	
	                    	}
		                    ?>
		                    <input type="hidden" name="tipo_dato|<?=$codigo;?>" id="tipo_dato|<?=$codigo;?>|<?=$mesHexa;?>" value="<?=$codTipoDato;?>">
		                    	<td><input type="text" class="form-control" name="totalPlani<?=$index;?>" id="totalPlani<?=$index;?>" value="<?=formatNumberDec($totalPlanificado);?>" readonly="true"></td>
		                    </tr>
					        <?php
    							$index++;
    						}
					        ?>
		                  </tbody>
		                  <tfoot>
		                  	<tr>
		                      <th class="text-center">-</th>
		                      <th class="text-center">-</th>
		                      <th>-</th>
		                      <th>TOTALES</th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes1" id="totalMes1" value="<?=formatNumberDec($sumaVerticalEne);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes2" id="totalMes2" value="<?=formatNumberDec($sumaVerticalFeb);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes3" id="totalMes3" value="<?=formatNumberDec($sumaVerticalMar);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes4" id="totalMes4" value="<?=formatNumberDec($sumaVerticalAbr);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes5" id="totalMes5" value="<?=formatNumberDec($sumaVerticalMay);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes6" id="totalMes6" value="<?=formatNumberDec($sumaVerticalJun);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes7" id="totalMes7" value="<?=formatNumberDec($sumaVerticalJul);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes8" id="totalMes8" value="<?=formatNumberDec($sumaVerticalAgo);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMes9" id="totalMes9" value="<?=formatNumberDec($sumaVerticalSep);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMesa" id="totalMesa" value="<?=formatNumberDec($sumaVerticalOct);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMesb" id="totalMesb" value="<?=formatNumberDec($sumaVerticalNov);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalMesc" id="totalMesc" value="<?=formatNumberDec($sumaVerticalDic);?>" readonly="true"></th>
		                      <th width="<?=$anchoColumna;?>"><input type="text" class="form-control" name="totalTotal" id="totalTotal" value="<?=formatNumberDec($sumaTotalTotal);?>" readonly="true"></th>
		                    </tr>
		                  </tfoot>
		                </table>
		              </div>

		        </div>
	            
				  <div class="card-footer ml-auto mr-auto">
					<button type="submit" class="<?=$button;?>">Guardar</button>
					<a href="#" onclick="javascript:window.close();" class="<?=$buttonCancel;?>">Cancelar</a>
				  </div>
			</div>

		  </form>
	</div>
</div>

