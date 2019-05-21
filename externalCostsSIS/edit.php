<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$table="external_costs";
$moduleName="Editar External Cost";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;
$stmt = $dbh->prepare("SELECT codigo, nombre, nombre_en, abreviatura FROM $table where codigo=:codigo");
// Ejecutamos
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codigoX=$row['codigo'];
	$nombreX=$row['nombre'];
	$nombreEnX=$row['nombre_en'];
	$abreviaturaX=$row['abreviatura'];
}

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="externalCostsSIS/saveEdit.php" method="post">
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
					  <input class="form-control" type="text" name="abreviatura" id="abreviatura" required="true" value="<?=$abreviaturaX;?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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
				  <label class="col-sm-2 col-form-label">Name</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="name" id="name" required="true" value="<?=$nombreEnX;?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>


			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="<?=$button;?>">Guardar</button>
				<a href="?opcion=listPerspectivas" class="<?=$buttonCancel;?>">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>