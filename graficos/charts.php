<?php
require_once 'conexion.php';
require_once 'functions.php';
require_once 'functionsPOSIS.php';
require_once 'styles.php';

$dbh = new Conexion();

$fondo1="1011,1012,1060";
$nameFondo1=abrevFondo($fondo1);

$fondo2="1030,1040,1070";
$nameFondo2=abrevFondo($fondo2);

$fondo3="1020,1050";
$nameFondo3=abrevFondo($fondo3);

$anioTemporal=2019;
$mesTemporal=4;

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
$cadenaOrganismos="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=7");
$stmt->execute();
$cadenaFondos="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaFondos=$row['valor_configuracion'];
}

$_SESSION["fondo1"]=$fondo1;
$_SESSION["nameFondo1"]=$nameFondo1;
$_SESSION["fondo2"]=$fondo2;
$_SESSION["nameFondo2"]=$nameFondo2;
$_SESSION["fondo3"]=$fondo3;
$_SESSION["nameFondo3"]=$nameFondo3;
$_SESSION["anioTemporal"]=$anioTemporal;
$_SESSION["mesTemporal"]=$mesTemporal;
$_SESSION["cadenaOrganismos"]=$cadenaOrganismos;
$_SESSION["cadenaFondos"]=$cadenaFondos;



?>
<div class="content">
        <div class="container-fluid">
          <div class="container-fluid">
            <div class="header text-center">
              <!--h3 class="title">Cuadro de Mando Integral</h3>
              <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6-->
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
                    <h4 class="card-title">Ingresos por Regional
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    require("chartIngresos.php");
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
                    <h4 class="card-title">Egresos por Regional
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    require("chartEgresos.php");
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Ingresos por Servicios
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    //require("chartIngresosServicios.php");
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
                    <h4 class="card-title">Egresos por Servicios
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    //require("chartEgresosServicios.php");
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">Ingresos Tendencia
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
                    <h4 class="card-title">Egresos por Servicios
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    //require("chartEgresosServicios.php");
                    ?>
                  </div>
                </div>
              </div>
            </div>


        </div>
      </div>
    </div>
