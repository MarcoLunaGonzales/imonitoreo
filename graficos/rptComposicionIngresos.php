<?php
error_reporting(E_ALL);
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

session_start();

$fondoTemporal=$_GET["codigosFondo"];
$nombreFondo=abrevFondo($fondoTemporal);
$mesTemporal=$_GET["mes"];
$anioTemporal=$_GET["anio"];

$cadenaOrganismos=0;
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=2");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaOrganismos=$row['valor_configuracion'];
}


$_SESSION["fondoTemporal"]=$fondoTemporal;
$_SESSION["nombreFondoTemporal"]=$nombreFondo;
$_SESSION["mesTemporal"]=$mesTemporal;
$_SESSION["anioTemporal"]=$anioTemporal;
$_SESSION["organismoTemporal"]=$cadenaOrganismos;


$dbh = new Conexion();

?>

<div class="content">
        <div class="container-fluid">
          <div class="container-fluid">
            <div class="header text-center">
              <h3 class="title">Reporte Composicion de Ingresos</h3>
              <h3 class="title"><?=$nombreFondo;?></h3>
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
                    <h4 class="card-title">Composicion de Ingresos
                    </h4>
                  </div>
                  <div class="card-body">
                    <table width="100%">
                      <thead>
                        <tr>
                          <th class="text-center font-weight-bold">Area</th>
                          <th class="text-center font-weight-bold">Ej. Ingresos</th>
                          <th class="text-center font-weight-bold">Ej. Egresos</th>
                          <th class="text-center font-weight-bold">Resultado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sqlOrganismos="SELECT o.codigo, o.nombre from po_organismos o where o.codigo in ($cadenaOrganismos)";
                        $stmtOrganismo=$dbh->prepare($sqlOrganismos);
                        $stmtOrganismo->execute();
                        $totalIngresos=0;
                        $totalEgresos=0;
                        $totalResultado=0;
                        while($rowOrganismo=$stmtOrganismo->fetch(PDO::FETCH_ASSOC)){
                          $codOrganismoX=$rowOrganismo['codigo']; 
                          $nombreOrganismoX=$rowOrganismo['nombre']; 

                          $montoEjIng=ejecutadoIngresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codOrganismoX,0,0);
                          $montoEjEg=ejecutadoEgresosMes($fondoTemporal,$anioTemporal,$mesTemporal,$codOrganismoX,0,0);
                          $resultado=$montoEjIng-$montoEjEg;

                          $totalIngresos+=$montoEjIng;
                          $totalEgresos+=$montoEjEg;
                          $totalResultado+=$resultado;

                        ?>
                        <tr>
                          <td class="text-left"><?=$nombreOrganismoX;?></td>
                          <td class="text-right table-warning"><?=formatNumberInt($montoEjIng);?></td>
                          <td class="text-right table-warning"><?=formatNumberInt($montoEjEg);?></td>
                          <td class="text-right <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($resultado);?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                          <td class="text-left">Totales</td>
                          <td class="text-right table-warning"><?=formatNumberInt($totalIngresos);?></td>
                          <td class="text-right table-warning"><?=formatNumberInt($totalEgresos);?></td>
                          <td class="text-right <?=$colorPorcentajeIngreso;?>"><?=formatNumberInt($totalResultado);?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">timeline</i>
                    </div>
                    <h4 class="card-title">
                    </h4>
                  </div>
                  <div class="card-body">
                    <?php
                    require("chartComposicionIngresos.php");
                    ?>
                  </div>
                </div>
              </div>


            </div>

        </div>
      </div>
    </div>