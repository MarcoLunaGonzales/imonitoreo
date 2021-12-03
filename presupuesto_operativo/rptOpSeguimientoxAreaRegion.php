<script>
function enviarFormRepSegPO(id){
	//alert(id);
	if(id==1){
		form1.action="presupuesto_operativo/rptSeguimientoxAreaRegion.php";
	}
	if(id==2){
		form1.action="presupuesto_operativo/rptSeguimientoxAreaRegion2.php";
	}
	if(id==3){
		form1.action="presupuesto_operativo/rptSeguimientoxAreaRegion3.php";
	}
	form1.submit();
}	

</script>

<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';


$dbh = new Conexion();


$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalNombreUnidad=$_SESSION["globalNombreUnidad"];
$globalNombreArea=$_SESSION["globalNombreArea"];

$globalUnidadesReports=$_SESSION["globalUnidadesReports"];
$globalFondosReports=$_SESSION["globalFondosReports"];
$globalAreasReports=$_SESSION["globalAreasReports"];
$globalOrganismosReports=$_SESSION["globalOrganismosReports"];

//VALORES POR DEFAULT
$codGestionDefault=gestionDefaultReport();
$codMesDefault=mesDefaultReport();

//OBTENEMOS LAS AREAS DE SERVICIOS
$codAreaServicios="";
$codAreaServicios=obtieneValorConfig(22);
$arrayAreaServicios = explode(",", $codAreaServicios);

/*for($i=0; $i<count($arrayAreaServicios); $i++){
	  echo $arrayAreaServicios[$i];
	  echo "<br>";
}*/
?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="presupuesto_operativo/rptSeguimientoxAreaRegion.php" method="get" target="_blank">
		  	<!---->
		  	<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Seguimiento al PO por Area y Regional</h4>
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
						<option value="<?=$codigoX;?>"  <?=($codigoX==$codGestionDefault)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Mes</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione una opcion" name="mes" id="mes" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM meses order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>"  <?=($codigoX==$codMesDefault)?"selected":"";?> ><?=$nombreX;?></option>
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
					<?php
				  	$sql="SELECT codigo, nombre, cod_area FROM po_organismos ";
			  		$sql.=" where codigo in ($globalOrganismosReports) ";
				  	$sql.=" order by 2";
				  	$stmt = $dbh->prepare($sql);
					$stmt->execute();
					?>
					  <select class="selectpicker form-control" name="organismos[]" id="organismos" data-style="select-with-transition" title="Seleccione una opcion" multiple data-actions-box="true" data-live-search="true" required>
					  	<option disabled selected value=""></option>
					  	<?php
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
							$codAreaX=$row['cod_area'];
						?>
						<option value="<?=$codigoX;?>" <?=(in_array($codAreaX, $arrayAreaServicios))?"selected":"";?>  ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>


			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="button" id="boton1" class="<?=$button;?>" onClick="javascript:enviarFormRepSegPO(1);">Ver Reporte 1</button>
				<button type="button" id="boton2" class="<?=$button;?>" onClick="javascript:enviarFormRepSegPO(2);">Ver Reporte 2</button>
				<button type="button" id="boton3" class="<?=$button;?>" onClick="javascript:enviarFormRepSegPO(3);">Ver Reporte 3</button>
				<a href="?opcion=listObjetivos" class="<?=$buttonCancel;?>">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>