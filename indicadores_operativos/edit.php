<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();

$table="objetivos";
$moduleName="Editar Objetivo Estrategico";

$globalNombreGestion=$_SESSION["globalNombreGestion"];

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;
$stmt = $dbh->prepare("SELECT codigo, nombre, cod_perspectiva, descripcion FROM $table where codigo=:codigo");
// Ejecutamos
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codigoX=$row['codigo'];
	$nombreX=$row['nombre'];
	$codPerspectivaX=$row['cod_perspectiva'];
	$descripcionX=$row['descripcion'];
}

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="objetivos/saveEdit.php" method="post">
		  	<input type="hidden" name="codigo" id="codigo" value="<?=$codigoX;?>"/>
			<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title"><?=$moduleName;?></h4>
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
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?=$nombreX;?>"/>
					</div>
				  </div>
				</div>
				<div class="row">
				  <label class="col-sm-2 col-form-label">Perspectiva</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" title="Seleccione la perspectiva" name="perspectiva" id="perspectiva" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt2 = $dbh->prepare("SELECT codigo, nombre FROM perspectivas where cod_estado=1");
						$stmt2->execute();
						while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
							$codigoPers=$row2['codigo'];
							$nombrePers=$row2['nombre'];
						?>
						<option value="<?=$codigoPers;?>" <?php echo($codigoPers==$codPerspectivaX)?"selected":"";?> ><?=$nombrePers;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Lineamiento</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="descripcion" id="descripcion" value="<?=$descripcionX;?>"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Hitos</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker form-control" title="Seleccione el Hito" multiple name="hito[]" id="hito" data-style="select-with-transition">
					  	<?php
					  	$stmt3 = $dbh->prepare("SELECT codigo, nombre FROM hitos where cod_estado=1");
						$stmt3->execute();
						while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
							$codigoHito=$row3['codigo'];
							$nombreHito=$row3['nombre'];

							$stmt4 = $dbh->prepare("SELECT cod_hito FROM objetivos_hitos where cod_objetivo=:cod_objetivo and cod_hito=:cod_hito");
							$stmt4->bindParam(':cod_objetivo',$codigoX);
							$stmt4->bindParam(':cod_hito',$codigoHito);
							$stmt4->execute();
							while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
								$codigoHitoX=$row4['cod_hito'];
							}
						?>
						<option value="<?=$codigoHito;?>" <?php echo($codigoHito==$codigoHitoX)?"selected":"";?> ><?=$nombreHito;?></option>
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