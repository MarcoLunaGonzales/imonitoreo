<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';
$codigo_proy=$_SESSION["globalProyecto"];
// echo $codigo_proy;
if($codigo_proy==''){
  $codigo_proy=$codigo_proy;
  include("principal_actividades.php");
}else{
  $nombre_proyecto=obtener_nombre_proyecto($codigo_proy);
  $dbh = new Conexion();
  ?>

  <div class="content">
    <div class="container-fluid">

      <div class="col-md-12">
        <form id="form1" class="form-horizontal" action="solicitudFondosSIS/savePresupuesto.php" method="post" enctype="multipart/form-data">
        <div class="card ">
          <div class="card-header <?=$colorCard;?> card-header-text">
          <div class="card-text">
            <h4 class="card-title">Cargar Presupuesto - Proyecto <?=$nombre_proyecto?></h4>
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
                <option value="0">Borrar Todo y Cargar</option>
                <option value="1">Anexar/Sobreescribir la(s) fila(s) del Archivo</option>
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

<?php }?>