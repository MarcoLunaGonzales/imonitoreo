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

$codigo=$codigo;
$stmt = $dbh->prepare("SELECT s.fecha, s.observaciones from solicitud_fondos s where s.codigo=:codigo");
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$fechaX=$row['fecha'];
	$observacionesX=$row['observaciones'];
}



$sqlCount="SELECT count(*)as nro_registros FROM solicitudfondos_detalle s where s.codigo=$codigo";	
$stmtX = $dbh->prepare($sqlCount);
$stmtX->execute();
while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
	$contadorRegistros=$row['nro_registros'];
}
?>

<script>
	numFilas=<?=$contadorRegistros;?>;
	cantidadItems=<?=$contadorRegistros;?>;
</script>

<div class="content">
	<div class="container-fluid">

		<form id="form1" class="form-horizontal" action="solicitudFondosSIS/saveEdit.php" method="post">	
			<input type="hidden" name="cod_actividad" id="cod_actividad" value="<?=$codigo;?>">
			<input type="hidden" name="cantidad_filas" id="cantidad_filas" value="<?=$contadorRegistros;?>">
		
			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Editar <?=$moduleName;?></h4>
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
						  <input class="form-control" type="date" name="fecha" id="fecha" value="<?=$fechaX;?>" required="true" />
						</div>
					  </div>
					</div>

					<div class="row">
					  <label class="col-sm-2 col-form-label">Observaciones</label>
					  <div class="col-sm-8">
						<div class="form-group">
						  <input class="form-control" type="text" name="observaciones" value="<?=$observacionesX;?>" id="observaciones"required="true"/>
						</div>
					  </div>
					</div>

					
					<fieldset id="fiel" style="width:100%;border:0;">
						<button type="button" name="add" value="add" class="btn btn-danger btn-round btn-fab" onClick="addSolicitudFondo(this)" accesskey="a">
		                              <i class="material-icons">add</i>
		                </button>						

		            <?php
		            	$sqlLista="SELECT s.cod_componente, s.monto from solicitudfondos_detalle s where s.codigo=$codigo";
						$stmtLista = $dbh->prepare($sqlLista);
						$stmtLista->execute();

						$stmtLista->bindColumn('cod_componente', $codComponenteX);
						$stmtLista->bindColumn('monto', $montoX);

                        $index=1;
                      	while ($rowLista = $stmtLista->fetch(PDO::FETCH_BOUND)) {

                    ?>
					<div id="div<?=$index;?>">	
		            	<div class="col-md-12">
							<div class="row">

								<div class="col-sm-8">
							        <div class="form-group">
										<select class="selectpicker form-control" name="componente<?=$index;?>" id="componente<?=$index;?>" data-style="<?=$comboColor;?>" data-live-search="true" required="true">
										  	<option value="">Actividad</option>
										  	<?php
										  	$stmt = $dbh->prepare("SELECT codigo, abreviatura, nombre, cod_gestion FROM componentessis where cod_estado=1 and nivel=3 order by 2,3");
											$stmt->execute();
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$codigoX=$row['codigo'];
												$nombreX=$row['nombre'];
												$nombreX=substr($nombreX, 0,90);
												$abreviaturaX=$row['abreviatura'];
												$codGestionX=$row['cod_gestion'];
											?>
												<option value="<?=$codigoX;?>" <?=($codigoX==$codComponenteX)?"selected":"";?> ><?=$abreviaturaX." ".$nombreX." ".$codGestionX;?></option>	
											<?php
											}
										  	?>
										</select>
									</div>
							    </div>

							  	<div class="col-sm-3">
									<div class="form-group">
										<label for="monto<?=$index;?>" class="bmd-label-floating">Monto</label>
										<input class="form-control" type="number" name="monto<?=$index;?>" id="monto<?=$index;?>" value="<?=$montoX;?>" step="0.01" required="true"/>
									</div>
								</div>

								<div class="col-sm-1">
									<button rel="tooltip" class="btn btn-just-icon btn-danger btn-link" onclick="minusSolicitudFondo('<?=$index;?>');">
							                              <i class="material-icons">remove_circle</i>
							        </button>
								</div>


							</div>
						</div>
					<?php
							$index++;
						}
					?>
					</div>
	            </fieldset>
		    
	            
				  	<div class="card-body">
						<button type="submit" class="<?=$button;?>">Guardar</button>
						<a href="?opcion=listPOA" class="<?=$buttonCancel;?>">Cancelar</a>

				  	</div>

				</div>
			</div>	
		</form>
	</div>
</div>


