<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$table="cargos_funciones";
$moduleName="Funcion por Cargo";

$codFuncion=$codigo;

//RECIBIMOS LAS VARIABLES
$stmt = $dbh->prepare("SELECT cod_cargo, cod_funcion, nombre_funcion, peso FROM $table where cod_funcion=:codigo");
// Ejecutamos
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codCargoX=$row['cod_cargo'];
	$codFuncionX=$row['cod_funcion'];
	$nombreFuncionX=$row['nombre_funcion'];
	$pesoX=$row['peso'];
}
$nameCargo=nameCargo($codCargoX);
?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="cargos/saveEditFuncionCargo.php" method="post">
			<div class="card ">
			  <div class="card-header card-header-rose card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Editar <?=$moduleName;?></h4>
				  <h6 class="card-title">Cargo: <?=$nameCargo;?></h6>
				</div>
			  </div>
			  <div class="card-body ">
				<div class="row">
				  <label class="col-sm-2 col-form-label">Nombre</label>
				  <div class="col-sm-7">
					<div class="form-group">
						<input type="hidden" name="codigo_cargo" value="<?=$codCargoX;?>">
						<input type="hidden" name="codigo_funcion" value="<?=$codFuncion;?>">
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?=$nombreFuncionX;?>"/>
					</div>
				  </div>
				</div>
				<div class="row">
				  <label class="col-sm-2 col-form-label">Peso</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="number" name="peso" id="peso" required="true" value="<?=$pesoX?>" step="0.1"/>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="btn">Guardar</button>
				<a href="?opcion=listCargos" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>