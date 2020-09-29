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
$vista=$_GET["vista"];//VISTA ==1 EMITIDOS ==2 VIGENTES

$nombreVista="";
if($vista==1){
  $nombreVista="CERTIFICADOS EMITIDOS";
}else{
  $nombreVista="CERTIFICADOS VIGENTES";
}

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

//SACAMOS LA CONFIG PARA OMITIR LOS CERTIFICADOR R.M.
$txtOmitirRM=obtieneValorConfig(30);

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Reporte de Certificaciones</h3>
        <h3 class="title"><?=$nombreVista;?></h3>
        <h3>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h3>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Empresas
              </h4>
            </div>
            
            <div class="card-body">
              <?php
                $cadenaUnidades=$cadenaUnidades;
                $anioTemporal=$anioTemporal;
                $mesTemporal=$mesTemporal;
                $vista=$vista;
                if($vista==1){
                  require("rptTablaCertEmpresa.php");
                }
                if($vista==2){
                  require("rptTablaCertVigentesEmpresa.php");
                }
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
              <h5 class="card-title">Empresas Certificadas (Participacion por Oficina Regional)</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $vistaX=$vista;
              require("chartEmpresasCertificadas.php");
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
              <h5 class="card-title">Certificados (Participacion por Oficina Regional)</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $vistaX=$vista;
              require("chartCertificadosEmitidos.php");
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
              <h4 class="card-title">Certificados
              </h4>
            </div>            
            <div class="card-body">
             
              <?php
                $cadenaUnidades=$cadenaUnidades;
                $anioTemporal=$anioTemporal;
                $mesTemporal=$mesTemporal;
                $vista=$vista;
                if($vista==1){
                  require("rptTablaCertificados.php");
                }
                if($vista==2){
                  require("rptTablaCertificadosVigentes.php");
                }
              ?>

            </div>
          </div>
        </div>

        <div class="col-md-3">
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title"># Empresas y Certificados por Oficina Regional</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $vistaX=$vista;
              require("chartEmpresasCertificados.php");
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
              <h5 class="card-title">Historico Certificados</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $vistaX=$vista;
              require("chartCertificadosHistorico.php");
              ?>
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->


      <?php
      
      $arrayAreas = array(38,39);
      $longitud = count($arrayAreas);

      for($i=0; $i<$longitud; $i++){

      $areaCertificacion=$arrayAreas[$i];
      $nameAreaCertificacion=abrevArea($areaCertificacion);

      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title"><?=$nameAreaCertificacion;?> - Certificados Por Norma
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main<?=$areaCertificacion?>">
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
                    $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
                    $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
                    $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));

                  $sqlN="SELECT e.norma, count(*)as cantidad from ext_certificados e where e.norma not in ('N/A','') and 
                  e.norma not like '%$txtOmitirRM%' ";
                  if($vista==1){
                    $sqlN.=" and YEAR(e.fechaemision)=$anioTemporal ";
                  }else{
                    $sqlN.=" and e.fechaemision<='$fechaVistaIni' and e.fechavalido>='$fechaVistaFin' ";
                  }

                  $sqlN.=" and e.idarea='$areaCertificacion' group by e.norma order by 2 desc";
                  
                  //echo $sqlN;
                  
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
                      $cantCertificadosUnidad=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,'',1,$vista);
                      $cantCertificados=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,$nombreNorma,1,$vista);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                      $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=$codigoX&mes=$mesTemporal&anio=$anioTemporal&iaf=0&certificador=0&acumulado=1&codArea=$areaCertificacion";

                    ?>
                    <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&norma=<?=$nombreNorma;?>" target="_blank"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></a></td>
                    <td class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt($participacionNorma);?></td>
                    <?php
                    }
                    $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=0&mes=$mesTemporal&anio=$anioTemporal&iaf=0&certificador=0&acumulado=1&codArea=38";

                    $cantCertificadosUnidad=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,$areaCertificacion,'',1,$vista);
                    $cantCertificados=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,$areaCertificacion,$nombreNorma,1,$vista);
                    $participacionNorma=0;
                    if($cantCertificadosUnidad>0){
                      $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                    }                    
                    ?>
                    <th class="table-warning text-center"><a href="<?=$urlDetalle;?>&norma=<?=$nombreNorma;?>" target="_blank"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></a></th>
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
                      $cantCertificadosUnidad=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,'',1,$vista);
                      $cantCertificados=obtenerCantCertificadosNorma($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,'',1,$vista);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt(100);?></th>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,$areaCertificacion,'',1,$vista);
                    $cantCertificados=obtenerCantCertificadosNorma(0,$anioTemporal,$mesTemporal,$areaCertificacion,'',1,$vista);
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
              <h5 class="card-title">TCS - Certificados por Norma</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $vistaX=$vista;
              $codAreaX=$areaCertificacion;
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
              <h4 class="card-title"><?=$nameAreaCertificacion;?> - Certificados Por Sector IAF
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main<?=$areaCertificacion?>">
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
                  $sqlN="SELECT e.iaf, count(*)as cantidad from ext_certificados e where e.norma not in ('N/A') ";
                  if($vista==1){
                    $sqlN.=" and YEAR(e.fechaemision)=$anioTemporal ";
                  }else{
                    $sqlN.=" and e.fechaemision<='$fechaVistaIni' and e.fechavalido>='$fechaVistaFin' ";
                  }
                  $sqlN.=" and e.idarea='$areaCertificacion' group by e.iaf order by 2 desc ";
                  $stmtN = $dbh->prepare($sqlN);
                  $stmtN->execute();
                  $stmtN->bindColumn('iaf', $codigoIAF);
                  $stmtN->bindColumn('cantidad', $cantidadNorma);


                  while($rowN = $stmtN -> fetch(PDO::FETCH_BOUND)){
                    $nombreIAF="Sin Código IAF";
                    if($codigoIAF>0){
                      $nombreIAF=nameIAF($codigoIAF);                    
                    }
                  ?>
                  <tr>
                    <td class="text-left"><?=$nombreIAF;?>.(<?=$codigoIAF;?>)</td>
                    <?php
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);
                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantCertificadosUnidad=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,-1,1,$vista);
                      $cantCertificados=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,$codigoIAF,1,$vista);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }

                      $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=$codigoX&mes=$mesTemporal&anio=$anioTemporal&norma=&certificador=0&acumulado=1&codArea=$areaCertificacion";

                    ?>
                    <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&iaf=<?=$codigoIAF;?>" target="_blank"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></a></td>
                    <td class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt($participacionNorma);?></td>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,$areaCertificacion,-1,1,$vista);
                    $cantCertificados=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,$areaCertificacion,$codigoIAF,1,$vista);
                    $participacionNorma=0;
                    if($cantCertificadosUnidad>0){
                      $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                    } 
                    $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=0&mes=$mesTemporal&anio=$anioTemporal&norma=&certificador=0&acumulado=1&codArea=$areaCertificacion";
                    ?>
                    <th class="table-warning text-center"><a href="<?=$urlDetalle;?>&iaf=<?=$codigoIAF;?>" target="_blank"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></a></th>
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
                      $cantCertificadosUnidad=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,-1,1,$vista);
                      $cantCertificados=obtenerCantCertificadosIAF($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,-1,1,$vista);
                      $participacionNorma=0;
                      if($cantCertificadosUnidad>0){
                        $participacionNorma=($cantCertificados/$cantCertificadosUnidad)*100;
                      }
                    ?>
                    <th class="table-warning text-center"><?=($cantCertificados==0)?"-":formatNumberInt($cantCertificados);?></th>
                    <th class="table-primary text-center"><?=($participacionNorma==0)?"-":formatNumberInt(100);?></th>
                    <?php
                    }
                    $cantCertificadosUnidad=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,$areaCertificacion,-1,1,$vista);
                    $cantCertificados=obtenerCantCertificadosIAF(0,$anioTemporal,$mesTemporal,$areaCertificacion,-1,1,$vista);
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
              <h5 class="card-title"><?=$nameAreaCertificacion;?> - Certificados Por Sector IAF</h5>
            </div>
            <div class="card-body">
              <?php
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $vistaX=$vista;
              $codAreaX=$areaCertificacion;
              require("chartCertificadosIAF.php");
              ?>
            </div>
          </div>
        </div>
      </div><!--ACA TERMINA ROW-->


      <!--CERTIFICADOS EMITIDOS POR ORGANISMO CERTIFICADOR-->
      <?php
        if($areaCertificacion==38){
      ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-icon card-header-primary">
                <div class="card-icon">
                  <i class="material-icons">list</i>
                </div>
                <h4 class="card-title"><?=$nameAreaCertificacion;?> - Certificados por Certificador
                </h4>
              </div>
              
              <div class="card-body">
                <table width="100%" class="table table-condensed" id="main<?=$areaCertificacion?>">
                  <thead>
                    <tr>
                      <th class="text-center font-weight-bold">Unidad O.</th>
                      <th class="text-center font-weight-bold" colspan="4">AFNOR</th>
                      <th class="text-center font-weight-bold" colspan="4">IBNORCA</th>
                    </tr>
                    <tr>
                      <th class="text-center font-weight-bold">-</th>
                      <th class="text-center font-weight-bold"># Emp</th>
                      <th class="text-center font-weight-bold">% Emp</th>
                      <th class="text-center font-weight-bold"># Cert</th>
                      <th class="text-center font-weight-bold">% Cert</th>

                      <th class="text-center font-weight-bold"># Emp</th>
                      <th class="text-center font-weight-bold">% Emp</th>
                      <th class="text-center font-weight-bold"># Cert</th>
                      <th class="text-center font-weight-bold">% Cert</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $organismoExtCert="641";//AFNOR
                    $organismoCert="804";
                    $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                    $stmtU = $dbh->prepare($sqlU);
                    $stmtU->execute();
                    $stmtU->bindColumn('codigo', $codigoX);
                    $stmtU->bindColumn('abreviatura', $abrevX);

                    while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                      $cantEmpresasOrg=obtenerCantEmpresasOrganismo($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoExtCert,1,$vista);
                      $cantEmpresasOrgTotal=obtenerCantEmpresasOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoExtCert,1,$vista);
                      $porcentajeEmpresas=0;
                      if($cantEmpresasOrgTotal>0){
                        $porcentajeEmpresas=($cantEmpresasOrg/$cantEmpresasOrgTotal)*100;
                      }

                      $cantCertificadosOrg=obtenerCantCertificadosOrganismo($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoExtCert,1,$vista);
                      $cantCertificadosOrgTotal=obtenerCantCertificadosOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoExtCert,1,$vista);
                      $porcentajeCertificados=0;
                      if($cantEmpresasOrgTotal>0){
                        $porcentajeCertificados=($cantCertificadosOrg/$cantCertificadosOrgTotal)*100;
                      }

                      $cantEmpresasOrg1=obtenerCantEmpresasOrganismo($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoCert,1,$vista);
                      $cantEmpresasOrgTotal1=obtenerCantEmpresasOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoCert,1,$vista);
                      $porcentajeEmpresas1=0;
                      if($cantEmpresasOrgTotal1>0){
                        $porcentajeEmpresas1=($cantEmpresasOrg1/$cantEmpresasOrgTotal1)*100;
                      }

                      $cantCertificadosOrg1=obtenerCantCertificadosOrganismo($codigoX,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoCert,1,$vista);
                      $cantCertificadosOrgTotal1=obtenerCantCertificadosOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoCert,1,$vista);
                      $porcentajeCertificados1=0;
                      if($cantEmpresasOrgTotal1>0){
                        $porcentajeCertificados1=($cantCertificadosOrg1/$cantCertificadosOrgTotal1)*100;
                      }
                      $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=$codigoX&mes=$mesTemporal&anio=$anioTemporal&norma=&iaf=0&acumulado=1&codArea=$areaCertificacion";
                    ?>
                    <tr>
                      <td class="text-center"><?=$abrevX;?></td>
                      <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&certificador=<?=$organismoExtCert;?>" target="_blank"><?=($cantEmpresasOrg==0)?"-":formatNumberInt($cantEmpresasOrg);?></a></td>
                      <td class="table-primary text-center"><?=($porcentajeEmpresas==0)?"-":formatNumberInt($porcentajeEmpresas);?></td>
                      <td class="table-danger text-center"><a href="<?=$urlDetalle;?>&certificador=<?=$organismoExtCert;?>" target="_blank"><?=($cantCertificadosOrg==0)?"-":formatNumberInt($cantCertificadosOrg);?></td>
                      <td class="table-success text-center"><?=($porcentajeCertificados==0)?"-":formatNumberInt($porcentajeCertificados);?></a></td>

                      <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&certificador=<?=$organismoCert;?>" target="_blank"><?=($cantEmpresasOrg1==0)?"-":formatNumberInt($cantEmpresasOrg1);?></a></td>
                      <td class="table-primary text-center"><?=($porcentajeEmpresas1==0)?"-":formatNumberInt($porcentajeEmpresas1);?></td>
                      <td class="table-danger text-center"><a href="<?=$urlDetalle;?>&certificador=<?=$organismoCert;?>" target="_blank"><?=($cantCertificadosOrg1==0)?"-":formatNumberInt($cantCertificadosOrg1);?></a></td>
                      <td class="table-success text-center"><?=($porcentajeCertificados1==0)?"-":formatNumberInt($porcentajeCertificados1);?></td>
                    </tr>
                    <?php
                    }
                    $cantEmpresasOrgTotal=obtenerCantEmpresasOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoExtCert,1,$vista);
                    $porcentajeEmpresas=100;
                    $cantCertificadosOrgTotal=obtenerCantCertificadosOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoExtCert,1,$vista);
                    $porcentajeCertificados=100;

                    $cantEmpresasOrgTotal1=obtenerCantEmpresasOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoCert,1,$vista);
                    $porcentajeEmpresas1=100;
                    $cantCertificadosOrgTotal1=obtenerCantCertificadosOrganismo(0,$anioTemporal,$mesTemporal,$areaCertificacion,$organismoCert,1,$vista);
                    $porcentajeCertificados1=100;
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th class="text-center">Totales</th>
                      <th class="table-warning text-center"><?=($cantEmpresasOrgTotal==0)?"-":formatNumberInt($cantEmpresasOrgTotal);?></th>
                      <th class="table-primary text-center"><?=formatNumberInt(100);?></th>
                      <th class="table-danger text-center"><?=($cantCertificadosOrgTotal==0)?"-":formatNumberInt($cantCertificadosOrgTotal);?></th>
                      <th class="table-success text-center"><?=formatNumberInt(100);?></th>

                      <th class="table-warning text-center"><?=($cantEmpresasOrgTotal1==0)?"-":formatNumberInt($cantEmpresasOrgTotal1);?></th>
                      <th class="table-primary text-center"><?=formatNumberInt(100);?></th>
                      <th class="table-danger text-center"><?=($cantCertificadosOrgTotal1==0)?"-":formatNumberInt($cantCertificadosOrgTotal1);?></th>
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
                <h5 class="card-title"><?=$nameAreaCertificacion;?> - Certificados Por Certificador</h5>
              </div>
              <div class="card-body">
                <?php
                $anioX=$anioTemporal;
                $mesX=$mesTemporal;
                $vistaX=$vista;
                $codAreaX=$areaCertificacion;
                require("chartCertificadosCertificador.php");
                ?>
              </div>
            </div>
          </div>

        </div><!--ACA TERMINA ROW-->

      <?php
        }
      }
      ?>


    </div>
  </div>
</div>