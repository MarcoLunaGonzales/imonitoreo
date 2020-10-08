<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();
$codPersonal=$_GET['cod_personal'];
?>
<option value="">Funcion Asociada a la Actividad</option>
    <?php
    $stmt = $dbh->prepare("SELECT cf.cod_funcion, cf.nombre_funcion from personal_datosadicionales p, cargos_funciones cf where p.cod_personal='$codPersonal' and p.cod_cargo=cf.cod_cargo ORDER BY 2");
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
				