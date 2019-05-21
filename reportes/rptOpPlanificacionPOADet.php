<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalNombreUnidad=$_SESSION["globalNombreUnidad"];
$globalNombreArea=$_SESSION["globalNombreArea"];

$globalUnidadesReports=$_SESSION["globalUnidadesReports"];
$globalFondosReports=$_SESSION["globalFondosReports"];
$globalAreasReports=$_SESSION["globalAreasReports"];
$globalOrganismosReports=$_SESSION["globalOrganismosReports"];

//$var="unid:".$globalUnidadesReports." fondo:".$globalFondosReports." area:".$globalAreasReports." org:".$globalOrganismosReports;

$dbh = new Conexion();

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="reportes/rptPlanificacionPOADetalle.php" method="post" target="_blank">
		  	<input type="hidden" name="cod_objetivo" value="<?=$codigoObjetivo?>">
			<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Reporte Planificacion POA</h4>
				</div>
			  </div>
			  <div class="card-body ">

				<div class="row">
				  <label class="col-sm-2 col-form-label">Gestion</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="gestion" id="gestion" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM gestiones order by 2 desc");
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
				  <label class="col-sm-2 col-form-label">Perspectiva</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker form-control" name="perspectiva[]" id="perspectiva" data-style="select-with-transition" title="Seleccione una opcion" multiple required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM perspectivas order by 2 desc");
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
				  <label class="col-sm-2 col-form-label">Unidad Organizacional</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker form-control" title="Seleccione una opcion" name="unidad_organizacional[]" id="unidad_organizacional" data-style="select-with-transition" multiple required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$sql="SELECT u.codigo, u.nombre FROM unidades_organizacionales u, unidadesorganizacionales_poa up where u.codigo=up.cod_unidadorganizacional ";
			  			$sql.=" and u.codigo in ($globalUnidadesReports) ";
					  	$sql.=" order by 2";
					  	$stmt = $dbh->prepare($sql);
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
				  <label class="col-sm-2 col-form-label">Area</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker form-control" title="Seleccione una opcion" name="areas[]" id="areas" data-style="select-with-transition" multiple="" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT a.codigo, a.nombre, a.abreviatura FROM areas a, areas_poa ap where a.codigo=ap.cod_area and a.codigo in ($globalAreasReports) order by 2");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
							$abreviaturaX=$row['abreviatura'];
						?>
						<option value="<?=$codigoX;?>" data-subtext="<?=$nombreX;?>"><?=$abreviaturaX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				
				


			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="<?=$button;?>">Ver Reporte</button>
				<a href="?opcion=listObjetivos" class="<?=$buttonCancel;?>">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>