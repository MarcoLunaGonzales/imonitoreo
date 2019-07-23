<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$codPerspectiva=$_GET['cod_perspectiva'];

?>

<select class="form-control" name="cod_indicador" id="cod_indicador" required>
	<option disabled selected value=""></option>
	<?php

	$sql="SELECT i.codigo, o.abreviatura, i.nombre from indicadores i, objetivos o where o.cod_perspectiva='$codPerspectiva' and i.cod_objetivo=o.codigo;";
	
	echo $sql;

	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$codigoX=$row['codigo'];
		$abreviaturaX=$row['abreviatura'];
		$nombreX=$row['nombre'];
	?>
	<option value="<?=$codigoX;?>"><?=$abreviaturaX."-".$nombreX;?></option>
	<?php	
	}
		?>
</select>