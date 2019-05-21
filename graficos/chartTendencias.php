<?php
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

session_start();

$fondoTemporal=$_GET["codigosFondo"];
$nombreFondo=$_GET["nombreFondo"];
$mesTemporal=$_GET["mes"];
$anioTemporal=$_GET["anio"];
$organismoTemporal=$_GET["organismo"];

$_SESSION["fondoTemporal"]=$fondoTemporal;
$_SESSION["nombreFondoTemporal"]=$nombreFondo;
$_SESSION["mesTemporal"]=$mesTemporal;
$_SESSION["anioTemporal"]=$anioTemporal;
$_SESSION["organismoTemporal"]=$organismoTemporal;

$nombreOrganismo=nameOrganismo($organismoTemporal);

$dbh = new Conexion();

?>

<div class="content">
        <div class="container-fluid">
          <div class="container-fluid">
            <div class="header text-center">
              <h3 class="title">Reporte Tendencias</h3>
              <h3 class="title"><?=$nombreFondo;?> - <?=$nombreOrganismo;?></h3>
              <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>

            </div>
            <div class="row">      
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Tendencia de Ingresos <?=$nombreFondo;?>
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    require("chartIngresosTendencia.php");
                    ?>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Tendencia de Egresos <?=$nombreFondo;?>
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    require("chartEgresosTendencia.php");
                    ?>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Tendencia de Resultados <?=$nombreFondo;?>
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    require("chartResultsTendencia.php");
                    ?>
                  </div>
                </div>
              </div>


            </div>

        </div>
      </div>
    </div>
