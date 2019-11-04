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
$nameGestion=nameGestion($gestion);

$perspectiva=$_POST["perspectiva"];
$unidadOrganizacional=$_POST["unidad_organizacional"];
$areas=$_POST["areas"];
$sectores=$_POST["sectores"];
$version=$_POST["version"];
$codIndicador=$_POST["cod_indicador"];
$nameIndicador=nameIndicador($codIndicador);

$nameObjetivo=nameObjetivoxIndicador($codIndicador);

$nameVersion=nameVersion($version);

$perspectivaString=implode(",", $perspectiva);
$unidadOrgString=implode(",", $unidadOrganizacional);
$areaString=implode(",", $areas);


if($version==0){
  $sql="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from sectores_economicos s where s.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(SELECT t.abreviatura from tipos_seguimiento t where t.codigo=a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area, a.cod_tiporesultado,
i.nombre as nombreindicador, o.nombre as nombreobjetivo, o.abreviatura, p.nombre as nombreperspectiva,
(select u.nombre from unidades_organizacionales u where u.codigo=a.cod_unidadorganizacional)as nombreunidad,
(select a.nombre from areas a where a.codigo=a.cod_area)as nombrearea
 from actividades_poa a, indicadores i, objetivos o, perspectivas p where a.cod_gestion in ($gestion) and a.cod_area in ($areaString) and a.cod_unidadorganizacional in ($unidadOrgString) and o.cod_perspectiva in ($perspectivaString) and a.cod_estado=1 and 
 a.cod_indicador=i.codigo and i.cod_objetivo=o.codigo and p.codigo=o.cod_perspectiva and i.codigo='$codIndicador' ";
 if($sectores>0){
  $sql.=" and a.cod_normapriorizada in ($sectores) "; 
 }
 $sql.=" order by nombreunidad, nombrearea, sector, a.nombre";  
}else{
  $sql="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(SELECT t.abreviatura from tipos_seguimiento t where t.codigo=a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area, a.cod_tiporesultado,
i.nombre as nombreindicador, o.nombre as nombreobjetivo, o.abreviatura, p.nombre as nombreperspectiva,
(select u.nombre from unidades_organizacionales u where u.codigo=a.cod_unidadorganizacional)as nombreunidad,
(select a.nombre from areas a where a.codigo=a.cod_area)as nombrearea
 from actividades_poa_version a, indicadores i, objetivos o, perspectivas p where a.cod_gestion in ($gestion) and a.cod_area in ($areaString) and a.cod_unidadorganizacional in ($unidadOrgString) and o.cod_perspectiva in ($perspectivaString) and a.cod_estado=1 and 
 a.cod_indicador=i.codigo and i.cod_objetivo=o.codigo and p.codigo=o.cod_perspectiva and a.cod_version='$version' and i.codigo='$codIndicador' ";
 if($sectores>0){
  $sql.=" AND a.cod_normapriorizada in ($sectores) "; 
 }
 $sql.=" order by nombreunidad, nombrearea, sector, a.nombre";
}

//echo $sql;

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
                  <h4 class="card-title">Reporte de Planificacion POA</h4>
                  <h6 class="card-title">Gestion: <?=$nameGestion;?> Version: <?=$nameVersion;?></h6>
                  <h6 class="card-title">Objetivo: <?=$nameObjetivo;?></h6>
                  <h6 class="card-title">Indicador: <?=$nameIndicador;?></h6>
  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed" id="tablePaginatorFixed">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th class="font-weight-bold">Area</th>
                          <th class="font-weight-bold">Sector</th>
                          <th class="font-weight-bold">Actividad</th>
                          <th class="font-weight-bold">Ene</th>
                          <th class="font-weight-bold">Feb</th>
                          <th class="font-weight-bold">Mar</th>
                          <th class="font-weight-bold">Abr</th>
                          <th class="font-weight-bold">May</th>
                          <th class="font-weight-bold">Jun</th>
                          <th class="font-weight-bold">Jul</th>
                          <th class="font-weight-bold">Ago</th>
                          <th class="font-weight-bold">Sep</th>
                          <th class="font-weight-bold">Oct</th>
                          <th class="font-weight-bold">Nov</th>
                          <th class="font-weight-bold">Dic</th>
                          <th class="font-weight-bold">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $abrevArea=abrevArea($codArea);
                          $abrevUnidad=abrevUnidad($codUnidad);

                          //SACAMOS LA PLANIFICACION
                          if($version==0){
                            $sqlRecupera="SELECT value_numerico, value_string, value_booleano from actividades_poaplanificacion where cod_actividad=:cod_actividad and mes=:cod_mes";                            
                                                      $stmtRecupera = $dbh->prepare($sqlRecupera);
                            $stmtRecupera->bindParam(':cod_actividad',$codigo);
                            $stmtRecupera->bindParam(':cod_mes',$codMesX);
                            $stmtRecupera->execute();

                          }else{
                            $sqlRecupera="SELECT value_numerico, value_string, value_booleano from actividades_poaplanificacion_version where cod_actividad=:cod_actividad and mes=:cod_mes and   cod_version=:cod_version";
                            $stmtRecupera = $dbh->prepare($sqlRecupera);
                            $stmtRecupera->bindParam(':cod_actividad',$codigo);
                            $stmtRecupera->bindParam(':cod_mes',$codMesX);
                            $stmtRecupera->bindParam(':cod_version',$version);
                            $stmtRecupera->execute();
                          }

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
                          <td class="text-center small"><?=$index;?></td>
                          <td class="text-center small"><?=$abrevUnidad."-".$abrevArea;?></td>
                          <td class="text-center small"><?=$sectorPriorizado;?></td>
                          <td class="text-left small"><?=$nombre;?></td>
                          <?php
                          $totalActividad=0;
                          for($i=1;$i<=12;$i++){
                          $sqlRecupera="SELECT value_numerico, value_string, value_booleano from actividades_poaplanificacion where cod_actividad=:cod_actividad and mes=:cod_mes";
                          $stmtRecupera = $dbh->prepare($sqlRecupera);
                          $stmtRecupera->bindParam(':cod_actividad',$codigo);
                          $stmtRecupera->bindParam(':cod_mes',$i);
                          $stmtRecupera->execute();
                          $valueNumero=0;
                          $valueString="";
                          $valueBooleano=0;
                          while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {
                            $valueNumero=$rowRec['value_numerico'];
                            $totalActividad=$totalActividad+$valueNumero;
                          }
                          ?>
                          <td class="text-right small"><?=($valueNumero==0)?"-":formatNumberDec($valueNumero);?></td>
                          <?php 
                        }
                        ?>
                          <td class="text-right small"><?=($totalActividad==0)?"-":formatNumberDec($totalActividad);?></td>
                        </tr>
            <?php
            							$index++;
            						}
            ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>-</th>
                          <th>-</th>
                          <th>-</th>
                          <th>TOTALES</th>
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


<script type="text/javascript">
  totalesPlanificacion();
</script>