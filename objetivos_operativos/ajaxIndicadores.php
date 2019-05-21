<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$objetivoEstrategico=$_POST['objetivo_estrategico'];
?>

<select class="selectpicker_1" name="indicador_est" id="indicador_est" data-style="<?=$comboColor;?>" required>
	<option disabled selected value=""></option>
	<?php
	$sql="SELECT codigo, nombre FROM indicadores where cod_objetivo='$objetivoEstrategico'";
	//echo $sql;
	$stmt = $dbh->prepare($sql);
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