<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$codigo_proy=$_SESSION["globalProyecto"];
$nombre_proyecto=obtener_nombre_proyecto($codigo_proy);

$dbh = new Conexion();

$moduleName="Solicitud de Fondos - Proyecto ".$nombre_proyecto;
?>


<div class="content">
	<div class="container-fluid">

		<form id="form1" class="form-horizontal" action="solicitudFondosSIS/save.php" method="post">
			<input type="hidden" name="cantidad_filas" id="cantidad_filas" value="<?=$contadorRegistros;?>">

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Registrar <?=$moduleName;?></h4>
					</div>
				</div>
				<div class="card-body ">
					<div class="row">
					  <label class="col-sm-2 col-form-label">Gestion</label>
					  <div class="col-sm-2">
						<div class="form-group">
						  <input class="form-control" type="text" name="gestion" value="<?=$globalNombreGestion;?>" id="gestion" disabled="true" />
						</div>
					  </div>
					  <label class="col-sm-2 col-form-label">Fecha</label>
					  <div class="col-sm-2">
						<div class="form-group">
						  <input class="form-control" type="date" name="fecha" id="fecha" required="true" />
						</div>
					  </div>
					</div>

					<div class="row">
					  <label class="col-sm-2 col-form-label">Observaciones</label>
					  <div class="col-sm-8">
						<div class="form-group">
						  <input class="form-control" type="text" name="observaciones" id="observaciones"required="true"/>
						</div>
					  </div>
					</div>

					
					<fieldset id="fiel" style="width:100%;border:0;">
						<button type="button" name="add" value="add" class="btn btn-danger btn-round btn-fab" onClick="addSolicitudFondo(this)" accesskey="a">
		                              <i class="material-icons">add</i>
		                </button>						

		            </fieldset>
		    
	            
				  	<div class="card-body">
						<button type="submit" class="<?=$button;?>">Guardar</button>
						<a href="?opcion=listSolicitudFondosSIS" class="<?=$buttonCancel;?>">Cancelar</a>

				  	</div>

				</div>
			</div>	
		</form>
	</div>
</div>


