<?php

require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$table="personal_datosadicionales";
$moduleName="Configurar Accesos";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;
$sql="SELECT p.codigo, p.nombre, p.cod_area, p.cod_unidad, 
	(select pd.perfil from personal_datosadicionales pd where pd.cod_personal=p.codigo) as perfil,
	(select pd.usuario from personal_datosadicionales pd where pd.cod_personal=p.codigo) as usuario,
	(select pd.contrasena from personal_datosadicionales pd where pd.cod_personal=p.codigo) as contrasena, (select pd.cod_cargo from personal_datosadicionales pd where pd.cod_personal=p.codigo) as cargo, (select pd.usuario_pon from personal_datosadicionales pd where pd.cod_personal=p.codigo) as usuariopon
	FROM personal2 p where p.codigo=:codigo";
$stmt = $dbh->prepare($sql);
//echo $sql;
// Ejecutamos
$stmt->bindParam(':codigo',$codigo);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$codigoX=$row['codigo'];
	$nombreX=$row['nombre'];
	$codAreaX=$row['cod_area'];
	$codUnidadX=$row['cod_unidad'];
	$perfilX=$row['perfil'];
	$nombreUsuarioX=$row['usuario'];
	$claveX=$row['contrasena'];
	$cargoX=$row['cargo'];
	$usuarioPON=$row['usuariopon'];
}
$nombreUnidadX="";
if($codUnidadX>0){
	$nombreUnidadX=nameUnidad($codUnidadX);	
}

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="personal/save.php" method="post">
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
 				  <label class="col-sm-2 col-form-label">Cargo</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="cargo" id="cargo" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt2 = $dbh->prepare("SELECT codigo, nombre FROM cargos where cod_estado=1 order by 2");
						$stmt2->execute();
						while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
							$codigoY=$row2['codigo'];
							$nombreY=$row2['nombre'];
						?>
						<option value="<?=$codigoY;?>" <?php echo($codigoY==$cargoX)?"selected":"";?> ><?=$nombreY;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
 				  <label class="col-sm-2 col-form-label">Perfil</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="perfil" id="perfil" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
					  	<?php
					  	$stmt2 = $dbh->prepare("SELECT codigo, nombre FROM perfiles_usuario where cod_estado=1");
						$stmt2->execute();
						while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
							$codigoY=$row2['codigo'];
							$nombreY=$row2['nombre'];
						?>
						<option value="<?=$codigoY;?>" <?php echo($codigoY==$perfilX)?"selected":"";?> ><?=$nombreY;?></option>
						<?php	
						}
					  	?>
					  </select>
					</div>
				  </div>
				</div>

				<div class="row">
 				  <label class="col-sm-2 col-form-label">Usuario PON</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <select class="selectpicker" name="usuariopon" id="usuariopon" data-style="<?=$comboColor;?>" required>
					  	<option disabled selected value=""></option>
						<option value="0" <?=($usuarioPON==0)?"selected":"";?> > NO </option>
						<option value="1" <?=($usuarioPON==1)?"selected":"";?> > USUARIO PON </option>
						<option value="2" <?=($usuarioPON==2)?"selected":"";?> > ADMIN PON </option>
					  </select>
					</div>
				  </div>
				</div>


				<div class="row">
				  <label class="col-sm-2 col-form-label">Nombre de Usuario</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="nombreusuario" id="nombreusuario" required="true" value="<?=$nombreUsuarioX;?>"/>
					</div>
				  </div>
			  	</div>

				<div class="row">
				  <label class="col-sm-2 col-form-label">Clave</label>
				  <div class="col-sm-7">
					<div class="form-group">
					  <input class="form-control" type="text" name="contrasena" id="contrasena" required="true" value="<?=$claveX;?>"/>
					</div>
				  </div>
			  	</div>



			  </div>
			  <div class="card-footer ml-auto mr-auto">
				<button type="submit" class="btn">Guardar</button>
				<a href="?opcion=listPersonal" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>