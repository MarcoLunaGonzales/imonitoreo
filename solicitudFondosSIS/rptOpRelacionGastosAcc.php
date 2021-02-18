<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

//VALORES POR DEFAULT
$codGestionDefault=gestionDefaultReport();
$codMesDefault=mesDefaultReport();


?>

<div class="content">
  <div class="container-fluid">

    <div class="col-md-12">
      <form id="form1" class="form-horizontal" action="solicitudFondosSIS/reporteGastosSISAccNum.php" method="get" target="_blank">
      <div class="card ">
        <div class="card-header <?=$colorCard;?> card-header-text">
        <div class="card-text">
          <h4 class="card-title">Detalle de Gastos SIS con NumAcc</h4>
        </div>
        </div>
        <div class="card-body ">
    
        <div class="row">
          <label class="col-sm-2 col-form-label">Gestion</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="gestion" id="gestion" data-style="<?=$comboColor;?>" required onchange="AjaxGestionMesCambio(this)">
              <option disabled selected value=""></option>
              <?php
              $stmt = $dbh->prepare("SELECT g.codigo, g.nombre,(SELECT anio_final from gestiones_extendidas where id_gestion=g.codigo) as extendida FROM gestiones g order by 2 desc");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $codigoX=$row['codigo'];
              $nombreX=$row['nombre'];
              if($row['extendida']!=""||$row['extendida']!=null||$row['extendida']!=0){
                  $nombreX.=" - ".$row['extendida'];
                }
            ?>
            <option value="<?=$codigoX;?>" <?=($codigoX==$codGestionDefault)?"selected":"";?> ><?=$nombreX;?></option>
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
          <div class="form-group" id="contenedor_meses">
            <select class="selectpicker" title="Seleccione una opcion" name="mes" id="mes" data-style="<?=$comboColor;?>" required>

            </select>
          </div>
          </div>
        </div>


        <div class="row">
          <label class="col-sm-2 col-form-label">Ver</label>
          <div class="col-sm-7">
          <div class="form-group">
            <select class="selectpicker" title="Seleccionar" name="tiporeporte" id="tiporeporte" data-style="<?=$comboColor;?>" required>
              <option disabled selected value=""></option>
               <option value="0">Mes</option>
               <option value="1" selected>Acumulado</option>
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

<script>
$(document).ready(function() {
  AjaxGestionMesCambio(document.getElementById('gestion'));
});
function AjaxGestionMesCambio(combo){
  var contenedor;
  var cod_gestion=combo.value;
  contenedor= document.getElementById('contenedor_meses');
  ajax=nuevoAjax();
  ajax.open('GET', 'solicitudFondosSIS/ajaxMesGestion.php?id_gestion='+cod_gestion,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText;
      $('.selectpicker').selectpicker(["refresh"]);
    }
  }
  ajax.send(null)  

}
</script>