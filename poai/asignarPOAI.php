<?php
require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';
$dbh = new Conexion();
$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];

$globalAreaPlanificacion=$_SESSION["globalAreaPlanificacion"];
$globalUnidadPlanificacion=$_SESSION["globalUnidadPlanificacion"];
$globalSectorPlanificacion=$_SESSION["globalSectorPlanificacion"];

$globalUnidad=$unidad;
$globalArea=$area;
$globalSector=$sector;
$globalAdmin=$_SESSION["globalAdmin"];
$codigoIndicador=$codigo;
$nombreAreaX="-";
$nombreUnidadX="-";
$codUnidadX=0;
$codAreaX=0;
$nombreAreaX=abrevArea($globalArea);
$nombreUnidadX=abrevUnidad($globalUnidad);
$codUnidadHijosX=buscarHijosUO($codUnidadX);
$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);
$table="actividades_poa";
$moduleName="Asignar POAI";

$sqlUpdate="UPDATE actividades_poa set cod_actividadpadre=0 where cod_actividadpadre is null;";
$stmtUpdate = $dbh->prepare($sqlUpdate);
$stmtUpdate->execute();


$sqlCount="";
$sqlCount="SELECT count(*)as nro_registros FROM actividades_poa where cod_indicador in ($codigoIndicador) and cod_estado=1 and poai=1 and cod_actividadpadre>0 and cod_area='$globalArea' and cod_unidadorganizacional='$globalUnidad' ";
if($globalSector>0){
	$sqlCount.=" and cod_normapriorizada='$globalSector'";
}	
//echo $sqlCount;
$stmtX = $dbh->prepare($sqlCount);
$stmtX->execute();
while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
	$contadorRegistros=$row['nro_registros'];
}
?>
<script>
	numFilas=<?=$contadorRegistros;?>;
	cantidadItems=<?=$contadorRegistros;?>;
	console.log("INICIO CONTADORES: "+cantidadItems);
</script>
<div class="content">
	<div class="container-fluid">
		<form id="form1" class="form-horizontal" action="poai/saveAsignarPOAI.php" method="post">

			<input type="hidden" name="cantidad_filas" id="cantidad_filas" value="<?=$contadorRegistros;?>">
			<input type="hidden" name="codigo_indicador" id="codigo_indicador" value="<?=$codigoIndicador;?>">

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title"><?=$moduleName;?></h4>
					  <h6 class="card-title">Objetivo: <?=$nombreObjetivo;?></h6>
					  <h6 class="card-title">Indicador: <?=$nombreIndicador;?></h6>
					</div>
				</div>
				<div class="card-body ">
					<div class="row">
					  <label class="col-sm-2 col-form-label">Gestion</label>
					  <div class="col-sm-2">
						<div class="form-group">
						  <input class="form-control" type="text" name="gestion" value="<?=$globalNombreGestion;?>" id="gestion" disabled="true" />
						</div>
					  </div>
					  <label class="col-sm-2 col-form-label">Area</label>
					  <div class="col-sm-2">
						<div class="form-group">
						  <input class="form-control" type="text" name="gestion" value="<?=$nombreAreaX;?> - <?=$nombreUnidadX;?>" id="gestion" disabled="true" />
						</div>
					  </div>
					</div>
					<?php
					$sqlLista="SELECT a.codigo, a.orden, a.nombre, a.cod_normapriorizada,
					(SELECT s.codigo from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado, a.cod_norma,
					(SELECT s.codigo from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector, a.producto_esperado, a.cod_tiposeguimiento, a.cod_tiporesultado, a.cod_unidadorganizacional, a.cod_area, a.cod_datoclasificador, a.cod_personal, a.cod_funcion, (select cf.nombre_funcion from cargos_funciones cf where cf.cod_funcion=a.cod_funcion)as funcion
					 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and a.cod_unidadorganizacional in ($globalUnidad) and a.cod_area in ($globalArea) and a.cod_actividadpadre=0 ";
					if($globalSector>0){
						$sqlLista.=" AND cod_normapriorizada='$globalSector' ";
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
					$stmtLista->bindColumn('cod_normapriorizada', $normaPriorizada);
					$stmtLista->bindColumn('sectorpriorizado', $sectorPriorizado);
					$stmtLista->bindColumn('cod_norma', $norma);
					$stmtLista->bindColumn('sector', $sector);
					$stmtLista->bindColumn('producto_esperado', $productoEsperado);
					$stmtLista->bindColumn('cod_tiposeguimiento', $codTipoSeguimiento);
					$stmtLista->bindColumn('cod_tiporesultado', $codTipoResultado);
					$stmtLista->bindColumn('cod_unidadorganizacional', $codUnidad);
					$stmtLista->bindColumn('cod_area', $codArea);
					$stmtLista->bindColumn('cod_datoclasificador',$codDatoClasificador);
					$stmtLista->bindColumn('cod_personal',$codPersonal);
					$stmtLista->bindColumn('cod_funcion',$codFuncion);
					$stmtLista->bindColumn('funcion',$nombreFuncion);
					?>
				    	<?php
	                        $index=1;
							$indexDetalle=1;
							$planificadoTotalGestion=0;
	                      	while ($rowLista = $stmtLista->fetch(PDO::FETCH_BOUND)) {
      							//echo $codUnidad." ----- ".$codArea." ".$norma;
      							$planificadoTotalGestion=planificacionPorActividad($codigo, $codArea, $codUnidad, 12, 1);
	                    ?>
					<div>	           
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-3">
				                    <div class="form-group">
				                    <label for="actividad<?=$index;?>" class="bmd-label-floating">Actividad</label>
		                          	<textarea class="form-control" type="text" name="actividad<?=$index;?>" id="actividad<?=$index;?>" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly="true" rows="4"><?=$nombre;?></textarea>
		                          		<span class="text-primary font-weight-bold">Planificado Gestión: <?=$planificadoTotalGestion;?></span>
	 								</div>
	                          	</div>

								<div class="col-sm-9">
									<fieldset id="fiel<?=$index;?>" style="width:100%;border:0;">
										<table align="center"class="text" cellSpacing="1" cellPadding="2" width="100%" border="0" id="data0">
											<tr>
												<td align="center" colspan="4">
													<a href="#" class="btn btn-just-icon btn-danger btn-link" onclick="addActividadPOAIAsignacion('<?=$codigo;?>','<?=$codUnidad;?>','<?=$codArea;?>','<?=$codigoIndicador;?>','<?=$index;?>');">
	                              						<i class="material-icons">add_circle_outline</i>
											        </a>
												</td>
											</tr>
											<tr class="titulo_tabla" align="center">
												<td width="20%" align="center">Personal</td>
												<td width="65%" align="center">Funcion</td>
												<td width="10%" align="center">Meta(%)</td>
												<td width="5%" align="center">&nbsp;</td>
											</tr>
											<?php
											$sqlListaDetalle="SELECT a.codigo, a.orden, a.nombre, a.cod_personal, a.cod_funcion, (select cf.nombre_funcion from cargos_funciones cf where cf.cod_funcion=a.cod_funcion)as funcion, a.metapoai from actividades_poa a where a.cod_actividadpadre='$codigo' order by a.nombre";
											$stmtListaDetalle = $dbh->prepare($sqlListaDetalle);
											// Ejecutamos
											$stmtListaDetalle->execute();
											// bindColumn
											$stmtListaDetalle->bindColumn('codigo', $codigoDetalle);
											$stmtListaDetalle->bindColumn('orden', $ordenDetalle);
											$stmtListaDetalle->bindColumn('nombre', $nombreDetalle);
											$stmtListaDetalle->bindColumn('cod_personal',$codPersonal);
											$stmtListaDetalle->bindColumn('cod_funcion',$codFuncion);
											$stmtListaDetalle->bindColumn('funcion',$nombreFuncion);
											$stmtListaDetalle->bindColumn('metapoai',$metaPOAI);
					                      	while ($rowListaDetalle = $stmtListaDetalle->fetch(PDO::FETCH_BOUND)) {
											?>
											<div id="div<?=$indexDetalle;?>">
												<tr>
													<td width="20%" align="center">

												    	<input type="hidden" name="codigoPadre<?=$indexDetalle;?>" id="codigoPadre<?=$indexDetalle;?>" value="<?=$codigo;?>">
												    	<input type="hidden" name="codigoPOAI<?=$indexDetalle;?>" id="codigoPOAI<?=$indexDetalle;?>" value="<?=$codigoDetalle;?>">

												        <select class="form-control" name="personal<?=$indexDetalle;?>" id="personal<?=$indexDetalle;?>" data-style="<?=$comboColor;?>" onChange="ajaxFuncionesCargos(this,<?=$indexDetalle;?>);" data-live-search="true" required>
												    	<?php
													  	$sql="SELECT p.codigo, p.nombre, (select c.nombre from cargos c where c.codigo=pd.cod_cargo)as cargo from personal2 p, personal_datosadicionales pd, personal_unidadesorganizacionales pu where p.codigo=pd.cod_personal and p.codigo=pu.cod_personal and pu.cod_unidad='$codUnidad' and pd.cod_cargo in (select i.cod_cargo from indicadores_areascargos i where i.cod_indicador='$codigoIndicador' and i.cod_area='$codArea') order by 1,2";
													  	?>
													  		<option value="">Seleccionar Persona</option>
													  	<?php
													  	$stmt = $dbh->prepare($sql);
														$stmt->execute();
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															$codigoX=$row['codigo'];
															$nombreX=$row['nombre'];
															$nombreCargoX=$row['cargo'];
														?>
															<option value="<?=$codigoX;?>"  <?=($codigoX==$codPersonal)?"selected":"";?> data-subtext="<?=$nombreCargoX;?>" ><?=$nombreX;?></option>	
														<?php	
														}
													  	?>
														</select>
													</td>
													<td width="65%" align="center">
														<div class="form-group" id="divFuncion<?=$indexDetalle;?>">
															<select class="form-control" name="funcion<?=$indexDetalle;?>" id="funcion<?=$indexDetalle;?>" data-live-search="true" required>
															<?php
																$sql="SELECT cf.cod_funcion, cf.nombre_funcion from personal_datosadicionales p, cargos_funciones cf
															where p.cod_personal='$codPersonal' and p.cod_cargo=cf.cod_cargo;";
																?>
																<option value="">Seleccionar Funcion</option>
																<?php
																$stmt = $dbh->prepare($sql);
																$stmt->execute();
																while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
																	$codigoX=$row['cod_funcion'];
																	$nombreX=$row['nombre_funcion'];
																	$nombreXCorte1 = substr($nombreX, 0, 120);
																	$nombreXCorte2 = substr($nombreX, 0, 75)
															?>
																<option value="<?=$codigoX;?>" <?=($codigoX==$codFuncion)?"selected":"";?>  title="<?$nombreXCorte2;?>"><?=$nombreXCorte1;?></option>	
															<?php	
																}
															?>
															</select>
														</div>
													</td>
													<td width="10%" align="center">
														<div class="form-group">
															<input type="number" class="form-control" name="meta<?=$indexDetalle;?>" id="meta<?=$indexDetalle;?>" value="<?=$metaPOAI;?>" required>
														</div>
													</td>
													<td width="5%" align="center">
														<div class="col-sm-1">
															<a href="#" class="btn btn-just-icon btn-danger btn-link" onclick="minusActividadPOAIAsignacion('<?=$indexDetalle;?>');">
											                              <i class="material-icons">remove_circle</i>
											                </a>
											        	</div>
													</td>
												</tr>
											</div>	
									<?php
											$indexDetalle++;
										}
										?>
										</table>
									</fieldset>
		                        </div>
			            	</div>
		            	</div>

							<div class="h-divider">
	        				</div>

	 					</div>
					            <?php
        							$index++;
        						}
        						?>		    

				  	<div class="card-body">
						<button type="submit" class="<?=$button;?>">Guardar</button>
						<a href="#" class="btn" data-toggle="modal" data-target="#myModal">
                        	Cambiar Area
	                    </a>
						<a href="?opcion=listPOA&area=<?=$globalAreaPlanificacion;?>&unidad=<?=$globalUnidadPlanificacion;?>&sector=<?=$globalSectorPlanificacion;?>" class="<?=$buttonCancel;?>">Cancelar</a>
				  	</div>
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
        <h5 class="modal-title" id="exampleModalLabel">Seleccionar Area para asignar POAI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align:center;">
	  	<select class="selectpicker" name="areaModal" id="areaModal" data-style="<?=$comboColor;?>" required>
		  	<option disabled selected value="">Area</option>
		  	<?php
		  	$sqlAreas="SELECT i.cod_indicador, u.codigo as codigoUnidad, u.nombre as nombreUnidad, u.abreviatura as abrevUnidad, a.codigo as codigoArea, a.nombre as nombreArea, a.abreviatura as abrevArea from indicadores_unidadesareas i, unidades_organizacionales u, areas a where i.cod_indicador='$codigoIndicador' and i.cod_area=a.codigo and i.cod_unidadorganizacional=u.codigo";
		  	if($globalAdmin==0){
		  		$sqlAreas.=" and i.cod_unidadorganizacional in ($globalUnidad) and i.cod_area in ($globalArea) ";
		  	}
		  	$sqlAreas.=" order by 3,6";

		  	//echo $sqlAreas;

		  	$stmt = $dbh->prepare($sqlAreas);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$codigoU=$row['codigoUnidad'];
				$nombreU=$row['nombreUnidad'];
				$abrevU=$row['abrevUnidad'];
				$codigoA=$row['codigoArea'];
				$nombreA=$row['nombreArea'];
				$abrevA=$row['abrevArea'];
			?>
			<option value="<?=$codigoU;?>|<?=$codigoA;?>" data-subtext="<?=$nombreU;?>-<?=$nombreA?>"><?=$abrevU;?> - <?=$abrevA;?></option>
			<?php	
			}
		  	?>
	  	</select>	
      </div>
      <div class="modal-footer">
        <button type="button" class="<?=$button;?>" onclick="enviarAsignarPOAI(<?=$codigoIndicador;?>);">Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->
