<?php

require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
$stmt->execute();
$codigoIndicadorPON=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoIndicadorPON=$row['valor_configuracion'];
}

$codigoIndicador=$codigo;
$areaIndicador=$area;
$unidadIndicador=$unidad;

$nombreIndicador=nameIndicador($codigoIndicador);
$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);

$table="actividades_poa";
$moduleName="Ejecucion de Actividades POA";

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

//SACAMOS LAS FECHAS DE REGISTRO DEL MES EN CURSO
$fechaActual=date("Y-m-d");
$sqlFechaEjecucion="SELECT f.mes, f.anio, DATE_FORMAT(f.fecha_fin, '%d/%m')fecha_fin from fechas_registroejecucion f 
where f.fecha_inicio<='$fechaActual' and f.fecha_fin>='$fechaActual'";
//echo $sqlFechaEjecucion;
$stmt = $dbh->prepare($sqlFechaEjecucion);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codMesX=$row['mes'];
  $codAnioX=$row['anio'];
  $fechaFinRegistroX=$row['fecha_fin'];
}
$nombreMes=nameMes($codMesX);
//FIN FECHAS

//SACAMOS LA TABLA RELACIONADA
$sqlClasificador="SELECT c.codigo, c.tabla FROM indicadores i, clasificadores c where i.codigo='$codigoIndicador' and i.cod_clasificador=c.codigo";
$stmtClasificador = $dbh->prepare($sqlClasificador);
$stmtClasificador->execute();
$nombreTablaClasificador="";
$codigoClasificador=0;
while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
  $codigoClasificador=$rowClasificador['codigo'];
  $nombreTablaClasificador=$rowClasificador['tabla'];
}
if($nombreTablaClasificador==""){$nombreTablaClasificador="areas";}//ESTO PARA QUE NO DE ERROR



// Preparamos
$sql="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(SELECT t.abreviatura from tipos_seguimiento t where t.codigo=a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area, a.cod_tiporesultado, (SELECT c.nombre from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as datoclasificador,
          (SELECT c.codigo from $nombreTablaClasificador c where c.codigo=a.cod_datoclasificador)as codigodetalleclasificador
 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 ";
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
$stmt->bindColumn('cod_tiporesultado', $codTipoDato);
$stmt->bindColumn('datoclasificador', $datoclasificador);
$stmt->bindColumn('codigodetalleclasificador', $codigodetalleclasificador);

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
                  <h4 class="card-title"><?=$moduleName?> - Mes Ejecucion: <?=$nombreMes;?> </h4>
                  <h4 class="card-title">Fecha Limite: <?=$fechaFinRegistroX;?></h4>
                  <h6 class="card-title">Objetivo: <?=$nombreObjetivo?></h6>
                  <h6 class="card-title">Indicador: <?=$nombreIndicador?>
                    <a href="#" class="<?=$buttonCeleste;?> btn-round" data-toggle="modal" data-target="#myModal"  title="Filtrar">
                        <i class="material-icons">filter_list</i>
                    </a>                    
                  </h6>


                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th colspan="2" class="font-weight-bold table-success small">Ejecutado</th>
                          <th></th>
                          <th></th>
                        </tr>
                        <tr>
                          <th class="text-center">-</th>
                          <th>Area</th>
                          <th>Actividad</th>
                          <th>Producto Esperado</th>
                          <th>Seg.</th>
                          <th>Clasificador</th>
                          <th class="table-warning">Plan</th>
                          <th class="table-success">Sist.</th>
                          <th class="table-success">POA</th>
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

                          $valueEjecutadoSistema=0;
                          if($codigoClasificador!=0){
                            $valueEjecutadoSistema=obtieneEjecucionSistema($codMesX,$codAnioX,$codigoClasificador,$codUnidad,$codArea,$codigoIndicador,$codigodetalleclasificador);
                          }
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$abrevArea."-".$abrevUnidad;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$productoEsperado;?></td>
                          <td><?=$tipoDato;?></td>
                          <td><?=$datoclasificador;?>(<?=$codigodetalleclasificador;?>)</td>
                          <?php
                          if($codTipoDato==1 || $codTipoDato==3){
                          ?>
                            <td class="text-center table-warning font-weight-bold">
                              <?=formatNumberDec($valueNumero);?>
                            </td>
                            <td class="text-center table-success font-weight-bold">
                              <?=($valueEjecutadoSistema==0)?"-":formatNumberDec($valueEjecutadoSistema);?>
                            </td>

                            <td class="text-center table-success font-weight-bold"">
                              <?=formatNumberDec($valueNumeroEj);?>
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
        				<div class="card-body">
                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerPOAEjecucion&codigo=<?=$codigoIndicador?>&area=0&unidad=0'">Registrar Ejecucion</button>   
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
          $sqlAreas.=" and i.cod_unidadorganizacional in ($globalUnidad)";
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
          $sqlAreas.=" and i.cod_area in ($globalArea) ";
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
        <button type="button" class="<?=$button;?>" onclick="enviarFiltroAreaUnidadPOA2(<?=$codigoIndicador;?>,<?=$codigoIndicadorPON;?>);">Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->