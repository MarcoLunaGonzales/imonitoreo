<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$codigoObjetivo=$codigo;
$nombreObjetivo=nameObjetivo($codigoObjetivo);

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalNombreUnidad=$_SESSION["globalNombreUnidad"];
$globalNombreArea=$_SESSION["globalNombreArea"];

$dbh = new Conexion();

$table="indicadores";
$moduleName="Indicador Operativo";

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="indicadores_operativos/save.php" method="post">
		  	<input type="hidden" name="cod_objetivo" value="<?=$codigoObjetivo?>">
			<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Registrar <?=$moduleName;?></h4>
				  <p class="card-category"><?=$nombreObjetivo;?></p>
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
				  <label class="col-sm-2 col-form-label">Unidad Organizacional</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input type="hidden" name="cod_unidadorganizacional" value="<?=$globalUnidad;?>">
					  <input class="form-control" type="text" name="unidad" value="<?=$globalNombreUnidad;?>" id="gestion" disabled="true" />
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Area</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input type="hidden" name="cod_area" value="<?=$globalArea;?>">
					  <input class="form-control" type="text" name="unidad" value="<?=$globalNombreArea;?>" id="gestion" disabled="true" />
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