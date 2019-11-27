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
$codArea=$_GET["codArea"];
$nombreArea=nameArea($codArea);
$codUnidad=$_GET["codUnidad"];
$nombreUnidad=nameUnidad($codUnidad);


$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;


?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Indicadores <?=$nombreArea;?> - <?=$nombreUnidad;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title"># de Cursos y Estudiantes por Tipo de Curso
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
                    <th class="text-center font-weight-bold">Tipo de Curso</th>
                    <th class="text-center font-weight-bold">#Cursos</th>
                    <th class="text-center font-weight-bold">#Alumnos</th>
                    <th class="text-center font-weight-bold">#Cursos</th>
                    <th class="text-center font-weight-bold">#Alumnos</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $sqlC="SELECT distinct(e.tipo)as tipo from ext_cursos e order by 1";
                  $stmtC = $dbh->prepare($sqlC);
                  $stmtC->execute();
                  $stmtC->bindColumn('tipo', $tipoCurso);
                  $totalCursos=0;
                  $totalCursosAcum=0;
                  $totalAlumnos=0;
                  $totalAlumnosAcum=0;
                  
                  while($rowC = $stmtC -> fetch(PDO::FETCH_BOUND)){
                    $tipoCursoX=$tipoCurso;
                  
                    $numeroCursos=cursosPorUnidad($codUnidad,$anioTemporal,$mesTemporal,0,$tipoCursoX);
                    $numeroAlumnos=alumnosPorUnidad($codUnidad,$anioTemporal,$mesTemporal,0,$tipoCursoX);
                    $numeroCursosAcum=cursosPorUnidad($codUnidad,$anioTemporal,$mesTemporal,1,$tipoCursoX);
                    $numeroAlumnosAcum=alumnosPorUnidad($codUnidad,$anioTemporal,$mesTemporal,1,$tipoCursoX);

                    $totalCursos+=$numeroCursos;
                    $totalCursosAcum+=$numeroCursosAcum;
                    $totalAlumnos+=$numeroAlumnos;
                    $totalAlumnosAcum+=$numeroAlumnosAcum;

                    $urlCursos="rptIndicadoresCursos.php?gestion=$anioTemporal&mes=$mesTemporal&unidad_organizacional=$codUnidad&tipocursos=$tipoCursoX";
                  ?>
                  <tr>
                    <td class="text-left"><?=$tipoCursoX;?></td>
                    <td class="text-right"><a href="<?=$urlCursos;?>&ver=0" target="_blank"><?=formatNumberInt($numeroCursos);?></a></td>
                    <td class="text-right"><?=formatNumberInt($numeroAlumnos);?></td>
                    <td class="text-right"><a href="<?=$urlCursos;?>&ver=1" target="_blank"><?=formatNumberInt($numeroCursosAcum);?></a></td>
                    <td class="text-right"><?=formatNumberInt($numeroAlumnosAcum);?></td>
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
              <h5 class="card-title"># de Cursos y Estudiantes por Tipo de Curso</h5>
            </div>
            <div class="card-body">
              <?php
              $codAreaX=$codArea;
              $anioX=$anioTemporal;
              $mesX=$mesTemporal;
              $codUnidadX=$codUnidad;
              require("chartCursosTipoUnidad.php");
              ?>
            </div>
          </div>
        </div>

      </div><!--ACA TERMINA ROW-->         


    </div>
  </div>
</div>


<script type="text/javascript">
  totalesRptSec();
</script>