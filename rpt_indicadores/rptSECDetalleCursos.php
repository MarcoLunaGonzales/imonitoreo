<?php
error_reporting(E_ALL);
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();

$mesTemporal=$_GET["mes"];
$nombreMes=nameMes($mesTemporal);
$anioTemporal=$_GET["anio"];
$codArea=$_GET["codArea"];
$codUnidad=$_GET["codUnidad"];

$nombreArea=nameArea($codArea);


$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$_SESSION['anioTemporal']=$anioTemporal;
$_SESSION['mesTemporal']=$mesTemporal;

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=27");
$stmt->execute();
$cadenaEstados="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $cadenaEstados=$row['valor_configuracion'];
}

?>

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="header text-center">
        <h3 class="title">Detalle Cursos <?=$nombreArea;?></h3>
        <h6>Año: <?=$anioTemporal;?> Mes: <?=$mesTemporal;?></h6>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-primary">
              <div class="card-icon">
                <i class="material-icons">list</i>
              </div>
              <h4 class="card-title">Detalle de Cursos
              </h4>
            </div>
            
            <div class="card-body">
              <table width="100%" class="table table-condensed" id="mainX">
                <thead>
                  <tr>
                    <th class="text-center">Indice</th>
                    <th class="text-center font-weight-bold small">Oficina</th>
                    <th class="text-center font-weight-bold small">Programa</th>
                    <th class="text-center font-weight-bold small">Codigo</th>
                    <th class="text-center font-weight-bold small">Tipo</th>
                    <th class="text-center font-weight-bold small">Curso</th>
                    <th class="text-center font-weight-bold small">Estado</th>
                    <th class="text-center font-weight-bold small">Empresa</th>
                    <th class="text-center font-weight-bold small"># Modulo</th>
                    <th class="text-center font-weight-bold small">Inicio</th>
                    <th class="text-center font-weight-bold small">Fin</th>
                    <!--th class="text-center font-weight-bold small"># Alumnos</th-->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql="SELECT eac.d_oficina, eac.d_programa, eac.cod_curso, eac.d_tipo, eac.nombre_curso, eac.estado, eac.d_empresa, eac.nromodulo, eac.nombre_curso, eac.fechainicio, eac.fechafin, count(*)as cuenta from ext_alumnos_cursos eac where eac.cod_curso not in ('') and YEAR(eac.fechainicio)='$anioTemporal' and MONTH(eac.fechainicio)<='$mesTemporal' GROUP BY eac.d_oficina, eac.cod_curso, eac.idmodulo";

                  
                  //echo $sql;
                  
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('d_oficina', $nombreOficina);
                  $stmt->bindColumn('d_programa', $nombrePrograma);
                  $stmt->bindColumn('cod_curso', $codigoCurso);
                  $stmt->bindColumn('d_tipo', $tipoCurso);
                  $stmt->bindColumn('nombre_curso', $nombreCurso);
                  //$stmt->bindColumn('cantidad_modulos', $cantidadModulos);
                  $stmt->bindColumn('estado', $estadoCurso);
                  $stmt->bindColumn('d_empresa', $empresaCurso);
                  $stmt->bindColumn('nromodulo', $nroModulo);
                  $stmt->bindColumn('fechainicio', $fechaInicio);
                  $stmt->bindColumn('fechafin', $fechaFin);
                  $stmt->bindColumn('cuenta', $numeroAlumnos);

                  $indice=1;
                  $totalAlumnosCursos=0;
                  while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-center small"><?=$indice?></td>
                    <td class="text-left small"><?=$nombreOficina;?></td>
                    <td class="text-left small"><?=$nombrePrograma;?></td>
                    <td class="text-left small"><?=$codigoCurso;?></td>
                    <td class="text-left small"><?=$tipoCurso;?></td>
                    <td class="text-left small"><?=$nombreCurso;?></td>
                    <td class="text-left small"><?=$estadoCurso;?></td>
                    <td class="text-left small"><?=$empresaCurso;?></td>
                    <td class="text-left small"><?=$nroModulo;?></td>
                    <td class="text-left small"><?=$fechaInicio;?></td>
                    <td class="text-left small"><?=$fechaFin;?></td>
                    <!--td class="text-right small"><?=$numeroAlumnos;?></td-->
                </tr>
                <?php
                  $indice++;
                  $totalAlumnosCursos=$totalAlumnosCursos+$numeroAlumnos;
                }
                ?>
            </tbody>
            <!--tfoot>
              <tr>
                <th>-</th>
                <th class="text-center font-weight-bold" colspan="15">Totales</th>
                <th class="text-right font-weight-bold text-primary"><?=$totalAlumnosCursos;?></th>
              </tr>
            </tfoot-->
          </table>
        </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>