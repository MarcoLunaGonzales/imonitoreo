<?php

require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';
$dbh = new Conexion();

$table="gestiones_extendidas";
$moduleName="Editar Gestion Extendida";

//RECIBIMOS LAS VARIABLES
$id_gestion=$id_gestion;
$sql="SELECT anio_inicio,mes_inicio,anio_final,mes_final from $table where id_gestion=$id_gestion";
$stmt = $dbh->prepare($sql);
//echo $sql;
// Ejecutamos
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$anio_inicioX=$row['anio_inicio'];
	$mes_inicioX=$row['mes_inicio'];
	$anio_finalX=$row['anio_final'];
	$mes_finalX=$row['mes_final'];
}
?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">
		  <form id="form1" class="form-horizontal" action="gestiones_extendidas/saveConfig.php" method="post">
			<input type="hidden" name="id_gestion" id="id_gestion" value="<?=$id_gestion;?>"/>
			<div class="card ">
			  <div class="card-header card-header-rose card-header-text">
				<div class="card-text">
				  <h4 class="card-title"><?=$moduleName;?></h4>
				</div>
			  </div>
			  <div class="card-body ">
			  	<div class="row">
          <label class="col-sm-2 col-form-label">Gestion</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="gestion" id="gestion" data-style="btn btn-rose" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT g.codigo, g.nombre FROM gestiones g where g.codigo not in (SELECT id_gestion from gestiones_extendidas where id_gestion<>$id_gestion) order by 2 desc");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $codigoX=$row['codigo'];
              $nombreX=$row['nombre'];
            ?>
            <option value="<?=$codigoX;?>" <?=($codigoX==$id_gestion)?"selected":""?>><?=$nombreX;?></option>
            <?php 
            }
              ?>
            </select>
          </div>
          </div>
        </div>

	    <div class="row">
          <label class="col-sm-2 col-form-label">Año Inicio</label>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="gestion_inicio" id="gestion_inicio" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM gestiones order by 2 desc");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $codigoX=$row['codigo'];
              $nombreX=$row['nombre'];
            ?>
            <option value="<?=$codigoX;?>" <?=(nameGestion($codigoX)==$anio_inicioX)?"selected":""?>><?=$nombreX;?></option>
            <?php 
            }
              ?>
            </select>
          </div>
          </div>
          <label class="col-sm-2 col-form-label">Mes Inicio</label>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="selectpicker" title="Seleccione una opcion" name="mes_inicio" id="mes_inicio" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM meses order by 1");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $codigoX=$row['codigo'];
              $nombreX=$row['nombre'];
            ?>
            <option value="<?=$codigoX;?>" <?=($codigoX==$mes_inicioX)?"selected":""?>><?=$nombreX;?></option>
            <?php 
            }
              ?>
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <label class="col-sm-2 col-form-label">Año Final</label>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="gestion_final" id="gestion_final" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM gestiones order by 2 desc");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $codigoX=$row['codigo'];
              $nombreX=$row['nombre'];
            ?>
            <option value="<?=$codigoX;?>" <?=(nameGestion($codigoX)==$anio_finalX)?"selected":""?>><?=$nombreX;?></option>
            <?php 
            }
              ?>
            </select>
          </div>
          </div>
          <label class="col-sm-2 col-form-label">Mes Final</label>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="selectpicker" title="Seleccione una opcion" name="mes_final" id="mes_final" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM meses order by 1");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $codigoX=$row['codigo'];
              $nombreX=$row['nombre'];
            ?>
            <option value="<?=$codigoX;?>" <?=($codigoX==$mes_finalX)?"selected":""?>><?=$nombreX;?></option>
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
				<a href="?opcion=listGestionesExtendidas" class="btn btn-danger">Cancelar</a>
			  </div>
			</div>
		  </form>
		</div>
	
	</div>
</div>
<script>
$("#form1").submit(function(e) {
      var mensaje="";
      if(!($("#gestion").val()>0)||!($("#gestion_inicio").val()>0)||!($("#gestion_final").val()>0)||!($("#mes_inicio").val()>0)||!($("#mes_final").val()>0)){
        Swal.fire("Informativo!", "Todos los campos son requeridos!", "warning");
        return false;
      }
      if(parseInt($('#gestion_inicio option:selected').text())>=parseInt($('#gestion_final option:selected').text())){
        Swal.fire("Informativo!", "Hay un error en las Gestiones, debe verificar", "warning");
        return false;
      } 

      if(parseInt($('#gestion_inicio option:selected').text())!=parseInt($('#gestion option:selected').text())){
        Swal.fire("Informativo!", "El Año Inicio debe ser igual al de la gestión", "info");
        return false;
      }     
    });
</script>