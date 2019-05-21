<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

?>

<div class="content">
  <div class="container-fluid">

    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="solicitudFondosSIS/rptDetalleGastosSIS.php" method="get" target="_blank">
      <div class="card ">
        <div class="card-header <?=$colorCard;?> card-header-text">
        <div class="card-text">
          <h4 class="card-title">Detalle de Gastos SIS</h4>
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
          <label class="col-sm-2 col-form-label">Mes</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccione una opcion" name="mes" id="mes" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT codigo, nombre FROM meses order by 1");
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


        </div>
        <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="<?=$button;?>">Ver</button>
        </div>
      </div>
      </form>
    </div>
  
  </div>
</div>