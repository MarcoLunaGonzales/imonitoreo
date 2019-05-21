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


$codigoIndicador=$codigo;
$nombreIndicador=nameIndicador($codigoIndicador);

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

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
$moduleName="Registro de Ejecucion POAI";

?>

<div class="content">
	<div class="container-fluid">

		  <form id="form1" enctype="multipart/form-data" class="form-horizontal" action="poa/savePOAIEjecucion.php" method="post">
			<input type="hidden" name="cod_indicador" id="cod_indicador" value="<?=$codigoIndicador;?>">
			
			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title"><?=$moduleName;?></h4>
					  <h4 class="card-title text-danger">Mes Ejecucion: <?=$codMesX;?> Fecha Limite: <?=$fechaFinRegistroX;?></h4>
					  <h6 class="card-title">Indicador: <?=$nombreIndicador;?></h6>
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
					$sqlLista="SELECT a.codigo, a.orden, a.nombre, a.cod_tiporesultado, a.cod_unidadorganizacional, a.cod_area, (SELECT c.nombre from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as datoclasificador,
					(SELECT c.codigo from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as codigodetalleclasificador, IFNULL(a.cod_periodo,-1)as cod_periodo, a.poai
					 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 ";
					if($globalAdmin==0){
						$sqlLista.=" and a.cod_area='$globalArea' and a.cod_unidadorganizacional='$globalUnidad' and a.cod_personal='$globalUser' ";
					}
					$sqlLista.=" order by a.cod_unidadorganizacional, a.cod_area, a.orden";
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
					$stmtLista->bindColumn('datoclasificador', $datoclasificador);
					$stmtLista->bindColumn('codigodetalleclasificador', $codigodetalleclasificador);
					$stmtLista->bindColumn('cod_periodo', $codPeriodo);
					$stmtLista->bindColumn('poai', $poai);

					?>

              		<div class="table-responsive">
		                <table class="table table-bordered">
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
		                      <th class="text-center table-success">POA</th>
		                      <th class="text-center">Descripcion<br>Logro</th>
		                      <th class="text-center">Archivo<br>Soporte</th>
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
		                      <td class="text-center"><?=$orden;?></td>
		                      <td class="text-center"><?=$abrevArea."-".$abrevUnidad;?></td>
		                      <td class="text-left small"><?=$nombre;?></td>
		                      <td class="text-left small"><?=$datoclasificador;?>(<?=$codigodetalleclasificador;?>)</td>
		                    <?php
	                    	for($i=$codMesX;$i<=$codMesX;$i++){
	                    		if($codPeriodo==0){
                					$codMesRecup=0;
	                    		}else{
	                    			$codMesRecup=$codMesX;
	                    		}
	                    		$sqlRecupera="SELECT value_numerico, fecha_planificacion from actividades_poaplanificacion where cod_actividad='$codigo' and mes='$codMesRecup'";
	                    		//echo $sqlRecupera;
	                    		$stmtRecupera = $dbh->prepare($sqlRecupera);
								$stmtRecupera->execute();
								$valueNumero=0;
								$fechaPlanificacion="";
								while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
									$valueNumero=$rowRec['value_numerico'];
									$fechaPlanificacion=$rowRec['fecha_planificacion'];
								}
								$valueEjecutadoSistema=0;
								if($codigoClasificador!=0){
									$valueEjecutadoSistema=obtieneEjecucionSistema($codMesX,$codAnioX,$codigoClasificador,$codUnidad,$codArea,$codigoIndicador,$codigodetalleclasificador);
								}
								if($codPeriodo==0){
									$nombreEstadoPOA=nameEstadoPOA($valueNumero);
		                    	?>
		                    		<td class="text-center table-warning font-weight-bold">
		                    			<?=$nombreEstadoPOA;?>
		                    			<?=$fechaPlanificacion;?>
		                    		</td>
	                    		<?php
								}else{
	                    		?>
	                			<td class="text-center table-warning font-weight-bold">
	                    			<?=formatNumberDec($valueNumero);?>
	                    		</td>
								<?php
								}
								?>
	                    		<td class="text-center table-success font-weight-bold">
	                    			<?=($valueEjecutadoSistema==0)?"-":formatNumberDec($valueEjecutadoSistema);?>
	                    			<input type="hidden" name="ejsistema|<?=$codigo;?>|<?=$i;?>" value="<?=$valueEjecutadoSistema;?>">
	                    		</td>
	                    		
	                    		<?php
								if($codPeriodo==0){
	                    		?>
	                    		<td class="text-center table-success"> 
	                    			<select class="form-control" name="plan|<?=$codigo;?>|<?=$i;?>" data-style="<?=$comboColor;?>">
									  	<option value="">Estado Ejecucion</option>
									  	<?php
									  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM estados_actividadespoa order by 1");
										$stmt->execute();
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											$codigoX=$row['codigo'];
											$nombreX=$row['nombre'];
										?>
											<option value="<?=$codigoX;?>"><?=$nombreX;?></option>	
										<?php	
										}
									  	?>
									</select>
	                    			<input class="form-control input-sm" min="0" type="date" name="date|<?=$codigo;?>|<?=$i;?>" required>
	                    			
	                    		</td>
	                    		<?php
								}else{
	                    		?>
								<td class="text-center table-success"> 
	                    			<input class="form-control input-sm" min="0" type="number" name="plan|<?=$codigo;?>|<?=$i;?>" value="<?=$valueEjecutadoSistema;?>" required>
	                    		</td>
								<?php
								}
								?>
	                    		<td class="text-center">
	                    			<input class="form-control input-sm" type="text" name="explicacion|<?=$codigo;?>|<?=$i;?>">
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
		                </table>
		              </div>

		        </div>
	            
				  <div class="card-footer ml-auto mr-auto">
					<button type="submit" class="<?=$button;?>">Guardar</button>
					<a href="?opcion=listActividadesPOAEjecucion&codigo=<?=$codigoIndicador;?>" class="<?=$buttonCancel;?>">Cancelar</a>
				  </div>
			</div>
		  </form>
	</div>
</div>