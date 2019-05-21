<?php 
	require_once '../conexion.php';
	require_once '../functions.php';
	require_once '../styles.php';

	$dbh = new Conexion();

	$anio=$_GET["anio"];
	$mes=$_GET["mes"];

?>
<input type="hidden" name="anio" value="<?=$anio;?>">
<input type="hidden" name="mes" value="<?=$mes;?>">

<div class="col-sm-12">
  <div class="card">
    <div class="card-header card-header-text <?=$colorCardDetail?>">
      <div class="card-text">
        <h6 class="card-category">Año: <?=$anio;?></h6>
        <h6 class="card-category">Mes: <?=$mes;?></h6>
      </div>

	  	<select class="form-control" name="nro_archivo" id="nro_archivo" data-style="<?=$comboColor;?>" required>
		  	<option disabled selected value="">Numero de Archivo</option>
			<option value="1">1</option>
			<option value="2">2</option>
	  	</select>

	  	<input class="form-control-file" type="file" name="file">

    </div>
  </div>
</div>