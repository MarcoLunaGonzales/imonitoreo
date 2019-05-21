<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$moduleName="Objetivos e Indicadores Estrategicos";

// Preparamos
$sql="SELECT o.codigo as codigo_objetivo, o.nombre as nombre_objetivo, 
(select p.nombre from perspectivas p where p.codigo=o.cod_perspectiva)as perspectiva,
o.abreviatura, i.codigo, i.nombre, 
(SELECT g.nombre FROM gestiones g WHERE g.codigo=i.cod_gestion)gestion,
(SELECT p.nombre FROM periodos p WHERE p.codigo=i.cod_periodo)periodo, i.descripcion_calculo, i.lineamiento,
(SELECT t.nombre FROM tipos_calculo t WHERE t.codigo=i.cod_tipocalculo)tipocalculo, 
(SELECT t.nombre FROM tipos_resultado t WHERE t.codigo=i.cod_tiporesultado)tiporesultado
FROM indicadores i, objetivos o WHERE i.cod_objetivo=o.codigo ORDER BY perspectiva, o.abreviatura, i.nombre";
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo_objetivo', $codigoObjetivo);
$stmt->bindColumn('nombre_objetivo', $nombreObjetivo);
$stmt->bindColumn('perspectiva', $perspectiva);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('gestion', $gestion);
$stmt->bindColumn('periodo', $periodo);
$stmt->bindColumn('descripcion_calculo', $descripcionCalculo);
$stmt->bindColumn('lineamiento', $lineamiento);
$stmt->bindColumn('tipocalculo', $tipoCalculo);
$stmt->bindColumn('tiporesultado', $tipoResultado);

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
                  <h4 class="card-title">Reporte <?=$moduleName?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Gestion</th>
                          <th>Perspectiva</th>
                          <th>Abreviatura</th>
                          <th>Objetivo</th>
                          <th>Indicador</th>
                          <th>Lineamiento</th>
                          <th>Desc.Calculo</th>
                          <th>Tipo de Resultado</th>
                          <th class="text-center">Configuración Propiedad</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                      ?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$gestion;?></td>
                          <td><?=$perspectiva;?></td>
                          <td><?=$abreviatura;?></td>
                          <td><?=$nombreObjetivo;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$lineamiento;?></td>
                          <td><?=$descripcionCalculo;?></td>
                          <td><?=$tipoResultado;?></td>
                          <td class="text-center">
                            <!--EMPEZAMOS LA TABLA DE PROPIEDADES-->
<div class="col-sm-12">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
      <th class="text-muted">Unidad\Area</th>
        <?php
    $stmtA = $dbh->prepare("SELECT a.codigo, a.abreviatura FROM areas a where a.codigo in (SELECT iua.cod_area from indicadores_unidadesareas iua where iua.cod_area=a.codigo) and a.cod_estado=1 ORDER BY 2");
    $stmtA->execute();
    while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
      $codigoA=$rowA['codigo'];
      $abreviaturaA=$rowA['abreviatura'];
    ?>
      <th class="text-muted"><?=$abreviaturaA?></th>
    <?php 
    }
        ?>
        </thead>
        <tbody>
            <?php
      $stmtU = $dbh->prepare("SELECT u.codigo, u.abreviatura FROM unidades_organizacionales u where 
        u.codigo in (select i.cod_unidadorganizacional from indicadores_unidadesareas i where i.cod_indicador='$codigo' and i.cod_unidadorganizacional=u.codigo) and u.cod_estado=1 ORDER BY 2");
      $stmtU->execute();
      while ($rowU = $stmtU->fetch(PDO::FETCH_ASSOC)) {
        $codigoU=$rowU['codigo'];
        $abreviaturaU=$rowU['abreviatura'];
      ?>                      
      <tr>
        <th class="text-muted"><?=$abreviaturaU?></th>
      <?php 
        $stmtA->execute();
        while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
          $codigoA=$rowA['codigo'];
          $abreviaturaA=$rowA['abreviatura'];

          
          $sqlVeri="SELECT count(*) as filas FROM indicadores_unidadesareas where cod_indicador='$codigo' and cod_unidadorganizacional='$codigoU' and cod_area='$codigoA'";
          $stmtVeri = $dbh->prepare($sqlVeri);
          //echo $sqlVeri;
          $stmtVeri->execute();
          while ($rowVeri = $stmtVeri->fetch(PDO::FETCH_ASSOC)) {
            $flagVerifica=$rowVeri['filas'];
            $iconCheck="";
            if($flagVerifica==1){
              $iconCheck="check_circle_outline";
            }else{
              $iconCheck="";
            }
          }
      ?>
          <td>
            <div class="card-icon">
                        <i class="material-icons"><?=$iconCheck;?></i>
                      </div>
          </td>
        <?php 
        }
      }
            ?>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

                            <!--TERMINAMOS LA TABLA DE PROPIEDADES-->
                          </td>
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


    <!-- PROPIEDAD INDICADOR -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Configuración de propiedad del indicador</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
          </div>
           <div class="modal-body" id="modal-body">

           </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cerrar</button>   
        </div>
      </div>
    </div>
  </div>
  <!--  End Modal -->