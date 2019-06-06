<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];


$globalAreaEjecucion=$_SESSION["globalAreaEjecucion"];
$globalUnidadEjecucion=$_SESSION["globalUnidadEjecucion"];


$codigoIndicador=$codigo;
$areaIndicador=$area;
$unidadIndicador=$unidad;
$nombreIndicador=nameIndicador($codigoIndicador);

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
$stmt->execute();
$codigoIndicadorPON=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoIndicadorPON=$row['valor_configuracion'];
}

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

//SACAMOS LA TABLA RELACIONADA
$sqlClasificador="SELECT c.codigo, c.tabla FROM indicadores i, clasificadores c where i.codigo='$codigoIndicador' and i.cod_clasificador=c.codigo";
$stmtClasificador = $dbh->prepare($sqlClasificador);
$stmtClasificador->execute();
$nombreTablaClasificador="";
$codigoClasificador=0;
while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
	$codigoClasificador=$rowClasificador['codigo'];
  	$nombreTablaClasificador=$rowClasificador['tabla'];
}
if($nombreTablaClasificador==""){$nombreTablaClasificador="areas";}//ESTO PARA QUE NO DE ERROR



//SACAMOS LAS FECHAS DE REGISTRO DEL MES EN CURSO
$fechaActual=date("Y-m-d");
$sqlFechaEjecucion="SELECT f.mes, f.anio, DATE_FORMAT(f.fecha_fin, '%d/%m')fecha_fin from fechas_registroejecucion f 
where f.fecha_inicio<='$fechaActual' and f.fecha_fin>='$fechaActual'";
//echo $sqlFechaEjecucion;
$stmt = $dbh->prepare($sqlFechaEjecucion);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codMesX=$row['mes'];
  $codAnioX=$row['anio'];
  $fechaFinRegistroX=$row['fecha_fin'];
}
$nombreMesX=nameMes($codMesX);
//FIN FECHAS

$table="actividades_poa";
$moduleName="Registro de Ejecucion POA";

?>

<div class="content">
	<div class="container-fluid">

		  <form id="form1" enctype="multipart/form-data" class="form-horizontal" action="poa/saveEjecucion.php" method="post">
			<input type="hidden" name="cod_indicador" id="cod_indicador" value="<?=$codigoIndicador;?>">
			
			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title"><?=$moduleName;?> - Mes Ejecucion: <?=$codMesX;?> Fecha Limite: <?=$fechaFinRegistroX;?></h4>
					  <h6 class="card-title">Indicador: <?=$nombreIndicador;?></h6>
					</div>
					<!--a href="#" class="<?=$buttonCeleste;?> btn-round" data-toggle="modal" data-target="#myModal"  title="Filtrar">
                        		<i class="material-icons">filter_list</i>
            		</a-->
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
					$sqlLista="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada, (SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma, a.cod_tiporesultado, a.cod_unidadorganizacional, a.cod_area, (SELECT c.nombre from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as datoclasificador,
					(SELECT c.codigo from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as codigodetalleclasificador
					 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 ";
					$sqlLista.=" and a.cod_area in ($globalAreaEjecucion) and a.cod_unidadorganizacional in ($globalUnidadEjecucion)";
					if($areaIndicador!=0){
						$sqlLista.=" and a.cod_area in ($areaIndicador) ";
					}
					if($unidadIndicador!=0){
					$sqlLista.=" and a.cod_unidadorganizacional in ($unidadIndicador) ";
					} 
					$sqlLista.=" order by a.cod_unidadorganizacional, a.cod_area, a.orden";
					$stmtLista = $dbh->prepare($sqlLista);
					// Ejecutamos
					$stmtLista->execute();

					// bindColumn
					$stmtLista->bindColumn('codigo', $codigo);
					$stmtLista->bindColumn('orden', $orden);
					$stmtLista->bindColumn('nombre', $nombre);
					$stmtLista->bindColumn('normapriorizada', $normaPriorizada);
					$stmtLista->bindColumn('norma', $norma);
					$stmtLista->bindColumn('cod_tiporesultado', $codTipoDato);
					$stmtLista->bindColumn('cod_unidadorganizacional', $codUnidad);
					$stmtLista->bindColumn('cod_area', $codArea);
					$stmtLista->bindColumn('datoclasificador', $datoclasificador);
					$stmtLista->bindColumn('codigodetalleclasificador', $codigodetalleclasificador);

					?>

              		<div class="table-responsive" >
		                <table class="table table-condensed" id="tablePaginatorFixed" data-page-length='100'>
		                  <thead>
		                    <tr>
		                      <th class="text-center"></th>
		                      <th></th>
		                      <th></th>
		                      <th></th>
		                      <th></th>
		                      <th class="text-center table-success" colspan="2">Ejecutado <?=$nombreMesX;?></th>
		                      <th class="text-center"></th>
		                      <th class="text-center"></th>
		                    </tr>
		                    <tr>
		                      <th class="text-center">#</th>
		                      <th>Area</th>
		                      <th>Actividad</th>
		                      <th>Clasificador</th>
		                      <th class="text-center table-warning">Plan</th>
		                      <th class="text-center table-success">Sist.</th>
		                      <th class="text-center table-success" width="130px">POA</th>
		                      <th class="text-center" width="250px">Descripcion<br>Logro</th>
		                      <th class="text-center">Archivo<br>Soporte</th>
		                    </tr>
		                  </thead>
		                  <tbody>
		                  <?php
		                    $index=1;
		                    $totalPlanificado=0;
		                    $totalEjecutado=0;
		                  	while ($row = $stmtLista->fetch(PDO::FETCH_BOUND)) {
                  				$abrevArea=abrevArea($codArea);
                          		$abrevUnidad=abrevUnidad($codUnidad);

	                          $cadenaNormas="";
	                          $cadenaN="";
	                          $cadenaNP="";
	                          if($normaPriorizada!=""){
	                            $cadenaNP.="NP:".$normaPriorizada;
	                          }
	                          
	                          if($norma!=""){
	                            $cadenaN.="N:".$norma;
	                          }

	                          if($normaPriorizada!="" || $norma!=""){
	                            $cadenaNormas="(".$cadenaNP."-".$cadenaN.")";
	                          }

		                  ?>
		                    <tr>
		                      <td class="text-center"><?=$index;?></td>
		                      <td class="text-center"><?=$abrevArea."-".$abrevUnidad;?></td>
		                      <td class="text-left small"><?=$nombre;?><?=$cadenaNormas;?></td>
		                      <td class="text-left small"><?=$datoclasificador;?>(<?=$codigodetalleclasificador;?>)</td>
		                    <?php
	                    	for($i=$codMesX;$i<=$codMesX;$i++){
	                    		$sqlRecupera="SELECT value_numerico from actividades_poaplanificacion where cod_actividad=:cod_actividad and mes=:cod_mes";
	                    		$stmtRecupera = $dbh->prepare($sqlRecupera);
								$stmtRecupera->bindParam(':cod_actividad',$codigo);
								$stmtRecupera->bindParam(':cod_mes',$i);
								$stmtRecupera->execute();
								$valueNumero=0;
								while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
									$valueNumero=$rowRec['value_numerico'];
								}

								$totalPlanificado+=$valueNumero;

								$valorEj=0;
								$descripcionEj="";
								$sqlRecupera="SELECT a.value_numerico, a.descripcion from actividades_poaejecucion a where a.cod_actividad='$codigo' and a.mes='$codMesX'";
	                          	$stmtRecupera = $dbh->prepare($sqlRecupera);
	                          	$stmtRecupera->execute();
	                          	$estadoPonEj="";
	                          	while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
	                            	$valorEj=$rowRec['value_numerico'];
		                            $descripcionEj=$rowRec['descripcion'];
	                          	}
	                          	if($valorEj==0){
									if($codigoClasificador!=0){
										$valorEj=obtieneEjecucionSistema($codMesX,$codAnioX,$codigoClasificador,$codUnidad,$codArea,$codigoIndicador,$codigodetalleclasificador);
									}
	                          	}
	                          	$totalEjecutado+=$valorEj;
	                    	?>
	                    		<td class="text-center table-warning font-weight-bold">
	                    			<?=formatNumberDec($valueNumero);?>
	                    		</td>
	                    		<td class="text-center table-success font-weight-bold">
	                    			<?=($valorEj==0)?"-":formatNumberDec($valorEj);?>
	                    			<input type="hidden" name="ejsistema|<?=$codigo;?>|<?=$i;?>" value="<?=$valorEj;?>">
	                    		</td>
	                    		<td class="text-center table-success"> 
	                    			<input class="form-control" min="0" type="number" name="plan|<?=$codigo;?>|<?=$i;?>" id="ejecutado" value="<?=$valorEj;?>" onChange="calcularTotalEj();" OnKeyUp="calcularTotalEj();" step="0.01" required>
	                    		</td>
	                    		<td class="text-center">
	                    			<textarea class="form-control input-sm" type="text" name="explicacion|<?=$codigo;?>|<?=$i;?>" rows="1"><?=$descripcionEj;?></textarea>
	                    		</td>
	                    		<td class="text-center">
	                    			<input class="form-control-file" type="file" name="file|<?=$codigo;?>|<?=$i;?>">
	                    		</td>
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
		                  <tfooter>
		                  	<tr>
		                  		<th class="text-right" colspan="4">TOTALES</th>
		                  		<th class="text-right"><?=formatNumberDec($totalPlanificado);?></th>
		                  		<th></th>
		                  		<th><input type="text" class="form-control input-sm" name="totalEj" id="totalEj" value="<?=formatNumberDec($totalEjecutado);?>" readonly="true"></th>
		                  		<th></th>
		                  	</tr>
		                  </tfooter>
		                </table>
		              </div>

		        </div>
	            
				  <div class="card-footer ml-auto mr-auto">
					<button type="submit" class="<?=$button;?>">Guardar</button>
					<a href="?opcion=listActividadesPOAEjecucion&codigo=<?=$codigoIndicador;?>&codigoPON=<?=$codigoIndicadorPON?>&area=<?=$globalAreaEjecucion?>&unidad=<?=$globalUnidadEjecucion?>" class="<?=$buttonCancel;?>">Cancelar</a>
				  </div>
			</div>
		  </form>
	</div>
</div>

<!-- Classic Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filtrar Area/Unidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align:center;">
      <select class="selectpicker" name="unidadModal" id="unidadModal" data-style="<?=$comboColor;?>" required>
        <option disabled selected value="">Unidad</option>
        <?php
        $sqlAreas="SELECT i.cod_indicador, u.codigo as codigoUnidad, u.nombre as nombreUnidad, u.abreviatura as abrevUnidad from indicadores_unidadesareas i, unidades_organizacionales u where i.cod_indicador='$codigoIndicador' and i.cod_unidadorganizacional=u.codigo";
        if($globalAdmin==0){
          $sqlAreas.=" and i.cod_unidadorganizacional in ($globalUnidad)";
        }
        $sqlAreas.=" GROUP BY u.codigo order by 3";
        $stmt = $dbh->prepare($sqlAreas);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigoU=$row['codigoUnidad'];
        $nombreU=$row['nombreUnidad'];
        $abrevU=$row['abrevUnidad'];
      ?>
      <option value="<?=$codigoU;?>" data-subtext="<?=$nombreU;?>"><?=$abrevU;?></option>
      <?php 
      }
        ?>
      </select>

      <select class="selectpicker" name="areaModal" id="areaModal" data-style="<?=$comboColor;?>" required>
        <option disabled selected value="">Area</option>
        <?php
        $sqlAreas="SELECT i.cod_indicador, a.codigo as codigoArea, a.nombre as nombreArea, a.abreviatura as abrevArea from indicadores_unidadesareas i, areas a where i.cod_indicador='$codigoIndicador' and i.cod_area=a.codigo ";
        if($globalAdmin==0){
          $sqlAreas.=" and i.cod_area in ($globalArea) ";
        }
        $sqlAreas.=" GROUP BY a.codigo order by 3";
        $stmt = $dbh->prepare($sqlAreas);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigoA=$row['codigoArea'];
        $nombreA=$row['nombreArea'];
        $abrevA=$row['abrevArea'];
      ?>
      <option value="<?=$codigoA;?>" data-subtext="<?=$nombreA?>"><?=$abrevA;?></option>
      <?php 
      }
        ?>
      </select> 
      </div>
      <div class="modal-footer">
        <button type="button" class="<?=$button;?>" onclick="enviarFiltroAreaUnidadPOA3(<?=$codigoIndicador;?>,<?=$codigoIndicadorPON;?>);">Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->