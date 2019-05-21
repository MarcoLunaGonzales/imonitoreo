<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

?>

<div class="content">
  <div class="container-fluid">

    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="presupuesto_operativo/savePresupuestoOp.php" method="post" enctype="multipart/form-data">
      <div class="card ">
        <div class="card-header <?=$colorCard;?> card-header-text">
        <div class="card-text">
          <h4 class="card-title">Cargar Presupuesto Operativo</h4>
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
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM gestiones order by 2 desc");
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
          <label class="col-sm-2 col-form-label">Oficina</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="fondo" id="fondo" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM po_fondos where cod_estado=1 order by 2");
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
          <label class="col-sm-2 col-form-label">Area</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="organismo" id="organismo" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM po_organismos order by 2");
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

        </div>
        <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="<?=$button;?>">Guardar</button>
        </div>
      </div>
      </form>
    </div>
  
  </div>
</div>