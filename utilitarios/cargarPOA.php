<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

?>

<div class="content">
  <div class="container-fluid">

    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="utilitarios/saveCargarPOA.php" method="post" enctype="multipart/form-data" target="_BLANK">
      <div class="card ">
        <div class="card-header <?=$colorCard;?> card-header-text">
        <div class="card-text">
          <h4 class="card-title">Cargar POA</h4>
        </div>
        </div>
        <div class="card-body ">
    
        <div class="row">
          <label class="col-sm-2 col-form-label">Gestion</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="gestion" id="gestion" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT g.codigo, g.nombre FROM gestiones g, gestiones_datosadicionales gd WHERE g.codigo=gd.cod_gestion and gd.cod_estadopoa=1 order by 2 desc");
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
        </div>

        <div class="row">
          <label class="col-sm-2 col-form-label">Archivo</label>
          <div class="col-sm-7">
          <div class="form-control">
            <input class="form-control-file" type="file" name="file">
          </div>
          </div>
        </div>
        

        <div class="row">
          <label class="col-sm-2 col-form-label">Opciones</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="tipo" id="tipo" data-style="<?=$comboColor;?>" required>
              <option value="0">Anexar Actividades sin Borrar.</option>
              <option value="1">Borrar Actividades por coincidencia de Indicador-Unidad-Area y Cargar.</option>
            </select>
          </div>
          </div>
        </div>


        </div>
        <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="<?=$button;?>">Guardar</button>
        </div>
      </div>
      </form>
    </div>
  
  </div>
</div>