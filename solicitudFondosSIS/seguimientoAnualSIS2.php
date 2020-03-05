<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();


//VALORES POR DEFAULT
$codGestionDefault=gestionDefaultReport();
$codMesDefault=mesDefaultReport();
$codigo_proy=$_SESSION["globalProyecto"];
 $nombre_proyecto=obtener_nombre_proyecto($codigo_proy);

// echo $codigo_proy;

?>

<div class="content">
  <div class="container-fluid">

    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="solicitudFondosSIS/rptSeguimientoAnualSIS2.php" method="get" target="_blank">
      <div class="card ">
        <div class="card-header <?=$colorCard;?> card-header-text">
        <div class="card-text">
          <h4 class="card-title">Seguimiento de Proyectos</h4>
        </div>
        </div>
        <div class="card-body ">
          <div class="row">
            <label class="col-sm-2 col-form-label">Proyecto</label>
            <div class="col-sm-7">
            <div class="form-group">
              <select class="selectpicker" title="Seleccionar" name="codigo_proy" id="codigo_proy" data-style="<?=$comboColor;?>" required>
                <option disabled selected value=""></option>
                <?php
                $stmt = $dbh->prepare("SELECT codigo,nombre from proyectos_financiacionexterna where cod_estadoreferencial=1 order by 2 desc");
              $stmt->execute();
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $codigoX=$row['codigo'];
                $nombreX=$row['nombre'];
              ?>
              <option value="<?=$codigoX;?>"  <?=($codigo_proy==$codigoX)?"selected":"";?> ><?=$nombreX;?></option>
              <?php 
              }
                ?>
              </select>
            </div>
            </div>
          </div>
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
              <option value="<?=$codigoX;?>"  <?=($codigoX==$codGestionDefault)?"selected":"";?> ><?=$nombreX;?></option>
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
              <option value="<?=$codigoX;?>"  <?=($codigoX==$codMesDefault)?"selected":"";?> ><?=$nombreX;?></option>
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