<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$codigoObjetivo=$codigo_objetivo;
$codigoIndicador=$codigo;

$nombreObjetivo=nameObjetivo($codigoObjetivo);

$globalNombreGestion=$_SESSION["globalNombreGestion"];

$dbh = new Conexion();

$table="indicadores";
$moduleName="Indicador Estrategico";

//RECUPERAMOS LOS DATOS PARA LA EDICION
$stmt = $dbh->prepare("select i.codigo, i.nombre, i.cod_periodo, i.descripcion_calculo, i.lineamiento, 
i.cod_tipocalculo, i.cod_tiporesultado, i.cod_tiporesultadometa, i.cod_clasificador
from indicadores i where i.codigo=:codigo");
$stmt->bindParam(':codigo',$codigoIndicador);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codigoIndicadorX=$row['codigo'];
	$nombreIndicadorX=$row['nombre'];
	$codPeriodoX=$row['cod_periodo'];
	$descripcionCalculoX=$row['descripcion_calculo'];
	$lineamientoX=$row['lineamiento'];
	$codTipoCalculoX=$row['cod_tipocalculo'];
	$codTipoResultadoX=$row['cod_tiporesultado'];
	$codTipoResultadoMetaX=$row['cod_tiporesultadometa'];
	$codClasificador=$row['cod_clasificador'];
}
?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="indicadores/saveEdit.php" method="post">
		  	<input type="hidden" name="cod_objetivo" value="<?=$codigoObjetivo?>">
		  	<input type="hidden" name="cod_indicador" value="<?=$codigoIndicador?>">

			<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Editar <?=$moduleName;?></h4>
				  <h6><?=$nombreObjetivo;?></h6>
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
				<div class="row">
				  <label class="col-sm-2 col-form-label">Nombre</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?=$nombreIndicadorX;?>" />
					</div>
				  </div>
				</div>
				
				<!--div class="row">
				  <label class="col-sm-2 col-form-label">Periodicidad</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="periodo" id="periodo" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM periodos order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codPeriodoX)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div-->

				<div class="row">
				  <label class="col-sm-2 col-form-label">Lineamiento</label>
				  <div class="col-sm-9">
					<div class="form-group">
					  <input class="form-control" type="text" name="lineamiento" id="lineamiento" value="<?=$lineamientoX;?>"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Descripción del Calculo</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="descripcion" id="descripcion" value="<?=$descripcionCalculoX;?>"/>
					</div>
				  </div>
				</div>

				<!--div class="row">
				  <label class="col-sm-2 col-form-label">Tipo de Calculo</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="tipo_calculo" id="tipo_calculo" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM tipos_calculo order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codTipoCalculoX)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div-->

				<div class="row">
				  <label class="col-sm-2 col-form-label">Tipo de Resultado</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="tipo_resultado" id="tipo_resultado" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM tipos_resultado where codigo=1 order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codTipoResultadoX)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Defnir Meta en</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="tipo_resultadometa" id="tipo_resultadometa" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM tipos_resultado where codigo in (1,4) order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codTipoResultadoMetaX)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<!--div class="row">
				  <label class="col-sm-2 col-form-label">Clasificador Relacionado</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="clasificador" id="clasificador" data-style="<?=$comboColor;?>">
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM clasificadores order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codClasificador)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div-->


          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header card-header-text <?=$colorCardDetail?>">
                  <div class="card-text">
                    <p class="card-category">Configuración de propiedad del indicador</p>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead>
						<th>Unidad\Area</th>
                    <?php
					$stmtA = $dbh->prepare("SELECT a.codigo, a.abreviatura FROM areas a, areas_poa ap where a.cod_estado=1 and a.codigo=ap.cod_area ORDER BY 2");
					$stmtA->execute();
					while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
						$codigoA=$rowA['codigo'];
						$abreviaturaA=$rowA['abreviatura'];
					?>
						<th><?=$abreviaturaA?></th>
					<?php	
					}
                    ?>
                    </thead>
                    <tbody>
	                    <?php
						$stmtU = $dbh->prepare("SELECT u.codigo, u.abreviatura FROM unidades_organizacionales u, unidadesorganizacionales_poa up where u.cod_estado=1 and u.codigo=up.cod_unidadorganizacional ORDER BY 2");
						$stmtU->execute();
						while ($rowU = $stmtU->fetch(PDO::FETCH_ASSOC)) {
							$codigoU=$rowU['codigo'];
							$abreviaturaU=$rowU['abreviatura'];
						?>                      
						<tr>
							<td><?=$abreviaturaU?></td>
						<?php	
							$stmtA->execute();
							while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
								$codigoA=$rowA['codigo'];
								$abreviaturaA=$rowA['abreviatura'];

								$sqlRevisa="SELECT count(*)contador from unidadesorganizacionales_areas where cod_unidadorganizacional='$codigoU' and cod_area='$codigoA'";
								$stmtRevisa = $dbh->prepare($sqlRevisa);
								$stmtRevisa->execute();
								while ($rowRevisa = $stmtRevisa->fetch(PDO::FETCH_ASSOC)) {
									$contadorVerifica=$rowRevisa['contador'];
								}

								if($contadorVerifica>0){
									$sqlVeriCheck="SELECT count(*)contador, cod_clasificador from indicadores_unidadesareas iua where cod_indicador='$codigoIndicador' and cod_unidadorganizacional='$codigoU' and cod_area='$codigoA'";
									$stmtVeriCheck = $dbh->prepare($sqlVeriCheck);
									$stmtVeriCheck->execute();
									while ($rowRevisa = $stmtVeriCheck->fetch(PDO::FETCH_ASSOC)) {
										$contadorVerifica=$rowRevisa['contador'];
										$codClasificador=$rowRevisa['cod_clasificador'];
									}

							?>
								<td>
									<div class="form-check">
		                                <label class="form-check-label">
		                                  <input class="form-check-input" type="checkbox" name="propiedad_indicador[]" value="<?=$codigoU?>|<?=$codigoA?>" value="" <?=($contadorVerifica>0)?"checked":"";?> >
		                                  <span class="form-check-sign">
		                                    <span class="check"></span>
		                                  </span>
		                                </label>
		                             </div>

		                             <div class="form-group">
										<select class="selectpicker" data-style="<?=$comboColor;?>" data-width="fit" name="combo|<?=$codigoU?>|<?=$codigoA?>" id="clasificador" required>
											<?php
											$stmt = $dbh->prepare("SELECT codigo, abreviatura FROM clasificadores order by 1");
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['abreviatura'];
											?>
											<option value="<?=$codigoX;?>" <?=($codClasificador==$codigoX)?"selected":"";?> ><?=$nombreX;?></option>
											<?php	
											}
											?>
										</select>
									</div>
								</td>
							<?php	
								}else{
							?>
								<td>
								</td>	
							<?php
								}
							}
						}
	                    ?>
                      	</tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="<?=$button;?>">Guardar</button>
				<a href="?opcion=listObjetivos" class="<?=$buttonCancel;?>">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>