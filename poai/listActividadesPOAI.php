<?php
require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';

$dbh = new Conexion();


//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
$stmt->execute();
$codigoIndicadorPON=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoIndicadorPON=$row['valor_configuracion'];
}

/*$globalAreaPlanificacion=$_SESSION["globalAreaPlanificacion"];
$globalUnidadPlanificacion=$_SESSION["globalUnidadPlanificacion"];
$globalSectorPlanificacion=$_SESSION["globalSectorPlanificacion"];*/

$codigoIndicador=$codigo;

$areaIndicador=$area;
$unidadIndicador=$unidad;

//echo $area." ".$unidad;
//echo $areaIndicador." ".$unidadIndicador;

$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);

$nameUnidad="";
$nameArea="";
$nameSector="-";

$nameUnidad=abrevUnidad($unidadIndicador);
$nameArea=abrevArea($areaIndicador);

$table="actividades_poa";
$moduleName="Actividades POA";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

//SACAMOS LA TABLA RELACIONADA
$sqlClasificador="SELECT c.tabla FROM indicadores i, clasificadores c where i.codigo='$codigoIndicador' and i.cod_clasificador=c.codigo";
$stmtClasificador = $dbh->prepare($sqlClasificador);
$stmtClasificador->execute();
$nombreTablaClasificador="";
while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
  $nombreTablaClasificador=$rowClasificador['tabla'];
}
if($nombreTablaClasificador==""){$nombreTablaClasificador="areas";}//ESTO PARA QUE NO DE ERROR
// Preparamos
$sql="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area,
(SELECT c.nombre from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as datoclasificador, 
(select t.nombre from tipos_actividadpoa t where t.codigo=a.cod_tipoactividad) as tipo_actividad,
(select p.nombre from periodos p where p.codigo=a.cod_periodo) as periodo
 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_actividadpadre=0 and (a.poai is null or a.poai<>1) and cod_estado=1 "; 
 if($globalAdmin==0){
  $sql.=" and a.cod_area in ($globalArea) and a.cod_unidadorganizacional in ($globalUnidad)";
} 
if($areaIndicador!=0){
  $sql.=" and a.cod_area in ($areaIndicador) ";
}
if($unidadIndicador!=0){
  $sql.=" and a.cod_unidadorganizacional in ($unidadIndicador) ";
} 
$sql.=" order by a.cod_unidadorganizacional, a.cod_area, a.orden";

//echo $sql;


$stmt = $dbh->prepare($sql);
// Ejecutamos
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
$stmt->bindColumn('datoclasificador', $datoClasificador);
$stmt->bindColumn('tipo_actividad', $tipoActividad);
$stmt->bindColumn('periodo', $periodo);


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
                  <h4 class="card-title"><?=$moduleName?></h4>
                  <h6 class="card-title">Objetivo: <?=$nombreObjetivo?></h6>
                  <h6 class="card-title">Indicador: <?=$nombreIndicador?> &nbsp;&nbsp;&nbsp;
                    <!--a href="#" class="<?=$buttonCeleste;?> btn-round" data-toggle="modal" data-target="#myModal"  title="Filtrar">
                        <i class="material-icons">filter_list</i>
                    </a-->
                  </h6>
                  <h6 class="card-title">Unidad: <span class="text-danger"><?=$nameUnidad;?></span> - Area: <span class="text-danger"><?=$nameArea;?></span> - Sector: <span class="text-danger"><?=$nameSector;?></span></h6>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-condensed" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th>Area</th>
                          <th>Actividad</th>
                          <th>Producto Esperado</th>
                          <th>Clasificador</th>
                          <th data-orderable="false">SubActividades</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $abrevArea=abrevArea($codArea);
                          $abrevUnidad=abrevUnidad($codUnidad);

                          $nombrePadre=nameActividad($codActividadPadreX);
                          if(strlen($nombrePadre)>100){
                            $nombrePadre=substr($nombrePadre, 0, 110)."..."; 
                          }

                          $sqlVerifica="SELECT count(*)as contador from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and a.cod_area in ($globalArea) and a.cod_unidadorganizacional in ($globalUnidad) 
                            and a.cod_actividadpadre='$codigo' and a.cod_personal='$globalUser' and a.poai=1 and (a.cod_actividadpadre='$codigo')";
                          //echo $sqlVerifica;
                          $stmtVerifica=$dbh->prepare($sqlVerifica);
                          $stmtVerifica->execute();
                          $contadorVerifica=0;
                          while($rowVerifica = $stmtVerifica->fetch(PDO::FETCH_ASSOC)) {
                            $contadorVerifica=$rowVerifica['contador'];
                          }

                          $sqlVerifica2="SELECT count(*)as contador from actividades_personal ap where ap.cod_actividad='$codigo' and ap.cod_personal='$globalUser'";
                          //echo $sqlVerifica;
                          $stmtVerifica2=$dbh->prepare($sqlVerifica2);
                          $stmtVerifica2->execute();
                          $contadorVerifica2=0;
                          while($rowVerifica2 = $stmtVerifica2->fetch(PDO::FETCH_ASSOC)) {
                            $contadorVerifica2=$rowVerifica2['contador'];
                          }


                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td class="text-center small"><?=$abrevUnidad."-".$abrevArea;?></td>
                          <td class="text-left small"><?=$nombre;?></td>
                          <td class="text-left small"><?=$productoEsperado;?></td>
                          <td class="text-left small"><?=$datoClasificador;?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($contadorVerifica2>0){
                            ?>
                            <a href='index.php?opcion=listActividadesPOAIDetalle&codigo=<?=$codigoIndicador;?>&area=<?=$areaIndicador;?>&unidad=<?=$unidadIndicador;?>&actividad=<?=$codigo;?>&vista=1' rel="tooltip"  class="<?=$buttonDetailRojo;?>">
                        <!--i class="material-icons" title="Ver Actividades">description</i-->
                              <strong>
                                <?=($contadorVerifica==0)?"0":$contadorVerifica;?>
                              </strong>
                            </a>
                            <?php
                            }
                            ?>
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
        				<div class="card-body">
                    <!--button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerPOAI&codigo=<?=$codigoIndicador?>&area=<?=$area;?>&unidad=<?=$unidad;?>'">Registrar</button-->

                    <!--a href="#" onclick="javascript:window.open('poai/registerPOAIPlan.php?codigo=<?=$codigoIndicador?>&area=<?=$areaIndicador;?>&unidad=<?=$unidadIndicador;?>')" class="<?=$button;?>">Planificar</a-->  
                    <a href="?opcion=listPOAI&area=<?=$areaIndicador;?>&unidad=<?=$unidadIndicador;?>" class="<?=$buttonCancel;?>">Volver Atras</a> 
                </div>
            </div>
          </div>  
        </div>
    </div>




    <!-- Classic Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filtrar Area/Unidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align:center;">
      <select class="selectpicker" name="unidadModal" id="unidadModal" data-style="<?=$comboColor;?>" required>
        <option disabled selected value="">Unidad</option>
        <?php
        $sqlAreas="SELECT i.cod_indicador, u.codigo as codigoUnidad, u.nombre as nombreUnidad, u.abreviatura as abrevUnidad from indicadores_unidadesareas i, unidades_organizacionales u where i.cod_indicador='$codigoIndicador' and i.cod_unidadorganizacional=u.codigo";
        if($globalAdmin==0){
          $sqlAreas.=" and i.cod_unidadorganizacional='$globalUnidad'";
        }
        $sqlAreas.=" GROUP BY u.codigo order by 3";
        $stmt = $dbh->prepare($sqlAreas);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigoU=$row['codigoUnidad'];
        $nombreU=$row['nombreUnidad'];
        $abrevU=$row['abrevUnidad'];
      ?>
      <option value="<?=$codigoU;?>" data-subtext="<?=$nombreU;?>"><?=$abrevU;?></option>
      <?php 
      }
        ?>
      </select>
      <select class="selectpicker" name="areaModal" id="areaModal" data-style="<?=$comboColor;?>" required>
        <option disabled selected value="">Area</option>
        <?php
        $sqlAreas="SELECT i.cod_indicador, a.codigo as codigoArea, a.nombre as nombreArea, a.abreviatura as abrevArea from indicadores_unidadesareas i, areas a where i.cod_indicador='$codigoIndicador' and i.cod_area=a.codigo ";
        if($globalAdmin==0){
          $sqlAreas.=" and i.cod_area='$globalArea' ";
        }
        $sqlAreas.=" GROUP BY a.codigo order by 3";
        $stmt = $dbh->prepare($sqlAreas);
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigoA=$row['codigoArea'];
        $nombreA=$row['nombreArea'];
        $abrevA=$row['abrevArea'];
      ?>
      <option value="<?=$codigoA;?>" data-subtext="<?=$nombreA?>"><?=$abrevA;?></option>
      <?php 
      }
        ?>
      </select> 
      </div>
      <div class="modal-footer">
        <button type="button" class="<?=$button;?>" onclick="enviarFiltroAreaUnidadPOA(<?=$codigoIndicador;?>,<?=$codigoIndicadorPON;?>);">Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->