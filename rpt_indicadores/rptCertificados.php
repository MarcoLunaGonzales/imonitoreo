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

$mesTemporal=$_GET["mes"];
$nombreMes=nameMes($mesTemporal);
$anioTemporal=$_GET["anio"];
$codGestion=$_GET["gestion"];


$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=11");
$stmt->execute();
$cadenaUnidades="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaUnidades=$row['valor_configuracion'];
}

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Reporte de Certificaciones</h3>
        <h3>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h3s>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Empresas Certificadas
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Servicio</th>
                    <th class="text-center font-weight-bold" colspan="4">TCP</th>
                    <th class="text-center font-weight-bold" colspan="4">TCS</th>
                    <th class="text-center font-weight-bold" colspan="4">Ambos</th>
                    <th class="text-center font-weight-bold" colspan="4">Totales</th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  /*ESTA PARTE ES PARA OBTENER LOS TOTALES*/
                  $totalMesUnidadX=0;
                  $totalAcumUnidadX=0;

                  $cantEmpresasTCP=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,39,38,0,0);
                  $cantEmpresasTCPAcum=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,39,38,0,1);

                  $cantEmpresasTCS=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,0,0);
                  $cantEmpresasTCSAcum=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,0,1);

                  $cantEmpresasAmbos=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,1,0);
                  $cantEmpresasAmbosAcum=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,1,1);

                  $totalMesUnidadX=$cantEmpresasTCP+$cantEmpresasTCS+$cantEmpresasAmbos;
                  $totalAcumUnidadX=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum+$cantEmpresasAmbosAcum;
                  /*FIN OBTENER LOS TOTALES*/

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $totalMesUnidad=0;
                    $totalAcumUnidad=0;

                    $cantEmpresasTCP=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,39,38,0,0);
                    $cantEmpresasTCPAcum=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,39,38,0,1);

                    $cantEmpresasTCS=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,38,39,0,0);
                    $cantEmpresasTCSAcum=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,38,39,0,1);

                    $cantEmpresasAmbos=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,38,39,1,0);
                    $cantEmpresasAmbosAcum=obtenerCantEmpresasCertificados($codigoX,$anioTemporal,$mesTemporal,38,39,1,1);
                    
                    $totalMes=$cantEmpresasTCP+$cantEmpresasTCS+$cantEmpresasAmbos;
                    $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum+$cantEmpresasAmbosAcum;

                    $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS+$cantEmpresasAmbos;
                    $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum+$cantEmpresasAmbosAcum;

                    $partMesTCP=0;
                    $partMesTCS=0;
                    $partMesAmbos=0;
                    if($totalMes>0){
                      $partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
                      $partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
                      $partMesAmbos=($cantEmpresasAmbos/$totalMes)*100;                    
                    }

                    $partAcumTCP=0;
                    $partAcumTCS=0;
                    $partAcumAmbos=0;
                    if($totalAcumulado>0){
                      $partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
                      $partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
                      $partAcumAmbos=($cantEmpresasAmbosAcum/$totalAcumulado)*100;                    
                    }
                    $porcentajeMes=($totalMesUnidad/$totalMesUnidadX)*100;
                    $porcentajeAcum=($totalAcumUnidad/$totalAcumUnidadX)*100;
                  ?>
                  <tr>
                    <td class="text-center"><?=$abrevX;?></td>
                    <td class="table-warning text-center"><?=($cantEmpresasTCP==0)?"-":formatNumberInt($cantEmpresasTCP);?></td>
                    <td class="table-primary text-center"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberInt($cantEmpresasTCPAcum);?></td>
                    <td class="table-danger text-center"><?=($partMesTCP==0)?"-":formatNumberInt($partMesTCP);?></td>
                    <td class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberInt($partAcumTCP);?></td>

                    <td class="table-warning text-center"><?=($cantEmpresasTCS==0)?"-":formatNumberInt($cantEmpresasTCS);?></td>
                    <td class="table-primary text-center"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberInt($cantEmpresasTCSAcum);?></td>
                    <td class="table-danger text-center"><?=($partMesTCS==0)?"-":formatNumberInt($partMesTCS);?></td>
                    <td class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberInt($partAcumTCS);?></td>

                    <td class="table-warning text-center"><?=($cantEmpresasAmbos==0)?"-":formatNumberInt($cantEmpresasAmbos);?></td>
                    <td class="table-primary text-center"><?=($cantEmpresasAmbosAcum==0)?"-":formatNumberInt($cantEmpresasAmbosAcum);?></td>
                    <td class="table-danger text-center"><?=($partMesAmbos==0)?"-":formatNumberInt($partMesAmbos);?></td>
                    <td class="table-success text-center"><?=($partAcumAmbos==0)?"-":formatNumberInt($partAcumAmbos);?></td>

                    <td class="table-warning text-center font-weight-bold"><?=formatNumberInt($totalMesUnidad);?></td>
                    <td class="table-primary text-center font-weight-bold"><?=formatNumberInt($totalAcumUnidad);?></td>
                    <td class="table-danger text-center font-weight-bold"><?=($porcentajeMes==0)?"-":formatNumberDec($porcentajeMes);?></td>
                    <td class="table-success text-center font-weight-bold"><?=($porcentajeAcum==0)?"-":formatNumberDec($porcentajeAcum);?></td>

                  </tr>
                  <?php
                  }
                  $totalMesUnidad=0;
                  $totalAcumUnidad=0;

                  $cantEmpresasTCP=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,39,38,0,0);
                  $cantEmpresasTCPAcum=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,39,38,0,1);

                  $cantEmpresasTCS=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,0,0);
                  $cantEmpresasTCSAcum=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,0,1);

                  $cantEmpresasAmbos=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,1,0);
                  $cantEmpresasAmbosAcum=obtenerCantEmpresasCertificados(0,$anioTemporal,$mesTemporal,38,39,1,1);
                  
                  $totalMes=$cantEmpresasTCP+$cantEmpresasTCS+$cantEmpresasAmbos;
                  $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum+$cantEmpresasAmbosAcum;

                  $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS+$cantEmpresasAmbos;
                  $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum+$cantEmpresasAmbosAcum;

                  $partMesTCP=0;
                  $partMesTCS=0;
                  $partMesAmbos=0;
                  if($totalMes>0){
                    $partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
                    $partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
                    $partMesAmbos=($cantEmpresasAmbos/$totalMes)*100;                    
                  }

                  $partAcumTCP=0;
                  $partAcumTCS=0;
                  $partAcumAmbos=0;
                  if($totalAcumulado>0){
                    $partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
                    $partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
                    $partAcumAmbos=($cantEmpresasAmbosAcum/$totalAcumulado)*100;                    
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">Totales</th>
                    <th class="table-warning text-center"><?=($cantEmpresasTCP==0)?"-":formatNumberInt($cantEmpresasTCP);?></th>
                    <th class="table-primary text-center"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberInt($cantEmpresasTCPAcum);?></th>
                    <th class="table-danger text-center"><?=($partMesTCP==0)?"-":formatNumberInt($partMesTCP);?></th>
                    <th class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberInt($partAcumTCP);?></th>

                    <th class="table-warning text-center"><?=($cantEmpresasTCS==0)?"-":formatNumberInt($cantEmpresasTCS);?></th>
                    <th class="table-primary text-center"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberInt($cantEmpresasTCSAcum);?></th>
                    <th class="table-danger text-center"><?=($partMesTCS==0)?"-":formatNumberInt($partMesTCS);?></th>
                    <th class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberInt($partAcumTCS);?></th>

                    <th class="table-warning text-center"><?=($cantEmpresasAmbos==0)?"-":formatNumberInt($cantEmpresasAmbos);?></th>
                    <th class="table-primary text-center"><?=($cantEmpresasAmbosAcum==0)?"-":formatNumberInt($cantEmpresasAmbosAcum);?></th>
                    <th class="table-danger text-center"><?=($partMesAmbos==0)?"-":formatNumberInt($partMesAmbos);?></th>
                    <th class="table-success text-center"><?=($partAcumAmbos==0)?"-":formatNumberInt($partAcumAmbos);?></th>

                    <th class="table-warning text-center"><?=formatNumberInt($totalMesUnidad);?></th>
                    <th class="table-primary text-center"><?=formatNumberInt($totalAcumUnidad);?></th>
                    <th class="table-danger text-center"><?=formatNumberInt(100);?></th>
                    <th class="table-success text-center"><?=formatNumberInt(100);?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-2">
        </div>
          
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Empresas Certificadas</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartEmpresasCertificadas.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->




      <!--CERTIFICADOS EMITIDOS-->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Certificados Emitidos
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Servicio</th>
                    <th class="text-center font-weight-bold" colspan="4">TCP</th>
                    <th class="text-center font-weight-bold" colspan="4">TCS</th>
                    <th class="text-center font-weight-bold" colspan="4">Totales</th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  /*ESTA PARTE ES PARA OBTENER LOS TOTALES*/
                  $totalMesUnidadX=0;
                  $totalAcumUnidadX=0;

                  $cantEmpresasTCP=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0);
                  $cantEmpresasTCPAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1);

                  $cantEmpresasTCS=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0);
                  $cantEmpresasTCSAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1);

                  $totalMesUnidadX=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumUnidadX=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;
                  /*FIN OBTENER LOS TOTALES*/

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $totalMesUnidad=0;
                    $totalAcumUnidad=0;

                    $cantEmpresasTCP=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,0);
                    $cantEmpresasTCPAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,1);

                    $cantEmpresasTCS=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,0);
                    $cantEmpresasTCSAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,1);
                    
                    $totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
                    $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                    $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS;
                    $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                    $partMesTCP=0;
                    $partMesTCS=0;
                    if($totalMes>0){
                      $partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
                      $partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
                    }

                    $partAcumTCP=0;
                    $partAcumTCS=0;
                    if($totalAcumulado>0){
                      $partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
                      $partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
                    }
                    $porcentajeMes=($totalMesUnidad/$totalMesUnidadX)*100;
                    $porcentajeAcum=($totalAcumUnidad/$totalAcumUnidadX)*100;
                  ?>
                  <tr>
                    <td class="text-center"><?=$abrevX;?></td>
                    <td class="table-warning text-center"><?=($cantEmpresasTCP==0)?"-":formatNumberInt($cantEmpresasTCP);?></td>
                    <td class="table-primary text-center"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberInt($cantEmpresasTCPAcum);?></td>
                    <td class="table-danger text-center"><?=($partMesTCP==0)?"-":formatNumberInt($partMesTCP);?></td>
                    <td class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberInt($partAcumTCP);?></td>

                    <td class="table-warning text-center"><?=($cantEmpresasTCS==0)?"-":formatNumberInt($cantEmpresasTCS);?></td>
                    <td class="table-primary text-center"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberInt($cantEmpresasTCSAcum);?></td>
                    <td class="table-danger text-center"><?=($partMesTCS==0)?"-":formatNumberInt($partMesTCS);?></td>
                    <td class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberInt($partAcumTCS);?></td>

                    <td class="table-warning text-center font-weight-bold"><?=formatNumberInt($totalMesUnidad);?></td>
                    <td class="table-primary text-center font-weight-bold"><?=formatNumberInt($totalAcumUnidad);?></td>
                    <td class="table-danger text-center font-weight-bold"><?=($porcentajeMes==0)?"-":formatNumberDec($porcentajeMes);?></td>
                    <td class="table-success text-center font-weight-bold"><?=($porcentajeAcum==0)?"-":formatNumberDec($porcentajeAcum);?></td>

                  </tr>
                  <?php
                  }
                  $totalMesUnidad=0;
                  $totalAcumUnidad=0;

                  $cantEmpresasTCP=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0);
                  $cantEmpresasTCPAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1);

                  $cantEmpresasTCS=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0);
                  $cantEmpresasTCSAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1);
                  
                  $totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                  $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                  $partMesTCP=0;
                  $partMesTCS=0;
                  if($totalMes>0){
                    $partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
                    $partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
                  }

                  $partAcumTCP=0;
                  $partAcumTCS=0;
                  if($totalAcumulado>0){
                    $partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
                    $partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">Totales</th>
                    <th class="table-warning text-center"><?=($cantEmpresasTCP==0)?"-":formatNumberInt($cantEmpresasTCP);?></th>
                    <th class="table-primary text-center"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberInt($cantEmpresasTCPAcum);?></th>
                    <th class="table-danger text-center"><?=($partMesTCP==0)?"-":formatNumberInt($partMesTCP);?></th>
                    <th class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberInt($partAcumTCP);?></th>

                    <th class="table-warning text-center"><?=($cantEmpresasTCS==0)?"-":formatNumberInt($cantEmpresasTCS);?></th>
                    <th class="table-primary text-center"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberInt($cantEmpresasTCSAcum);?></th>
                    <th class="table-danger text-center"><?=($partMesTCS==0)?"-":formatNumberInt($partMesTCS);?></th>
                    <th class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberInt($partAcumTCS);?></th>

                    <th class="table-warning text-center"><?=formatNumberInt($totalMesUnidad);?></th>
                    <th class="table-primary text-center"><?=formatNumberInt($totalAcumUnidad);?></th>
                    <th class="table-danger text-center"><?=formatNumberInt(100);?></th>
                    <th class="table-success text-center"><?=formatNumberInt(100);?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-2">
        </div>
          
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Certificados Emitidos</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartCertificadosEmitidos.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->





      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Historico Certificados Emitidos</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartCertificadosHistorico.php");
              ?>
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->



      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Certificados Emitidos Por Norma TCS
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Norma</th>
                    <?php
                    $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                    $stmtU = $dbh->prepare($sqlU);
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    ?>
                    <th class="text-center font-weight-bold" colspan="2"><?=$abrevX;?></th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold" colspan="2">Totales</th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <?php
                    $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                    $stmtU = $dbh->prepare($sqlU);
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    ?>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlN="SELECT e.norma, count(*)as cantidad from ext_certificados e where e.norma not in ('N/A') and YEAR(e.fechaemision)=$anioTemporal and e.idarea=38 group by e.norma order by 2 desc";
                  $stmtN = $dbh->prepare($sqlN);
                  $stmtN->execute();
                  $stmtN->bindColumn('norma', $nombreNorma);
                  $stmtN->bindColumn('cantidad', $cantidadNorma);


                  while($rowN = $stmtN -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-left"><?=$nombreNorma;?></td>
                    <?php
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantCertificadosUnidad=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,38,'',1);
                      $cantCertificados=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,38,$nombreNorma,1);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                    ?>
                    <td class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></td>
                    <td class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt($participacionNorma);?></td>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,'',1);
                    $cantCertificados=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,$nombreNorma,1);
                    $participacionNorma=0;
                    if($cantCertificadosUnidad>0){
                      $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                    }                    
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberDec($participacionNorma);?></th>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">Totales</th>
                    <?php
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantCertificadosUnidad=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,38,'',1);
                      $cantCertificados=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,38,'',1);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt(100);?></th>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,'',1);
                    $cantCertificados=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,38,'',1);
                    $participacionNorma=0;
                    if($cantCertificadosUnidad>0){
                      $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                    }                    
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberDec($participacionNorma);?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-2">
        </div>
          
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Certificados Emitidos por Norma TCS</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartCertificadosNorma.php");
              ?>
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->
        


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Certificados Emitidos Por Sector IAF
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Norma</th>
                    <?php
                    $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                    $stmtU = $dbh->prepare($sqlU);
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    ?>
                    <th class="text-center font-weight-bold" colspan="2"><?=$abrevX;?></th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold" colspan="2">Totales</th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <?php
                    $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                    $stmtU = $dbh->prepare($sqlU);
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    ?>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlN="SELECT e.iaf, count(*)as cantidad from ext_certificados e where e.norma not in ('N/A') and YEAR(e.fechaemision)=$anioTemporal and e.idarea=38 and e.iaf<>'0' group by e.iaf order by 2 desc";
                  $stmtN = $dbh->prepare($sqlN);
                  $stmtN->execute();
                  $stmtN->bindColumn('iaf', $codigoIAF);
                  $stmtN->bindColumn('cantidad', $cantidadNorma);


                  while($rowN = $stmtN -> fetch(PDO::FETCH_BOUND)){
                    $nombreIAF=nameIAF($codigoIAF);
                  ?>
                  <tr>
                    <td class="text-left"><?=$nombreIAF;?>.(<?=$codigoIAF;?>)</td>
                    <?php
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantCertificadosUnidad=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,38,0,1);
                      $cantCertificados=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,38,$codigoIAF,1);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                    ?>
                    <td class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></td>
                    <td class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt($participacionNorma);?></td>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,38,0,1);
                    $cantCertificados=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,38,$codigoIAF,1);
                    $participacionNorma=0;
                    if($cantCertificadosUnidad>0){
                      $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                    }                    
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberDec($participacionNorma);?></th>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">Totales</th>
                    <?php
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantCertificadosUnidad=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,38,0,1);
                      $cantCertificados=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,38,0,1);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt(100);?></th>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,38,0,1);
                    $cantCertificados=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,38,0,1);
                    $participacionNorma=0;
                    if($cantCertificadosUnidad>0){
                      $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                    }                    
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberDec($participacionNorma);?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-2">
        </div>
          
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Certificados Emitidos Por Sector IAF</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartCertificadosIAF.php");
              ?>
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->



    </div>
  </div>
</div>