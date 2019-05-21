<?php

require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';
$dbh = new Conexion();

$table="gestiones_datosadicionales";
$moduleName="Configurar Gestiones";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;
$sql="SELECT g.codigo, g.nombre, (select gd.cod_estado from gestiones_datosadicionales gd 
where gd.cod_gestion=g.codigo) as estado, 
(select gd.cod_estadopoa from gestiones_datosadicionales gd 
where gd.cod_gestion=g.codigo) as estadopoa FROM gestiones g where g.codigo='$codigo'";
$stmt = $dbh->prepare($sql);
//echo $sql;
// Ejecutamos
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codigoX=$row['codigo'];
	$nombreX=$row['nombre'];
	$estadoR=$row['estado'];
	$estadoPOA=$row['estadopoa'];
}

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="gestiones/saveConfig.php" method="post">
			<input type="hidden" name="codigo" id="codigo" value="<?=$codigoX;?>"/>
			<div class="card ">
			  <div class="card-header card-header-rose card-header-text">
				<div class="card-text">
				  <h4 class="card-title"><?=$moduleName;?></h4>
				</div>
			  </div>
			  <div class="card-body ">
				<div class="row">
				  <label class="col-sm-2 col-form-label">Nombre</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="nombre" id="nombre" required="true" value="<?=$nombreX;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled="true"/>
					</div>
				  </div>
				</div>

				<div class="row">
 				  <label class="col-sm-2 col-form-label">Estado</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="estado" id="estado" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt2 = $dbh->prepare("SELECT codigo, nombre FROM estados_referenciales");
						$stmt2->execute();
						while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
							$codigoY=$row2['codigo'];
							$nombreY=$row2['nombre'];
						?>
						<option value="<?=$codigoY;?>" <?php echo($codigoY==$estadoR)?"selected":"";?> ><?=$nombreY;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
 				  <label class="col-sm-2 col-form-label">Estado POA</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="estado_poa" id="estado_poa" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt2 = $dbh->prepare("SELECT codigo, nombre FROM estados_poa");
						$stmt2->execute();
						while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
							$codigoY=$row2['codigo'];
							$nombreY=$row2['nombre'];
						?>
						<option value="<?=$codigoY;?>" <?php echo($codigoY==$estadoPOA)?"selected":"";?> ><?=$nombreY;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="btn">Guardar</button>
				<a href="?opcion=listGestiones" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>