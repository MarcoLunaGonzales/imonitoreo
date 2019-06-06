<?php
require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();
session_start();
$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$anio=$_GET["anio"];
$mes=$_GET["mes"];
$unidadOrganizacional=$_GET["unidad_organizacional"];
$codigoPrograma=$_GET["codigoPrograma"];

$sql="SELECT u.nombre as unidad, p.nombre as nombreprograma, e.nombre_curso, e.sigla, 
e.codigocurso, e.tipo, e.cantidad_modulos, e.estado, e.empresa, e.tema, e.fecha_inicio, e.fecha_fin, e.docente, e.alumnos_modulo, e.nro_modulo
  from ext_cursos e, unidades_organizacionales u, programas p where 
e.id_oficina=u.codigo and p.codigo=e.id_programa and year(e.fecha_inicio)='$anio' and month(e.fecha_inicio) in ($mes) and e.id_oficina in ($unidadOrganizacional) and e.id_programa in ($codigoPrograma) order by unidad, e.fecha_inicio, nombreprograma";


$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('unidad', $unidad);
$stmt->bindColumn('nombreprograma', $nombrePrograma);
$stmt->bindColumn('nombre_curso', $nombreCurso);
$stmt->bindColumn('sigla', $sigla);
$stmt->bindColumn('codigocurso', $codigoCurso);
$stmt->bindColumn('tipo', $tipo);
$stmt->bindColumn('cantidad_modulos', $cantidadModulos);
$stmt->bindColumn('estado', $estado);
$stmt->bindColumn('empresa', $empresa);
$stmt->bindColumn('tema', $tema);
$stmt->bindColumn('fecha_inicio', $fechaInicio);
$stmt->bindColumn('fecha_fin', $fechaFinal);
$stmt->bindColumn('docente', $docente);
$stmt->bindColumn('alumnos_modulo', $alumnosModulo);
$stmt->bindColumn('nro_modulo', $nroModulo);

?>

<div class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header <?=$colorCard;?> card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Reporte de Cursos</h4>
                  <h6 class="card-title">Gestion: <?=$anio;?> Mes:<?=$mes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed" id="tablePaginatorReport">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th class="font-weight-bold">Unidad</th>
                          <th class="font-weight-bold">Programa</th>
                          <th class="font-weight-bold">Curso</th>
                          <th class="font-weight-bold">Sigla</th>
                          <th class="font-weight-bold">Codigo</th>
                          <th class="font-weight-bold">Tema</th>
                          <th class="font-weight-bold">Tipo</th>
                          <th class="font-weight-bold"># Modulo</th>
                          <th class="font-weight-bold">Estado</th>
                          <th class="font-weight-bold">Empresa</th>
                          <th class="font-weight-bold">Inicio</th>
                          <th class="font-weight-bold">Final</th>
                          <th class="font-weight-bold">Docente</th>
                          <th class="font-weight-bold"># Alumnos</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$unidad;?></td>
                          <td class="text-left small"><?=$nombrePrograma;?></td>
                          <td class="text-left small"><?=$nombreCurso;?></td>
                          <td><?=$sigla;?></td>
                          <td><?=$codigoCurso;?></td>
                          <td class="text-left small"><?=$tema;?></td>
                          <td><?=$tipo;?></td>
                          <td><?=$nroModulo;?></td>
                          <td><?=$estado;?></td>
                          <td><?=$empresa;?></td>
                          <td><?=$fechaInicio;?></td>
                          <td><?=$fechaFinal;?></td>
                          <td class="text-left small"><?=$docente;?></td>
                          <td><?=$alumnosModulo;?></td>
                        </tr>
                        <?php
                          $index++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>  
        </div>
    </div>
