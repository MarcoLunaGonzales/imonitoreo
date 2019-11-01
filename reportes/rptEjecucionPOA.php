<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$gestion=$_POST["gestion"];
$codMesX=$_POST["mes"];

$nameMes=nameMes($codMesX);
$nameGestion=nameGestion($gestion);

$perspectiva=$_POST["perspectiva"];
$unidadOrganizacional=$_POST["unidad_organizacional"];
$areas=$_POST["areas"];

$perspectivaString=implode(",", $perspectiva);
$unidadOrgString=implode(",", $unidadOrganizacional);
$areaString=implode(",", $areas);

$sql="SELECT a.cod_area, a.cod_unidadorganizacional, i.codigo,
i.nombre as nombreindicador, o.nombre as nombreobjetivo, o.abreviatura, p.nombre as nombreperspectiva
 from actividades_poa a, indicadores i, objetivos o, perspectivas p where a.cod_gestion='$gestion' and a.cod_area in ($areaString) 
and a.cod_unidadorganizacional in ($unidadOrgString) and o.cod_perspectiva in ($perspectivaString) and a.cod_estado=1 and 
 a.cod_indicador=i.codigo and i.cod_objetivo=o.codigo and p.codigo=o.cod_perspectiva
group by a.cod_area, a.cod_unidadorganizacional, i.codigo, i.nombre
order by nombreperspectiva, nombreobjetivo, nombreindicador";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigoIndicador);
$stmt->bindColumn('cod_area', $codArea);
$stmt->bindColumn('cod_unidadorganizacional', $codUnidad);
$stmt->bindColumn('nombreindicador', $nombreIndicador);
$stmt->bindColumn('nombreobjetivo', $nombreObjetivo);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('nombreperspectiva', $nombrePerspectiva);

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
                  <h4 class="card-title">Reporte de Ejecucion POA</h4>
                  <h6 class="card-title">Gestion: <?=$nameGestion;?> Mes: <?=$nameMes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th>Perspectiva</th>
                          <th>Abreviatura</th>
                          <th>Objetivo</th>
                          <th>Indicador</th>
                          <th>Area</th>
                          <th>Planificado</th>
                          <th>Ejecutado</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $abrevArea=abrevArea($codArea);
                          $abrevUnidad=abrevUnidad($codUnidad);

                          //SACAMOS LA PLANIFICACION
                          $cantidadPlanificada=0;
                          $cantidadEjecutada=0;
                          $cantidadPlanificada=planificacionPorIndicador($codigoIndicador, $codArea, $codUnidad, $codMesX, 0);  
                          $cantidadEjecutada=ejecucionPorIndicador($codigoIndicador, $codArea, $codUnidad, $codMesX, 0);
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$nombrePerspectiva;?></td>
                          <td><?=$abreviatura;?></td>
                          <td><?=$nombreObjetivo;?></td>
                          <td><?=$nombreIndicador;?></td>
                          <td><?=$abrevArea."-".$abrevUnidad;?></td>
                          <td class="text-right"><?=formatNumberDec($cantidadPlanificada);?></td>
                          <td class="text-right"><?=formatNumberDec($cantidadEjecutada);?></td>
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
