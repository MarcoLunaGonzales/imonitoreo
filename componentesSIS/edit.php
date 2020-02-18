<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();

$codigo_proy=$_SESSION["globalProyecto"];
$nombre_proyecto=obtener_nombre_proyecto($codigo_proy);
$table="componentessis";
$moduleName="Editar Actividad - Proyecto ".$nombre_proyecto;

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;
$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura, cod_padre, nivel, partida, cod_personal FROM $table where codigo=:codigo");
// Ejecutamos
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codigoX=$row['codigo'];
	$nombreX=$row['nombre'];
	$abreviaturaX=$row['abreviatura'];
	$codPadreX=$row['cod_padre'];
	$nivelX=$row['nivel'];
	$partidaX=$row['partida'];
	$codPersonalX=$row['cod_personal'];
}

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="componentesSIS/saveEdit.php" method="post">
			<input type="hidden" name="codigo" id="codigo" value="<?=$codigoX;?>"/>
			<div class="card ">
			  <div class="card-header <?=$colorCard;?> card-header-text">
				<div class="card-text">
				  <h4 class="card-title"><?=$moduleName;?></h4>
				</div>
			  </div>
			  <div class="card-body ">

				<div class="row">
				  <label class="col-sm-2 col-form-label">Codigo</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="abreviatura" id="abreviatura" required="true" value="<?=$abreviaturaX?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Nombre</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" value="<?=$nombreX;?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Partida</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="partida" id="partida" value="<?=$partidaX;?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Nivel</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="number" min="1" max="3" name="nivel" id="nivel" value="<?=$nivelX;?>" required="true"/>
					</div>
				  </div>
				</div>


				<div class="row">
				  <label class="col-sm-2 col-form-label">Padre</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="padre" id="padre" data-style="<?=$comboColor;?>">
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, abreviatura FROM componentessis where nivel in (1,2) order by 1");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['abreviatura'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codPadreX)?"selected":"";?> ><?=$nombreX;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Responsable</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="cod_personal" id="cod_personal" data-style="<?=$comboColor;?>">
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM personal2 p, personal_datosadicionales pd where p.codigo=pd.cod_personal and pd.cod_estado in (1) order by 2");
						$stmt->execute();
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$codigoX=$row['codigo'];
							$nombreX=$row['nombre'];
						?>
						<option value="<?=$codigoX;?>" <?=($codigoX==$codPersonalX)?"selected":"";?> ><?=$nombreX;?></option>
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
				<a href="?opcion=listComponentesSIS" class="<?=$buttonCancel;?>">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>