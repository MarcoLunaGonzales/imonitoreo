<?php

require_once 'conexion.php';
$dbh = new Conexion();

$table="estados_pon";
$moduleName="Estados PON";

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="estados_pon/save.php" method="post">
			<div class="card ">
			  <div class="card-header card-header-rose card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Registrar <?=$moduleName;?></h4>
				</div>
			  </div>
			  <div class="card-body ">
				<div class="row">
				  <label class="col-sm-2 col-form-label">Nombre</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>
				<div class="row">
				  <label class="col-sm-2 col-form-label">Abreviatura</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="abreviatura" id="abreviatura" required="true" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Porcentaje</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="number" name="porcentaje" id="porcentaje" required="true" min="0" step="0.1" />
					</div>
				  </div>
				</div>

			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="btn">Guardar</button>
				<a href="?opcion=listEstadosPON" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>