<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

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

$sql="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(SELECT t.abreviatura from tipos_seguimiento t where t.codigo=a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area, a.cod_tiporesultado,
i.nombre as nombreindicador, o.nombre as nombreobjetivo, o.abreviatura, p.nombre as nombreperspectiva
 from actividades_poa a, indicadores i, objetivos o, perspectivas p where a.cod_area in ($areaString) and a.cod_unidadorganizacional in ($unidadOrgString) and a.cod_estado=1 and 
 a.cod_indicador=i.codigo and i.cod_objetivo=o.codigo and p.codigo=o.cod_perspectiva
 order by nombreperspectiva, nombreobjetivo, nombreindicador, a.orden";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('orden', $orden);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('normapriorizada', $normaPriorizada);
$stmt->bindColumn('sectorpriorizado', $sectorPriorizado);
$stmt->bindColumn('norma', $norma);
$stmt->bindColumn('sector', $sector);
$stmt->bindColumn('tipodato', $tipoDato);
$stmt->bindColumn('producto_esperado', $productoEsperado);
$stmt->bindColumn('cod_unidadorganizacional', $codUnidad);
$stmt->bindColumn('cod_area', $codArea);
$stmt->bindColumn('cod_tiporesultado', $codTipoDato);
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
                  <h4 class="card-title">Reporte de Ejecucion POA Detallado por Actividad</h4>
                  <h6 class="card-title">Gestion: <?=$nameGestion;?> Mes: <?=$nameMes;?></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th>Perspectiva</th>
                          <th>Abreviatura</th>
                          <th>Objetivo</th>
                          <th>Indicador</th>
                          <th>Area</th>
                          <th>Actividad</th>
                          <th>Producto Esperado</th>
                          <th>Seg.</th>
                          <th>Plan</th>
                          <th>Eje</th>
                          <th>Explicacion<br>Logro</th>
                          <th>Archivo</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $abrevArea=abrevArea($codArea);
                          $abrevUnidad=abrevUnidad($codUnidad);

                          //SACAMOS LA PLANIFICACION
                          $sqlRecupera="SELECT value_numerico, value_string, value_booleano from actividades_poaplanificacion where cod_actividad=:cod_actividad and mes=:cod_mes";
                          $stmtRecupera = $dbh->prepare($sqlRecupera);
                          $stmtRecupera->bindParam(':cod_actividad',$codigo);
                          $stmtRecupera->bindParam(':cod_mes',$codMesX);
                          $stmtRecupera->execute();
                          $valueNumero=0;
                          $valueString="";
                          $valueBooleano=0;
                          while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
                            $valueNumero=$rowRec['value_numerico'];
                            $valueString=$rowRec['value_string'];
                            $valueBooleano=$rowRec['value_booleano'];
                          }

                          $sqlRecupera="SELECT value_numerico, value_string, value_booleano, descripcion, archivo from actividades_poaejecucion where cod_actividad=:cod_actividad and mes=:cod_mes";
                          $stmtRecupera = $dbh->prepare($sqlRecupera);
                          $stmtRecupera->bindParam(':cod_actividad',$codigo);
                          $stmtRecupera->bindParam(':cod_mes',$codMesX);
                          $stmtRecupera->execute();
                          $valueNumeroEj=0;
                          $valueStringEj="";
                          $valueBooleanoEj=0;
                          $descripcionLogroEj="";
                          $archivoEj="";
                          while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
                            $valueNumeroEj=$rowRec['value_numerico'];
                            $valueStringEj=$rowRec['value_string'];
                            $valueBooleanoEj=$rowRec['value_booleano'];
                            $descripcionLogroEj=$rowRec['descripcion'];
                            $archivoEj=$rowRec['archivo'];
                          }
                          //FIN PLANIFICACION
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$nombrePerspectiva;?></td>
                          <td><?=$abreviatura;?></td>
                          <td><?=$nombreObjetivo;?></td>
                          <td><?=$nombreIndicador;?></td>
                          <td><?=$abrevArea."-".$abrevUnidad;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$productoEsperado;?></td>
                          <td><?=$tipoDato;?></td>
                          <?php
                          if($codTipoDato==1 || $codTipoDato==3){
                          ?>
                            <td class="text-center">
                              <?=$valueNumero;?>
                            </td>
                            <td class="text-center">
                              <?=$valueNumeroEj;?>
                            </td>
                          <?php 
                            }
                            if($codTipoDato==2){
                              if($valueBooleano==1){
                                $iconCheck="check_circle_outline";
                              }else{
                                $iconCheck="";
                              }
                              if($valueBooleanoEj==1){
                                $iconCheckEj="check_circle_outline";
                              }else{
                                $iconCheckEj="";
                              }
                          ?>
                            <td class="text-center">
                              <div class="card-icon">
                                <i class="material-icons"><?=$iconCheck;?></i>
                              </div>
                            </td>
                            <td class="text-center">
                              <div class="card-icon">
                                <i class="material-icons"><?=$iconCheckEj;?></i>
                              </div>
                            </td>
                          <?php
                          }
                          ?>
                            <td><?=$descripcionLogroEj?></td>
                          <?php
                            if($archivoEj!=""){
                                $iconCheckFile="attach_file";
                              }else{
                                $iconCheckFile="";
                              }
                          ?>
                            <td><div class="card-icon">
                                <a href="filesApp/<?=$archivoEj;?>" target="_blank">
                                  <i class="material-icons"><?=$iconCheckFile;?></i>
                                </a>
                              </div>
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
