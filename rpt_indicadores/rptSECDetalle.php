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
              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center">Indice</th>
                    <th class="text-center font-weight-bold small">Oficina</th>
                    <th class="text-center font-weight-bold small">Programa</th>
                    <th class="text-center font-weight-bold small">Sigla</th>
                    <th class="text-center font-weight-bold small">Codigo</th>
                    <th class="text-center font-weight-bold small">Tipo</th>
                    <th class="text-center font-weight-bold small">Nombre</th>
                    <th class="text-center font-weight-bold small">Cant.<br>
                    Modulos</th>
                    <th class="text-center font-weight-bold small">Estado</th>
                    <th class="text-center font-weight-bold small">Costo</th>
                    <th class="text-center font-weight-bold small">Empresa</th>
                    <th class="text-center font-weight-bold small"># Modulo</th>
                    <th class="text-center font-weight-bold small">Tema</th>
                    <th class="text-center font-weight-bold small">Inicio</th>
                    <th class="text-center font-weight-bold small">Fin</th>
                    <th class="text-center font-weight-bold small">Docente</th>
                    <th class="text-center font-weight-bold small"># Alumnos</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql="SELECT (SELECT u.nombre from unidades_organizacionales u where u.codigo=e.id_oficina)oficina, (select p.nombre from programas p where p.codigo=e.id_programa)programa, e.sigla, e.codigocurso, e.tipo, e.nombre_curso, e.cantidad_modulos, e.estado, e.costo_modulo, e.empresa, e.nro_modulo, e.tema, e.fecha_inicio, e.fecha_fin, e.docente, e.alumnos_modulo from ext_alumnos_cursos eac, ext_cursos e where eac.cod_curso=e.codigocurso and e.id_oficina in ($codUnidad) and YEAR(e.fecha_inicio)='$anioTemporal' and MONTH(e.fecha_inicio)<='$mesTemporal' and e.gestion='$anioTemporal' and e.codigocurso not in ('')  and e.alumnos_modulo>0 GROUP BY e.codigocurso, e.nro_modulo";
                  
                  //echo $sql;
                  
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('oficina', $nombreOficina);
                  $stmt->bindColumn('programa', $nombrePrograma);
                  $stmt->bindColumn('sigla', $siglaCurso);
                  $stmt->bindColumn('codigocurso', $codigoCurso);
                  $stmt->bindColumn('tipo', $tipoCurso);
                  $stmt->bindColumn('nombre_curso', $nombreCurso);
                  $stmt->bindColumn('cantidad_modulos', $cantidadModulos);
                  $stmt->bindColumn('estado', $estadoCurso);
                  $stmt->bindColumn('costo_modulo', $costoModulo);
                  $stmt->bindColumn('empresa', $empresaCurso);
                  $stmt->bindColumn('nro_modulo', $nroModulo);
                  $stmt->bindColumn('tema', $temaCurso);
                  $stmt->bindColumn('fecha_inicio', $fechaInicio);
                  $stmt->bindColumn('fecha_fin', $fechaFin);
                  $stmt->bindColumn('docente', $docenteCurso);
                  $stmt->bindColumn('alumnos_modulo', $numeroAlumnos);

                  $indice=1;
                  $totalAlumnosCursos=0;
                  while($row = $stmt -> fetch(PDO::FETCH_BOUND)){
                  ?>
                  <tr>
                    <td class="text-center small"><?=$indice?></td>
                    <td class="text-left small"><?=$nombreOficina;?></td>
                    <td class="text-left small"><?=$nombrePrograma;?></td>
                    <td class="text-left small"><?=$siglaCurso;?></td>
                    <td class="text-left small"><?=$codigoCurso;?></td>
                    <td class="text-left small"><?=$tipoCurso;?></td>
                    <td class="text-left small"><?=$nombreCurso;?></td>
                    <td class="text-right small"><?=$cantidadModulos;?></td>
                    <td class="text-left small"><?=$estadoCurso;?></td>
                    <td class="text-right small"><?=$costoModulo;?></td>
                    <td class="text-left small"><?=$empresaCurso;?></td>
                    <td class="text-left small"><?=$nroModulo;?></td>
                    <td class="text-left small"><?=$temaCurso;?></td>
                    <td class="text-left small"><?=$fechaInicio;?></td>
                    <td class="text-left small"><?=$fechaFin;?></td>
                    <td class="text-left small"><?=$docenteCurso;?></td>
                    <td class="text-right small"><?=$numeroAlumnos;?></td>
                </tr>
                <?php
                  $indice++;
                  $totalAlumnosCursos=$totalAlumnosCursos+$numeroAlumnos;
                }
                ?>
            </tbody>
            <tfoot>
              <tr>
                <th>-</th>
                <th class="text-center font-weight-bold" colspan="15">Totales</th>
                <th class="text-right font-weight-bold text-primary"><?=$totalAlumnosCursos;?></th>
              </tr>
            </tfoot>
          </table>
        </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>