<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$codigoObjetivo=$codigo;
$nombreObjetivo=nameObjetivo($codigoObjetivo);

$globalNombreGestion=$_SESSION["globalNombreGestion"];

$dbh = new Conexion();

$table="indicadores";
$moduleName="Indicador Estrategico";

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="indicadores/save.php" method="post">
		  	<input type="hidden" name="cod_objetivo" value="<?=$codigoObjetivo?>">
			<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Registrar <?=$moduleName;?></h4>
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
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>
				<div class="row">
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
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Lineamiento</label>
				  <div class="col-sm-9">
					<div class="form-group">
					  <input class="form-control" type="text" name="lineamiento" id="lineamiento"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Descripción del Calculo</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="descripcion" id="descripcion"/>
					</div>
				  </div>
				</div>

				<div class="row">
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
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Tipo de Resultado</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="tipo_resultado" id="tipo_resultado" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM tipos_resultado order by 1");
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
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Definir Metas en</label>
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
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
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
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>


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
							?>
								<td>
									<div class="form-check">
		                                <label class="form-check-label">
		                                  <input class="form-check-input" type="checkbox" name="propiedad_indicador[]" value="<?=$codigoU?>|<?=$codigoA?>" value="">
		                                  <span class="form-check-sign">
		                                    <span class="check"></span>
		                                  </span>
		                                </label>
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