<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();

$globalAdmin=$_SESSION["globalAdmin"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$codigo=$_GET['codigo'];
$codigoIndicador=$_GET['cod_indicador'];
$codUnidad=$_GET['cod_unidad'];
$codArea=$_GET['cod_area'];
$codActividad=$_GET['cod_actividad'];
$codPersonal=$_GET['cod_personal'];

$codUnidadHijosX=buscarHijosUO($codUnidad);
$nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$codUnidad,$codArea);
?>

<div class="col-md-12">
	<div class="row">
		<input type="hidden" name="codigo<?=$codigo;?>" id="codigo<?=$codigo;?>" value="0">
				

		<div class="col-sm-6">
	    	<div class="form-group">
	        <select class="selectpicker form-control form-control-sm" name="cod_padre<?=$codigo;?>" id="cod_padre<?=$codigo;?>" data-style="<?=$comboColor2;?>" data-live-search="true">
			  	<option value="">Actividad Padre</option>
			  	<?php
			  	$sql="SELECT a.codigo, a.nombre from actividades_poa a where a.codigo='$codActividad' order by a.orden";
			  	//echo $Sql;
			  	$stmt = $dbh->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$codigoX=$row['codigo'];
					$nombreX=$row['nombre'];
				?>
					<option value="<?=$codigoX;?>" <?=($codigoX==$codPadreX)?"selected":"";?>  data-content="<span class='text-dark small font-weight-bold'><?=$nombreX;?></span>" selected><?=$nombreX;?></option>	
				<?php
				}
			  	?>
			</select>
			</div>
	  	</div>

	  	<div class="col-sm-3">
			<div class="form-group">
				<label for="producto_esperado<?=$codigo;?>" class="bmd-label-floating">Producto Esperado</label>
				<input class="form-control" type="text" name="producto_esperado<?=$codigo;?>" id="producto_esperado<?=$codigo;?>"/>
			</div>
		</div>
	  	<div class="col-sm-3">
	    	<div class="form-group">
	        <select class="selectpicker form-control form-control-sm" name="clasificador<?=$codigo;?>" id="clasificador<?=$codigo;?>" data-style="<?=$comboColor;?>" data-width="200px" data-live-search="true" onChange="completaActividad(this,<?=$codigo;?>)" >
			  	<option disabled selected value="">Clasificador</option>
			  	<?php
			  	if($nombreTablaClasificador!="" && $nombreTablaClasificador!="clientes"){
				  	$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM $nombreTablaClasificador where cod_estado=1 order by 2");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$codigoX=$row['codigo'];
						$nombreX=$row['nombre'];
						$abrevX=$row['abreviatura'];
				?>
						<option value="<?=$codigoX;?>"><?=$abrevX."-".$nombreX;?></option>	
				<?php
					}
			  	}
			  	if($nombreTablaClasificador=="clientes"){
				  	$stmt = $dbh->prepare("SELECT c.codigo, c.nombre, u.nombre as unidad from clientes c, unidades_organizacionales u where c.cod_unidad=u.codigo 
				  		and c.cod_unidad in ($codUnidadHijosX) order by 2;");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$codigoX=$row['codigo'];
						$nombreX=$row['nombre'];
						$nombreUnidad=$row['unidad'];
				?>
						<option value="<?=$codigoX;?>" data-subtext="<?=$nombreUnidad;?>"><?=$nombreX;?></option>	
				<?php
					}
			  	}
			  	?>
			</select>
			</div>
	  	</div>
	</div>
</div>
<div class="col-md-12">
	<div class="row">
	    <div class="col-sm-5">
		    <div class="form-group">
          		<label for="actividad<?=$codigo;?>" class="bmd-label-floating">Actividad</label>
				<textarea class="form-control" name="actividad<?=$codigo;?>" id="actividad<?=$codigo;?>" required="true" rows="1"></textarea>
			</div>
		</div>
		<div class="col-sm-3">
	    	<div class="form-group">
	        <select class="selectpicker form-control form-control-sm" name="cod_personal<?=$codigo;?>" id="cod_personal<?=$codigo;?>" data-style="<?=$comboColor2;?>" data-live-search="true" onchange="cambiarFuncionesPersonalPOAI(<?=$codigo;?>)">
			  	<option value="">Personal</option>
			  	<?php
			  	$sql="SELECT p.codigo, p.nombre, (select c.nombre from cargos c where c.codigo=pd.cod_cargo)as cargo from personal2 p, personal_datosadicionales pd, personal_unidadesorganizacionales pu where p.codigo=pd.cod_personal and p.codigo=pu.cod_personal and pu.cod_unidad='$codUnidad' and pd.cod_cargo in (select i.cod_cargo from indicadores_areascargos i where i.cod_indicador='$codigoIndicador' and i.cod_area='$codArea') ";
			  	if($codPersonal==1){
			  		$sql.=" and p.codigo in ($globalUser) ";
			  	}
			  	$sql.=" order by 1,2";
			  	//echo $sql;
			  	$stmt = $dbh->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$codigoX=$row['codigo'];
					$nombreX=$row['nombre'];
				?>
					<option value="<?=$codigoX;?>" <?=($codigoX==$codPadreX)?"selected":"";?>  data-content="<span class='text-dark small font-weight-bold'><?=$nombreX;?></span>" selected><?=$nombreX;?></option>	
				<?php
				}
			  	?>
			</select>
			</div>
	  	</div>
	  	<div class="col-sm-3">
			<div class="form-group">
				<label for="tipo_seguimiento<?=$codigo;?>" class="bmd-label-floating">Unidad de Medida</label>
				<input class="form-control" type="text" name="tipo_seguimiento<?=$codigo;?>" id="tipo_seguimiento<?=$codigo;?>"/>
			</div>
		</div>
		<div class="col-sm-1">
			<button rel="tooltip" class="btn btn-just-icon btn-danger btn-link" onclick="minusActividad('<?=$codigo;?>');">
	                              <i class="material-icons">remove_circle</i>
	        </button>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="row">	
		<div class="col-sm-3">
	        <div class="form-group">
				<select class="selectpicker form-control form-control-sm" name="tipo_actividad<?=$codigo;?>" id="tipo_actividad<?=$codigo;?>" data-style="<?=$comboColor;?>" data-live-search="true">
				  	<option value="">Tipo de Actividad</option>
				  	<?php
				  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM tipos_actividadpoa where cod_estado=1 order by 2");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$codigoX=$row['codigo'];
						$nombreX=$row['nombre'];
					?>
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>	
					<?php	
					}
				  	?>
				</select>
			</div>
	    </div>
		<div class="col-sm-3">
	        <div class="form-group">
				<select class="selectpicker form-control form-control-sm" name="periodo<?=$codigo;?>" id="periodo<?=$codigo;?>" data-style="<?=$comboColor;?>" data-live-search="true">
				  	<option value="">Planificación</option>
				  	<?php
				  	$stmt = $dbh->prepare("SELECT codigo, nombre FROM periodos where codigo in (0,1) order by 2");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$codigoX=$row['codigo'];
						$nombreX=$row['nombre'];
					?>
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>	
					<?php	
					}
				  	?>
				</select>
			</div>
	    </div>	
		<div class="col-sm-6">
	        <div class="form-group">
				<select class="selectpicker form-control form-control-sm" name="funcion<?=$codigo;?>" id="funcion<?=$codigo;?>" data-style="<?=$comboColor;?>" data-live-search="true">
				  	<option value="">Funcion Asociada a la Actividad</option>
				  	<?php
				  	$stmt = $dbh->prepare("SELECT cf.cod_funcion, cf.nombre_funcion from personal_datosadicionales p, cargos_funciones cf where p.cod_personal='$globalUser' and p.cod_cargo=cf.cod_cargo ORDER BY 2");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$codigoX=$row['cod_funcion'];
						$nombreX=$row['nombre_funcion'];
						$nombreX=substr($nombreX, 0,100)."...";
					?>
						<option value="<?=$codigoX;?>"><?=$nombreX;?></option>	
					<?php	
					}
				  	?>
				</select>
			</div>
	    </div>	
	</div>
</div>
<div class="h-divider">
