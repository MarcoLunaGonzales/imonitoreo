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
$codArea=$_GET["codArea"];
$nombreArea=nameArea($codArea);


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
        <h3 class="title">Indicadores <?=$nombreArea;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title"># de Cursos y Estudiantes por Unidad Organizacional
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold" colspan="2"><?=$nombreMes?></th>
                    <th class="text-center font-weight-bold" colspan="2">Acum. <?=$nombreMes?></th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold">#Cursos</th>
                    <th class="text-center font-weight-bold">#Alumnos</th>
                    <th class="text-center font-weight-bold">#Cursos</th>
                    <th class="text-center font-weight-bold">#Alumnos</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  $totalCursos=0;
                  $totalCursosAcum=0;
                  $totalAlumnos=0;
                  $totalAlumnosAcum=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $numeroCursos=cursosPorUnidad($codigoX,$anioTemporal,$mesTemporal,0,'');
                    $numeroAlumnos=alumnosPorUnidad($codigoX,$anioTemporal,$mesTemporal,0,'');
                    $numeroCursosAcum=cursosPorUnidad($codigoX,$anioTemporal,$mesTemporal,1,'');
                    $numeroAlumnosAcum=alumnosPorUnidad($codigoX,$anioTemporal,$mesTemporal,1,'');

                    $totalCursos+=$numeroCursos;
                    $totalCursosAcum+=$numeroCursosAcum;
                    $totalAlumnos+=$numeroAlumnos;
                    $totalAlumnosAcum+=$numeroAlumnosAcum;
                  ?>
                  <tr>
                    <td class="text-left"><a href="rptSECxUnidad.php?codArea=<?=$codArea;?>&codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>" target="_blank"><?=$abrevX;?></a>
                    </td>
                    <td class="text-right"><?=formatNumberInt($numeroCursos);?></td>
                    <td class="text-right"><?=formatNumberInt($numeroAlumnos);?></td>
                    <td class="text-right"><a href="rptSECDetalle.php?codArea=<?=$codArea;?>&codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>" target="_blank"><?=formatNumberInt($numeroCursosAcum);?></a></td>
                    <td class="text-right"><a href="rptSECDetalle.php?codArea=<?=$codArea;?>&codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>" target="_blank"><?=formatNumberInt($numeroAlumnosAcum);?></a></td>
                  </tr>
                  <?php
                  }
                  ?>                  
                </tbody>
                <tfooter>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalCursos);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalAlumnos);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalCursosAcum);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalAlumnosAcum);?></td>
                  </tr>
                </tfooter>
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
              <h5 class="card-title"># de Cursos y Alumnos</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartCursosAlumnos.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->
        


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Ingresos y Egresos
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold" colspan="3"><?=$nombreMes?></th>
                    <th class="text-center font-weight-bold" colspan="3">Acum. <?=$nombreMes?></th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold">Ingresos</th>
                    <th class="text-center font-weight-bold">Egresos</th>
                    <th class="text-center font-weight-bold">Resultado</th>
                    <th class="text-center font-weight-bold">Ingresos</th>
                    <th class="text-center font-weight-bold">Egresos</th>
                    <th class="text-center font-weight-bold">Resultado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  $totalIngresos=0;
                  $totalIngresosAcum=0;
                  $totalEgresos=0;
                  $totalEgresosAcum=0;
                  $totalResultado=0;
                  $totalResultadoAcum=0;

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $codFondo=obtenerFondosReport($codigoX);
                    $codOrganismo=obtenerOrganismosReport($codArea);
                    
                    $ingresosMes=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                    $ingresosMesAcum=ejecutadoIngresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);

                    $egresosMes=ejecutadoEgresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,0,0);
                    $egresosMesAcum=ejecutadoEgresosMes($codFondo,$anioTemporal,$mesTemporal,$codOrganismo,1,0);

                    $resultado=$ingresosMes-$egresosMes;
                    $resultadoAcum=$ingresosMesAcum-$egresosMesAcum;

                    $totalIngresos+=$ingresosMes;
                    $totalIngresosAcum+=$ingresosMesAcum;
                    $totalEgresos+=$egresosMes;
                    $totalEgresosAcum+=$egresosMesAcum;
                    $totalResultado+=$resultado;
                    $totalResultadoAcum+=$resultadoAcum;

                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><?=formatNumberInt($ingresosMes);?></td>
                    <td class="text-right"><?=formatNumberInt($egresosMes);?></td>
                    <td class="text-right font-weight-bold text-primary"><?=formatNumberInt($resultado);?></td>
                    <td class="text-right"><?=formatNumberInt($ingresosMesAcum);?></td>
                    <td class="text-right"><?=formatNumberInt($egresosMesAcum);?></td>
                    <td class="text-right font-weight-bold text-primary"><?=formatNumberInt($resultadoAcum);?></td>
                  </tr>
                  <?php
                  }
                  ?>                  
                </tbody>
                <tfooter>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalIngresos);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalEgresos);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalResultado);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalIngresosAcum);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalEgresosAcum);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalResultadoAcum);?></td>
                  </tr>
                </tfooter>
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
              <h5 class="card-title">Ingresos y Egresos</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartIngEgSEC.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->  


      <?php
      
      $tipoCursoCorto=obtieneValorConfig(12);
      $tipoCursoEspecialista=obtieneValorConfig(13);

      ?>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Cantidad de Cursos Por Tipo
              </h4>
            </div>
            
            <?php
            $sqlC="SELECT count(distinct(e.tipo))as contador from ext_cursos e order by 1";
            $stmtC = $dbh->prepare($sqlC);
            $stmtC->execute();
            $stmtC->bindColumn('contador', $countColumn);

            while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
              $cantTipoCurso=$countColumn;
            }
      
            ?>            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold" colspan="<?=$cantTipoCurso;?>"><?=$nombreMes?></th>
                    <th class="text-center font-weight-bold" colspan="<?=$cantTipoCurso;?>">Acum. <?=$nombreMes?></th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <?php
                    $sqlC="SELECT distinct(e.tipo)as tipo from ext_cursos e order by 1";
                    $stmtC = $dbh->prepare($sqlC);
                    $stmtC->execute();
                    $stmtC->bindColumn('tipo', $tipoCurso);
                    while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                      $tipoCursoX=$tipoCurso;
                    ?>
                    <th class="text-center font-weight-bold"><?=$tipoCursoX;?></th>
                    <?php
                    }
                    ?>
                    <th class="text-center font-weight-bold">Total</th>
                    <?php
                    $stmtC->execute();
                    $stmtC->bindColumn('tipo', $tipoCurso);
                    while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                      $tipoCursoX=$tipoCurso;
                    ?>
                    <th class="text-center font-weight-bold"><?=$tipoCursoX;?></th>
                    <?php
                    }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  $totalCursosCortos=0;
                  $totalCursosEspe=0;
                  $totalCursosCortosAcum=0;
                  $totalCursosEspeAcum=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                  ?>  
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                  <?php
                    $sqlC="SELECT distinct(e.tipo)as tipo from ext_cursos e order by 1";
                    $stmtC = $dbh->prepare($sqlC);
                    $stmtC->execute();
                    $stmtC->bindColumn('tipo', $tipoCurso);
                    $totalCursos=0;
                    while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                      $tipoCursoX=$tipoCurso;
                      $numeroCursos=cursosPorUnidad($codigoX,$anioTemporal,$mesTemporal,0,$tipoCursoX);
                      $totalCursos+=$numeroCursos;                
                  ?>
                    <td class="text-right"><?=formatNumberInt($numeroCursos);?></td>
                  <?php
                    }
                  ?>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalCursos);?></td>
                  <?php
                    $sqlC="SELECT distinct(e.tipo)as tipo from ext_cursos e order by 1";
                    $stmtC = $dbh->prepare($sqlC);
                    $stmtC->execute();
                    $stmtC->bindColumn('tipo', $tipoCurso);
                    $totalCursoAcum=0;
                    while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                      $tipoCursoX=$tipoCurso;
                      $numeroCursos=cursosPorUnidad($codigoX,$anioTemporal,$mesTemporal,1,$tipoCursoX);
                      $totalCursoAcum+=$numeroCursos;      
                  ?>
                    <td class="text-right"><?=formatNumberInt($numeroCursos);?></td>                  
                  <?php
                    }
                  ?>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalCursoAcum);?></td>
                  </tr>
                  <?php
                  }
                  ?>                  
                </tbody>
                <tfooter>
                  <tr>
                    <th>Totales</th>
                  </tr>
                </tfooter>
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
              <h5 class="card-title">Cantidad de Cursos por Tipo</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              require("chartCursosTipo.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->  




      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Incremento de Clientes (# Alumnos)
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal-1;?></th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal;?></th>
                    <th class="text-center font-weight-bold">% Incremento</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);
                  $totalClientesAnt=0;
                  $totalClientes=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadClientesAnt=calcularClientesSECPeriodo($codigoX,$codArea,$mesTemporal,$anioTemporal-1);
                    $cantidadClientes=calcularClientesSECPeriodo($codigoX,$codArea,$mesTemporal,$anioTemporal);
                    $porcentajeCrec=0;
                    if($cantidadClientesAnt>0){
                      $porcentajeCrec=(($cantidadClientes-$cantidadClientesAnt)/$cantidadClientesAnt)*100;
                    }
                    $totalClientesAnt+=$cantidadClientesAnt;
                    $totalClientes+=$cantidadClientes;
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadClientesAnt);?></a></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadClientes);?></a></td>
                    <td class="text-center font-weight-bold text-primary"><?=formatNumberInt($porcentajeCrec);?> %</td>
                  </tr>
                  <?php
                  }
                  $porcentajeCrecTotal=0;
                  if($totalClientesAnt>0){
                    $porcentajeCrecTotal=(($totalClientes-$totalClientesAnt)/$totalClientesAnt)*100;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientesAnt);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientes);?></td>
                    <td class="text-center font-weight-bold"><?=formatNumberInt($porcentajeCrecTotal);?> %</td>
                  </tr>
                </tfoot>
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
              <h5 class="card-title">Retencion de Clientes (# Alumnos)</h5>
            </div>
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                    <th class="text-center font-weight-bold"><?=$mesTemporal;?>.<?=$anioTemporal;?></th>
                    <th class="text-center font-weight-bold">Clientes Retenidos</th>
                    <th class="text-center font-weight-bold">% Retencion</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);
                  $totalClientesRetenidos=0;
                  $totalClientes=0;
                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadClientes=calcularClientesSECPeriodo($codigoX,$codArea,$mesTemporal,$anioTemporal);
                    $cantidadRetenidos=calcularClientesSECRetenidos($codigoX,$codArea,$mesTemporal,$anioTemporal);
                    $porcentajeCrec=0;
                    if($cantidadClientes>0){
                      $porcentajeCrec=($cantidadRetenidos/$cantidadClientes)*100;
                    }
                    $totalClientesRetenidos+=$cantidadRetenidos;
                    $totalClientes+=$cantidadClientes;
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadClientes);?></a></td>
                    <td class="text-right"><a href="rptIncrementoClientes.php?codUnidad=<?=$codigoX;?>&mes=<?=$mesTemporal;?>&anio=<?=$anioTemporal;?>&codArea=<?=$codArea;?>" target="_blank"><?=formatNumberInt($cantidadRetenidos);?></a></td>
                    <td class="text-center font-weight-bold text-primary"><?=formatNumberInt($porcentajeCrec);?> %</td>
                  </tr>
                  <?php
                  }
                  $porcentajeCrecTotal=0;
                  if($totalClientes>0){
                    $porcentajeCrecTotal=($totalClientesRetenidos/$totalClientes)*100;
                  }
                  ?>                  
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientes);?></td>
                    <td class="text-right font-weight-bold"><?=formatNumberInt($totalClientesRetenidos);?></td>
                    <td class="text-center font-weight-bold"><?=formatNumberInt($porcentajeCrecTotal);?> %</td>
                  </tr>
                </tfoot>
              </table>
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
              <h4 class="card-title">Alumnos por Grupo Etario
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold" colspan="14">Acum. <?=$nombreMes?></th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">Unidad</th>
                  <?php
                  $sqlGrupo="SELECT g.codigo, g.minimo, g.maximo FROM grupos_etarios g order by 1";
                  $stmtGrupo = $dbh->prepare($sqlGrupo);
                  $stmtGrupo->execute();
                  $stmtGrupo->bindColumn('codigo', $codigoG);
                  $stmtGrupo->bindColumn('minimo', $edadMinimo);
                  $stmtGrupo->bindColumn('maximo', $edadMaximo);

                  while($rowGrupo = $stmtGrupo -> fetch(PDO::FETCH_BOUND)){
                  ?>
                    <th class="text-center font-weight-bold" colspan="2"><?=$edadMinimo;?>-<?=$edadMaximo;?></th>
                  <?php
                  }
                  ?>
                    <th class="text-center font-weight-bold" colspan="2">Totales</th>
                  </tr>

                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                  <?php
                  $sqlGrupo="SELECT g.codigo, g.minimo, g.maximo FROM grupos_etarios g order by 1";
                  $stmtGrupo = $dbh->prepare($sqlGrupo);
                  $stmtGrupo->execute();
                  $stmtGrupo->bindColumn('codigo', $codigoG);
                  $stmtGrupo->bindColumn('minimo', $edadMinimo);
                  $stmtGrupo->bindColumn('maximo', $edadMaximo);

                  while($rowGrupo = $stmtGrupo -> fetch(PDO::FETCH_BOUND)){
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
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $cantidadAlumnosUnidad=alumnosPorUnidad($codigoX,$anioTemporal,$mesTemporal,1,'');
                  ?>
                  <tr>
                    <td class="text-left"><?=$abrevX;?></td>
                    <?php
                    $sqlGrupo="SELECT g.codigo, g.minimo, g.maximo FROM grupos_etarios g order by 1";
                    $stmtGrupo = $dbh->prepare($sqlGrupo);
                    $stmtGrupo->execute();
                    $stmtGrupo->bindColumn('codigo', $codigoG);
                    $stmtGrupo->bindColumn('minimo', $edadMinimo);
                    $stmtGrupo->bindColumn('maximo', $edadMaximo);
                    while($rowGrupo = $stmtGrupo -> fetch(PDO::FETCH_BOUND)){
                      $cantidadAlumnos=calcularAlumnosGrupoEtario($codigoX,$codArea,$mesTemporal,$anioTemporal,$edadMinimo,$edadMaximo);
                      $porcentajeAlumnos=0;

                      if($cantidadAlumnosUnidad>0){
                        $porcentajeAlumnos=($cantidadAlumnos/$cantidadAlumnosUnidad)*100;
                      }

                    ?>
                    <td class="text-right"><?=formatNumberInt($cantidadAlumnos);?></td>
                    <td class="text-right text-primary"><?=formatNumberDec($porcentajeAlumnos);?></td>
                    <?php
                    }
                    ?> 
                    <td class="text-right"><?=formatNumberInt($cantidadAlumnosUnidad);?></td>
                    <td class="text-right text-primary"><?=formatNumberDec(100);?></td>                  
                  </tr>
                </tbody>
                  <?php
                  }
                  ?>
                <tfooter>
                  <tr>
                    <td class="text-left font-weight-bold">Totales</td>
                    <?php
                    $sqlGrupo="SELECT g.codigo, g.minimo, g.maximo FROM grupos_etarios g order by 1";
                    $stmtGrupo = $dbh->prepare($sqlGrupo);
                    $stmtGrupo->execute();
                    $stmtGrupo->bindColumn('codigo', $codigoG);
                    $stmtGrupo->bindColumn('minimo', $edadMinimo);
                    $stmtGrupo->bindColumn('maximo', $edadMaximo);
                    while($rowGrupo = $stmtGrupo -> fetch(PDO::FETCH_BOUND)){
                      $cantidadAlumnosUnidad=alumnosPorUnidad(0,$anioTemporal,$mesTemporal,1,'');
                      $cantidadAlumnos=calcularAlumnosGrupoEtario(0,$codArea,$mesTemporal,$anioTemporal,$edadMinimo,$edadMaximo);
                      $porcentajeAlumnos=($cantidadAlumnos/$cantidadAlumnosUnidad)*100;                      
                    ?>
                    <th class="text-right"><?=formatNumberInt($cantidadAlumnos);?></th>
                    <th class="text-right text-primary"><?=formatNumberDec($porcentajeAlumnos);?></th>
                    <?php
                    }
                    ?>   
                    <th class="text-right"><?=formatNumberInt($cantidadAlumnosUnidad);?></th>
                    <th class="text-right text-primary"><?=formatNumberDec(100);?></th>
                  </tr>
                </tfooter>
              </table>
            </div>
          </div>
        </div>

        <!--div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-info">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <h5 class="card-title">Ingresos y Egresos</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              //require("chartIngEgSEC.php");
              ?>
            </div>
          </div>
        </div-->

      </div><!--ACA TERMINA ROW-->  



    </div>
  </div>
</div>

<script type="text/javascript">
  totalesRptSec();
</script>