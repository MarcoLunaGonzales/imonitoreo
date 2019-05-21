<?php

require_once 'conexion.php';
$dbh = new Conexion();

$moduleName="Editar Fecha Registro de Ejecucion POA";

//RECIBIMOS LAS VARIABLES
$codAnio=$anio;
$codMes=$mes;

$stmt = $dbh->prepare("SELECT fecha_inicio, fecha_fin FROM fechas_registroejecucion where anio=:anio and mes=:mes");
// Ejecutamos
$stmt->bindParam(':anio',$codAnio);
$stmt->bindParam(':mes',$codMes);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$fechaInicio=$row['fecha_inicio'];
	$fechaFin=$row['fecha_fin'];
}

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="utilitarios/saveEditFechaEjecucion.php" method="post">
			<input type="hidden" name="anio" id="anio" value="<?=$codAnio;?>"/>
			<input type="hidden" name="mes" id="mes" value="<?=$codMes;?>"/>
			<div class="card ">
			  <div class="card-header card-header-rose card-header-text">
				<div class="card-text">
				  <h4 class="card-title">Editar Fecha Registro Ejecucion POA</h4>
				</div>
			  </div>
			  <div class="card-body ">
				<div class="row">
				  <label class="col-sm-2 col-form-label">Año</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" value="<?=$codAnio;?>" disabled/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Mes</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" value="<?=$codMes;?>" disabled/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Fecha Inicio</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio" required="true" value="<?=$fechaInicio;?>"/>
					</div>
				  </div>
				</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Fecha Fin</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="date" name="fecha_fin" id="fecha_fin" required="true" value="<?=$fechaFin;?>"/>
					</div>
				  </div>
				</div>
				

			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="btn">Guardar</button>
				<a href="?opcion=listAreas" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>