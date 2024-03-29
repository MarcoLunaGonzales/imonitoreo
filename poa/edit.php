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

$codigoIndicador=$codigoIndicador;
$codigoActividad=$codigoActividad;
$areaUnidad=$areaUnidad;

$nombreAreaX="-";
$nombreUnidadX="-";
$codUnidadX=0;
$codAreaX=0;
if($areaUnidad!=0){
	list($codUnidadX,$codAreaX)=explode("|", $areaUnidad);
	$nombreAreaX=abrevArea($codAreaX);
	$nombreUnidadX=abrevUnidad($codUnidadX);
}

$codUnidadHijosX=buscarHijosUO($codUnidadX);

$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);

//SACAMOS EL ESTADO DEL POA PARA LA GESTION
$codEstadoPOAGestion=estadoPOAGestion($globalGestion);

$table="actividades_poa";
$moduleName="Actividad POA";

$sqlCount="";
if($globalAdmin==1){
	$sqlCount="SELECT count(*)as nro_registros FROM actividades_poa where cod_indicador='$codigoIndicador' and cod_estado=1";	
}else{
	$sqlCount="SELECT count(*)as nro_registros FROM actividades_poa where cod_indicador='$codigoIndicador' and cod_area in ($globalArea) and cod_unidadorganizacional in ($globalUnidad) and cod_estado=1";	
}
$stmtX = $dbh->prepare($sqlCount);
$stmtX->execute();
while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
	$contadorRegistros=$row['nro_registros'];
}

?>
<script>
	numFilas=<?=$contadorRegistros;?>;
	cantidadItems=<?=$contadorRegistros;?>;

	//verificaModalArea();
</script>

<div class="content">
	<div class="container-fluid">

		<form id="form1" class="form-horizontal" action="poa/saveGroup.php" method="post">
			<input type="hidden" name="cod_indicador" id="cod_indicador" value="<?=$codigoIndicador?>">
			<input type="hidden" name="cantidad_filas" id="cantidad_filas" value="<?=$contadorRegistros;?>">
			<input type="hidden" name="codigoUnidad" id="codigoUnidad" value="<?=$codUnidadX;?>">
			<input type="hidden" name="codigoArea" id="codigoArea" value="<?=$codAreaX;?>">


			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Editar <?=$moduleName;?></h4>
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
					(SELECT s.codigo from normas n, sectores_economicos s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado, a.cod_norma,
					(SELECT s.codigo from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector, a.producto_esperado, a.cod_tiposeguimiento, a.cod_tiporesultado, a.cod_unidadorganizacional, a.cod_area, a.cod_datoclasificador, a.clave_indicador, a.observaciones, a.cod_hito
					 from actividades_poa a where a.codigo='$codigoActividad' and a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and a.cod_unidadorganizacional='$codUnidadX' and a.cod_area='$codAreaX' ";
					if($codEstadoPOAGestion==3){
						$sqlLista.=" and a.actividad_extra=1 ";
					}
					$sqlLista.=" order by a.cod_unidadorganizacional, a.cod_area, a.orden";
					//echo $sql;
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
					$stmtLista->bindColumn('clave_indicador',$claveIndicador);
					$stmtLista->bindColumn('observaciones',$observaciones);
					$stmtLista->bindColumn('cod_hito',$codHito);
					?>
					<fieldset id="fiel" style="width:100%;border:0;">						
					        	<?php
			                        $index=1;
			                      	while ($rowLista = $stmtLista->fetch(PDO::FETCH_BOUND)) {
              							//echo $codUnidad." ----- ".$codArea." ".$norma;
              							$nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$codUnidad,$codArea);

			                    ?>
						<div id="div<?=$index;?>">	
	                    
		                    <div class="col-md-12">
								<div class="row">
									<div class="col-sm-3">
				                        <div class="form-group">
			                        	<input type="hidden" name="codigo<?=$index;?>" id="codigo<?=$index;?>" value="<?=$codigo;?>">
				                        <select class="selectpicker form-control form-control-sm" name="norma_priorizada<?=$index;?>" id="norma_priorizada<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true">
									  		<option value="">Sector</option>
										  	<?php
										  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM sectores_economicos where cod_estado=1 order by 2");
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
													<option value="<?=$codigoY;?>" data-subtext="<?=$nombreY?>" <?=($codigoY==$norma)?"selected":"";?>  ><?=$abreviaturaY;?></option>	
											<?php
												}
											?>
											</optgroup>
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
								        <select class="selectpicker form-control form-control-sm" name="clasificador<?=$index;?>" id="clasificador<?=$index;?>" data-style="<?=$comboColor;?>" data-width="200px" data-live-search="true">
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
											  	$sqlClasificadorX="SELECT c.codigo, c.nombre, u.nombre as unidad from clientes c, unidades_organizacionales u where c.cod_unidad=u.codigo  order by 2;";
											  	$stmt = $dbh->prepare($sqlClasificadorX);
												$stmt->execute();
												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$codigoX=$row['codigo'];
													$nombreX=$row['nombre'];
													$nombreUnidad=$row['unidad'];

											?>
													<option value="<?=$codigoX;?>" data-subtext="<?=$nombreUnidad;?>(<?=$codigoX;?>)" <?=($codigoX==$codDatoClasificador)?"selected":"";?> ><?=$nombreX;?></option>	
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
									<div class="col-sm-6">
					                    <div class="form-group">
					                    <label for="actividad<?=$index;?>" class="bmd-label-floating">Actividad</label>			
			                          	<textarea class="form-control" type="text" name="actividad<?=$index;?>" id="actividad<?=$index;?>" required="true" style="text-transform: uppercase;"><?=$nombre;?></textarea>	
		 								</div>
		                          	</div>

		                          	<div class="col-sm-3">
			                        	<div class="form-group">
								        <select class="selectpicker form-control form-control-sm" name="clave_indicador<?=$index;?>" id="clave_indicador<?=$index;?>" data-style="<?=$comboColor;?>">
										  	<option value="">CMI</option>
											<option value="0" <?=($claveIndicador==0)?"selected":"";?>>No</option>
											<option value="1" <?=($claveIndicador==1)?"selected":"";?>>Si</option>
										</select>
										</div>
		                          	</div>

		                          	
                          		  	<div class="col-sm-3">
										<div class="form-group">
											<label for="tipo_seguimiento<?=$index;?>" class="bmd-label-floating">Unidad de Medida</label>
											<input class="form-control" type="text" value="<?=$codTipoSeguimiento;?>" name="tipo_seguimiento<?=$index;?>" id="tipo_seguimiento<?=$index;?>"/>
										</div>
									</div>

									<!--div class="col-sm-1">
										<button rel="tooltip" class="btn btn-just-icon btn-danger btn-link" onclick="minusActividad('<?=$index;?>');">
						                              <i class="material-icons">remove_circle</i>
						                </button>
					            	</div-->
				            	</div>
			            	</div>

			            	<div class="col-md-12">
								<div class="row">
									<div class="col-sm-6">
					                    <div class="form-group">
					                    <label for="observaciones<?=$index;?>" class="bmd-label-floating">Observaciones</label>			
			                          	<input class="form-control" type="text" name="observaciones<?=$index;?>" id="observaciones<?=$index;?>" style="text-transform: uppercase;" value="<?=$observaciones;?>">	
		 								</div>
		                          	</div>

									<div class="col-sm-4">
			                        	<div class="form-group">
								        <select class="selectpicker form-control form-control-sm" name="hito<?=$index;?>" id="hito<?=$index;?>" data-style="<?=$comboColor;?>">
										  	<option disabled selected value="">Hito</option>
										  	<?php
										  	$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM hitos where cod_estado=1 order by 2");
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['nombre'];
												$nombreX=substr($nombreX,0,40);
												$abrevX=$row['abreviatura'];
											?>
											<option value="<?=$codigoX;?>" <?=($codigoX==$codHito)?"selected":"";?> ><?=$nombreX;?></option>	
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
						<a href="?opcion=listActividadesPOA&codigo=<?=$codigoIndicador;?>&area=0&unidad=0" class="<?=$buttonCancel;?>">Cancelar</a>

				  	</div>

				</div>
			</div>	
		</form>
	</div>
</div>
