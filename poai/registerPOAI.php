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
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];
$codigoIndicador=$codigo;

$nombreAreaX="-";
$nombreUnidadX="-";
$codUnidadX=0;
$codAreaX=0;


$areaIndicador=$area;
$unidadIndicador=$unidad;
$actividadIndicador=$actividad;
$vistaIndicador=$vista;


$codUnidadX=$unidad;
$codAreaX=$area;


$nameUnidad="";
$nameArea="";
$nameSector="-";
$nameUnidad=abrevUnidad($unidadIndicador);
$nameArea=abrevArea($areaIndicador);

$nombreActividadPadre=nameActividad($actividadIndicador);


$codUnidadHijosX=buscarHijosUO($codUnidadX);
$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);
$table="actividades_poa";
$moduleName="Actividades POAI";
$sqlCount="";
if($globalAdmin==1){
	$sqlCount="SELECT count(*)as nro_registros FROM actividades_poa where cod_indicador in ($codigoIndicador) and cod_estado=1 and poai=1 and (cod_actividadpadre>0 or cod_actividadpadre=-1000)";	
}else{
	$sqlCount="SELECT count(*)as nro_registros FROM actividades_poa where cod_indicador in ($codigoIndicador) and cod_area in ($globalArea) and cod_unidadorganizacional in ($globalUnidad) and cod_estado=1 and poai=1 and cod_actividadpadre='$actividadIndicador' ";
	if($vistaIndicador==1){
		$sqlCount.=" and cod_personal='$globalUser' ";		
	}	
}
//echo $sqlCount;
$stmtX = $dbh->prepare($sqlCount);
$stmtX->execute();
while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
	$contadorRegistros=$row['nro_registros'];
}
$nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$codUnidadX,$codAreaX);
?>
<script>
	numFilas=<?=$contadorRegistros;?>;
	cantidadItems=<?=$contadorRegistros;?>;
	//verificaModalArea();
</script>
<div class="content">
	<div class="container-fluid">
		<div style="overflow-y:scroll;">
		<form id="form1" class="form-horizontal" action="poai/savePOAI.php" method="post">
			<input type="hidden" name="cod_indicador" id="cod_indicador" value="<?=$codigoIndicador?>">
			<input type="hidden" name="cantidad_filas" id="cantidad_filas" value="<?=$contadorRegistros;?>">
			<input type="hidden" name="codigoUnidad" id="codigoUnidad" value="<?=$codUnidadX;?>">
			<input type="hidden" name="codigoArea" id="codigoArea" value="<?=$codAreaX;?>">
			<input type="hidden" name="codigoActividad" id="codigoActividad" value="<?=$actividadIndicador;?>">
			<input type="hidden" name="vista" id="vista" value="<?=$vistaIndicador;?>">

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-icon">
                    	<i class="material-icons">assignment</i>
                  	</div>

					  <h4 class="card-title">Registrar <?=$moduleName;?> - <span class="text-danger font-weight-bold"><?=$nombreActividadPadre;?></span></h4>
					  <h6 class="card-title">Objetivo</span>: <?=$nombreObjetivo;?> - Indicador: <?=$nombreIndicador;?></h6>
	                    <h6 class="card-title">Unidad: <span class="text-danger"><?=$nameUnidad;?></span> - Area: <span class="text-danger"><?=$nameArea;?></span> - Sector: <span class="text-danger"><?=$nameSector;?></span></h6>
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
					(SELECT s.codigo from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector, a.producto_esperado, a.cod_tiposeguimiento, a.cod_tiporesultado, a.cod_unidadorganizacional, a.cod_area, a.cod_datoclasificador, a.cod_tipoactividad, a.cod_periodo, a.cod_funcion, a.cod_actividadpadre, a.cod_personal
					 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and a.cod_unidadorganizacional in ($codUnidadX) and a.cod_area in ($codAreaX) and a.poai=1 and cod_actividadpadre='$actividadIndicador'  ";
					if($vistaIndicador==1){
						$sqlLista.=" and cod_personal='$globalUser' ";
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
					$stmtLista->bindColumn('cod_tipoactividad',$codTipoActividad);
					$stmtLista->bindColumn('cod_periodo',$codPeriodo);
					$stmtLista->bindColumn('cod_funcion',$codFuncion);
					$stmtLista->bindColumn('cod_actividadpadre',$codPadreX);
					$stmtLista->bindColumn('cod_personal',$codPersonalX);
					?>
					<fieldset id="fiel" style="width:100%;border:0;">
						<button type="button" name="add" value="add" class="btn btn-danger btn-round btn-fab" onClick="addActividadPOAI(this,<?=$codigoIndicador;?>,<?=$unidadIndicador;?>,<?=$areaIndicador;?>,<?=$actividadIndicador;?>,<?=$vistaIndicador;?>)" accesskey="a">
		                              <i class="material-icons">add</i>
		                </button>						
					        	<?php
			                        $index=1;
			                      	while ($rowLista = $stmtLista->fetch(PDO::FETCH_BOUND)) {
			                      		$nombre=trim($nombre);
              							//echo $codUnidad." ----- ".$codArea." ".$norma;
			                    ?>
						<div id="div<?=$index;?>">	

                        	<input type="hidden" name="codigo<?=$index;?>" id="codigo<?=$index;?>" value="<?=$codigo;?>">

		                    <div class="col-md-12">
								<div class="row">
									<!--div class="col-sm-3">
				                        <div class="form-group">
				                        <select class="selectpicker form-control form-control-sm" name="norma_priorizada<?=$index;?>" id="norma_priorizada<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true">
									  		<option value="">Sector</option>
										  	<?php
										  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM sectores where cod_estado=1 order by 2");
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['nombre'];
											?>
													<option value="<?=$codigoX;?>" <?=($codigoX==$normaPriorizada)?"selected":"";?>  ><?=$nombreX;?></option>	
											<?php	
											}
										  	?>
										</select>
										</div>
			                        </div>
			                        <div class="col-sm-3">
			                        	<div class="form-group">
								        <select class="selectpicker form-control form-control-sm" name="norma<?=$index;?>" id="norma<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true">
										  	<option value="">Norma</option>
										  	<?php
										  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM sectores where cod_estado=1 order by 2");
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['nombre'];
											?>
											<optgroup label="<?=$nombreX;?>">
											<?php
											  	$stmtY = $dbh->prepare("SELECT n.codigo, n.nombre, n.abreviatura FROM normas n where n.cod_sector='$codigoX' and n.cod_estado=1 order by 2");
												$stmtY->execute();
												while ($rowY = $stmtY->fetch(PDO::FETCH_ASSOC)) {
													$codigoY=$rowY['codigo'];
													$nombreY=$rowY['nombre'];
													$nombreY=cutString($nombreY,80);
													$abreviaturaY=$rowY['abreviatura'];
											?>
													<option value="<?=$codigoY;?>" data-subtext="<?=$nombreY?>" <?=($codigoY==$normaPriorizada)?"selected":"";?>  ><?=$abreviaturaY;?></option>	
											<?php
												}
											?>
											</optgroup>
											<?php	
											}
										  	?>
										</select>
										</div>
		                          	</div-->

			                        <div class="col-sm-6">
			                        	<div class="form-group">
								        <select class="selectpicker form-control form-control-sm" name="cod_padre<?=$index;?>" id="cod_padre<?=$index;?>" data-style="<?=$comboColor2;?>" data-live-search="true">
										  	<option value="">Actividad Padre</option>
										  	<?php
										  	$stmt = $dbh->prepare("SELECT a.codigo, a.nombre from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and a.cod_unidadorganizacional in ($codUnidadX) and a.cod_area in ($codAreaX) and a.cod_actividadpadre=0 order by a.orden");
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['nombre'];
											?>
												<option value="<?=$codigoX;?>" <?=($codigoX==$codPadreX)?"selected":"";?>  data-content="<span class='text-dark small font-weight-bold'><?=$nombreX;?></span>" ><?=$nombreX;?></option>	
											<?php
											}
										  	?>
										</select>
										</div>
		                          	</div>

		                          	<div class="col-sm-3">
		                          		<div class="form-group">
	                          			<label for="producto_esperado<?=$index;?>" class="bmd-label-floating">Producto Esperado</label>
			                          	<input class="form-control" value="<?=$productoEsperado?>" type="text" name="producto_esperado<?=$index;?>" id="producto_esperado<?=$index;?>"/>
		                          		</div>
		                          	</div>	
		                          	<div class="col-sm-3">
			                        	<div class="form-group">
								        <select class="selectpicker form-control form-control-sm" name="clasificador<?=$index;?>" id="clasificador<?=$index;?>" data-style="<?=$comboColor;?>" data-width="200px">
										  	<option disabled selected value="">Clasificador</option>
										  	<?php
										  	if($nombreTablaClasificador!="" && $nombreTablaClasificador!="clientes"){
											  	$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM $nombreTablaClasificador where cod_estado=1 order by 2");
												$stmt->execute();
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$codigoX=$row['codigo'];
													$nombreX=$row['nombre'];
													$abrevX=$row['abreviatura'];
											?>
													<option value="<?=$codigoX;?>" <?=($codigoX==$codDatoClasificador)?"selected":"";?> ><?=$abrevX."-".$nombreX;?></option>	
											<?php
												}
										  	}
										  	if($nombreTablaClasificador=="clientes"){
											  	$sqlClasificadorX="SELECT c.codigo, c.nombre, u.nombre as unidad from clientes c, unidades_organizacionales u where c.cod_unidad=u.codigo and c.cod_unidad in ($codUnidadHijosX) order by 2;";
											  	$stmt = $dbh->prepare($sqlClasificadorX);
												$stmt->execute();
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$codigoX=$row['codigo'];
													$nombreX=$row['nombre'];
													$nombreUnidad=$row['unidad'];
											?>
													<option value="<?=$codigoX;?>" data-subtext="<?=$nombreUnidad;?>" <?=($codigoX==$codDatoClasificador)?"selected":"";?> ><?=$nombreX;?></option>	
											<?php
												}
										  	}
										  	?>
										</select>
										</div>
		                          	</div>
	                      		</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-sm-5">
					                    <div class="form-group">
					                    <label for="actividad<?=$index;?>" class="bmd-label-floating">Actividad</label>			
			                          	<textarea class="form-control" type="text" name="actividad<?=$index;?>" id="actividad<?=$index;?>" required="true" ><?=$nombre;?></textarea>	
		 								</div>
		                          	</div>

		                          	<div class="col-sm-3">
								    	<div class="form-group">
								        <select class="selectpicker form-control form-control-sm" name="cod_personal<?=$index;?>" id="cod_personal<?=$index;?>" data-style="<?=$comboColor2;?>" data-live-search="true">
										  	<option value="">Personal</option>
										  	<?php
										  	$sql="SELECT p.codigo, p.nombre, (select c.nombre from cargos c where c.codigo=pd.cod_cargo)as cargo from personal2 p, personal_datosadicionales pd, personal_unidadesorganizacionales pu where p.codigo=pd.cod_personal and p.codigo=pu.cod_personal and pu.cod_unidad='$unidadIndicador' and pd.cod_cargo in (select i.cod_cargo from indicadores_areascargos i where i.cod_indicador='$codigoIndicador' and i.cod_area='$areaIndicador') and p.codigo in ($codPersonalX) order by 1,2";
										  	//echo $sql;
										  	$stmt = $dbh->prepare($sql);
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['nombre'];
											?>
												<option value="<?=$codigoX;?>" <?=($codigoX==$codPersonalX)?"selected":"";?>  data-content="<span class='text-dark small font-weight-bold'><?=$nombreX;?></span>" selected><?=$nombreX;?></option>	
											<?php
											}
										  	?>
										</select>
										</div>
								  	</div>

                          		  	<div class="col-sm-3">
										<div class="form-group">
											<label for="tipo_seguimiento<?=$index;?>" class="bmd-label-floating">Unidad de Medida</label>
											<input class="form-control" type="text" value="<?=$codTipoSeguimiento;?>" name="tipo_seguimiento<?=$index;?>" id="tipo_seguimiento<?=$index;?>"/>
										</div>
									</div>
									<div class="col-sm-1">
										<button rel="tooltip" class="btn btn-just-icon btn-danger btn-link" onclick="minusActividad('<?=$index;?>');">
						                              <i class="material-icons">remove_circle</i>
						                </button>
					            	</div>
				            	</div>
			            	</div>
			            	<div class="col-md-12">
								<div class="row">	
									<div class="col-sm-3">
								        <div class="form-group">
											<select class="selectpicker form-control form-control-sm" name="tipo_actividad<?=$index;?>" id="tipo_actividad<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true">
											  	<option value="">Tipo de Actividad</option>
											  	<?php
											  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM tipos_actividadpoa where cod_estado=1 order by 2");
												$stmt->execute();
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$codigoX=$row['codigo'];
													$nombreX=$row['nombre'];
												?>
													<option value="<?=$codigoX;?>"  <?=($codigoX==$codTipoActividad)?"selected":"";?>><?=$nombreX;?></option>	
												<?php	
												}
											  	?>
											</select>
										</div>
								    </div>
									<div class="col-sm-3">
								        <div class="form-group">
											<select class="selectpicker form-control form-control-sm" name="periodo<?=$index;?>" id="periodo<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true">
											  	<option value="">Planificación</option>
											  	<?php
											  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM periodos where codigo in (0,1) order by 2");
												$stmt->execute();
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$codigoX=$row['codigo'];
													$nombreX=$row['nombre'];
												?>
													<option value="<?=$codigoX;?>" <?=($codigoX==$codPeriodo)?"selected":"";?>><?=$nombreX;?></option>	
												<?php	
												}
											  	?>
											</select>
										</div>
								    </div>
									<div class="col-sm-6">
								        <div class="form-group">
											<select class="selectpicker form-control form-control-sm" name="funcion<?=$index;?>" id="funcion<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true">
											  	<option value="">Funcion Asociada a la Actividad</option>
											  	<?php
											  	$stmt = $dbh->prepare("SELECT cf.cod_funcion, cf.nombre_funcion from personal_datosadicionales p, cargos_funciones cf where p.cod_personal='$globalUser' and p.cod_cargo=cf.cod_cargo;");
												$stmt->execute();
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$codigoX=$row['cod_funcion'];
													$nombreX=$row['nombre_funcion'];
													$nombreX=substr($nombreX, 0,100)."...";
												?>
													<option value="<?=$codigoX;?>"  <?=($codigoX==$codFuncion)?"selected":"";?> data-content="<span class='small font-weight-bold'><?=$nombreX;?></span>" ><?=$nombreX;?></option>	
												<?php	
												}
											  	?>
											</select>
										</div>
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
		            </fieldset>


				  	<div class="card-body">
						<button type="submit" class="<?=$button;?>">Guardar</button>
						<a href="#" class="btn" data-toggle="modal" data-target="#myModal">
                        	Cambiar Area
	                    </a>
						<a href="?opcion=listPOAI&area=<?=$area;?>&unidad=<?=$unidad;?>" class="<?=$buttonCancel;?>">Cancelar</a>
				  	</div>
				</div>
			</div>	
		</form>
		</div>
	</div>
</div>

