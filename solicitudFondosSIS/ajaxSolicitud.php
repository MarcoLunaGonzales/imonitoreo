<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

session_start();
$globalAdmin=$_SESSION["globalAdmin"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$codigo_proy=$_SESSION["globalProyecto"];
$codigo=$_GET['codigo'];

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


?>
<div class="col-md-12">
	<div class="row">

		<div class="col-sm-8">
	        <div class="form-group">
				<select class="selectpicker form-control" name="componente<?=$codigo;?>" id="componente<?=$codigo;?>" data-style="<?=$comboColor;?>"  data-live-search="true" required="true">
				  	<option value="">Actividad</option>
				  	<?php
				  	$stmt = $dbh->prepare("SELECT codigo, abreviatura, nombre FROM componentessis where cod_estado=1 and nivel=3 and cod_proyecto=$codigo_proy order by 2,3");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$codigoX=$row['codigo'];
						$nombreX=$row['nombre'];
						$nombreX=substr($nombreX, 0, 90);
						$abreviaturaX=$row['abreviatura'];
					?>
						<option value="<?=$codigoX;?>"><?=$abreviaturaX." ".$nombreX;?></option>	
					<?php
					}
				  	?>
				</select>
			</div>
	    </div>

	  	<div class="col-sm-3">
			<div class="form-group">
				<label for="monto<?=$codigo;?>" class="bmd-label-floating">Monto</label>
				<input class="form-control" type="number" name="monto<?=$codigo;?>" id="monto<?=$codigo;?>" required="true"/>
			</div>
		</div>

		<div class="col-sm-1">
			<button rel="tooltip" class="btn btn-just-icon btn-danger btn-link" onclick="minusSolicitudFondo('<?=$codigo;?>');">
	                              <i class="material-icons">remove_circle</i>
	        </button>
		</div>


	</div>
</div>

<div class="h-divider">
