<?php 
	require_once '../conexion.php';
	require_once '../functions.php';
	require_once '../styles.php';

	$dbh = new Conexion();
	
	$codPersonal=$_GET['cod_personal'];
	$index=$_GET['index'];

	$sqlX="SET NAMES 'utf8'";
	$stmtX = $dbh->prepare($sqlX);
	$stmtX->execute();
?>
<select class="form-control" name="funcion<?=$index;?>" id="funcion<?=$index;?>" data-live-search="true" required>
<?php
	$sql="SELECT cf.cod_funcion, cf.nombre_funcion from personal_datosadicionales p, cargos_funciones cf
where p.cod_personal='$codPersonal' and p.cod_cargo=cf.cod_cargo;";
	?>
	<option value="">Seleccionar Funcion</option>
	<?php
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$codigoX=$row['cod_funcion'];
		$nombreX=$row['nombre_funcion'];
		$nombreXCorte1 = substr($nombreX, 0, 120);
		$nombreXCorte2 = substr($nombreX, 0, 75)
?>
	<option value="<?=$codigoX;?>" title="<?$nombreXCorte2;?>"><?=$nombreXCorte1;?></option>	
<?php	
	}
?>
</select>
