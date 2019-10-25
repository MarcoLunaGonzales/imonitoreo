<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

?>

<div class="content">
  <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <form id="form1" class="form-horizontal" action="utilitarios/sendDatosConta.php" method="post">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Descargar Datos Contabilidad</h4>
                </div>
                
                <div class="card-body">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Gestion</label>
                          <div class="col-sm-7">
                          <div class="form-group">
                            <select class="selectpicker" title="Seleccione una opcion" name="gestion" id="gestion" data-style="<?=$comboColor;?>" required>
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
                            <select class="selectpicker form-control" title="Seleccione una opcion" name="mes[]" id="mes" data-style="select-with-transition" multiple required>
                              <option disabled selected value=""></option>
                              <?php
                              $stmt = $dbh->prepare("SELECT codigo, nombre FROM meses order by 1");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              $codigoX=$row['codigo'];
                              $nombreX=$row['nombre'];
                            ?>
                            <option value="<?=$codigoX;?>" selected><?=$nombreX;?></option>
                            <?php 
                            }
                              ?>
                            </select>
                          </div>
                          </div>
                        </div>

                  </div>
                </div>
              </div>
              <div class="card-body">
                    <button type="submit" class="<?=$button;?>">Enviar</button>
              </div>
               </form>
            </div>
          </div>  
        </div>
    </div>
