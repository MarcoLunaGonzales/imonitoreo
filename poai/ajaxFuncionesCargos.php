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
<select class="form-control" name="funcion<?=$index;?>" id="funcion<?=$index;?>" data-live-search="true">
<?php
	$sql="SELECT cf.cod_funcion, cf.nombre_funcion from personal_datosadicionales p, cargos_funciones cf
where p.cod_personal='$codPersonal' and p.cod_cargo=cf.cod_cargo;";
	?>
	<option value="">Funcion</option>
	<?php
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$codigoX=$row['cod_funcion'];
		$nombreX=$row['nombre_funcion'];
		$nombreX = substr($nombreX, 0, 100);
?>
	<option value="<?=$codigoX;?>"><?=$nombreX;?></option>	
<?php	
	}
?>
</select>
