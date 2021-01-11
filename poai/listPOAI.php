<?php
require_once 'conexion.php';
require_once 'styles.php';
$dbh = new Conexion();

if($area==0){
  if(isset($_SESSION['globalAreaPlanificacion'])){
    $area=$_SESSION["globalAreaPlanificacion"];
    $globalAreaPlanificacion=$_SESSION["globalAreaPlanificacion"];
  }else{
    $_SESSION["globalAreaPlanificacion"]=$area;
    $globalAreaPlanificacion=$area;
  }
}else{
  $_SESSION["globalAreaPlanificacion"]=$area;
  $globalAreaPlanificacion=$area;
}

if($unidad==0){
  if(isset($_SESSION['globalUnidadPlanificacion'])){
    $unidad=$_SESSION["globalUnidadPlanificacion"];
    $globalUnidadPlanificacion=$_SESSION["globalUnidadPlanificacion"];;
  }else{
    $_SESSION["globalUnidadPlanificacion"]=$unidad;
    $globalUnidadPlanificacion=$unidad;
  }
}else{
  $_SESSION["globalUnidadPlanificacion"]=$unidad;
  $globalUnidadPlanificacion=$unidad;
}



/*if(isset($globalSectorPlanificacion)){
  $globalSectorPlanificacion=$_SESSION["globalSectorPlanificacion"];
}else{
  $globalSectorPlanificacion=0;
  $sector=0;
}*/
$globalSectorPlanificacion=0;
$sector=0;

$nameUnidad="";
$nameArea="";
$nameSector="-";

$nameUnidad=abrevUnidad($globalUnidadPlanificacion);
$nameArea=abrevArea($globalAreaPlanificacion);

if($globalSectorPlanificacion!=0){
  $nameSector=nameSectorEconomico($globalSectorPlanificacion);
}

//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
$stmt->execute();
$codigoIndicadorPON=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoIndicadorPON=$row['valor_configuracion'];
}

$table="poa";
$moduleName="POAI Programacion";
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

if($globalAdmin==0){
  $sql="SELECT (SELECT count(*) from actividades_poa a where a.cod_unidadorganizacional in ($globalUnidad) and a.cod_area in ($globalArea) and a.cod_indicador=i.codigo and a.cod_estado=1 and a.cod_actividadpadre=0) as contador,
  (select p.nombre from perspectivas p where p.codigo=o.cod_perspectiva)as perspectiva, o.codigo, o.abreviatura, o.descripcion, (SELECT g.nombre from gestiones g WHERE g.codigo=o.cod_gestion) as gestion, i.nombre as nombreindicador, i.codigo as codigoindicador
    FROM objetivos o, indicadores i, indicadores_unidadesareas iua
  WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador and iua.cod_area in ($globalArea) and iua.cod_unidadorganizacional in ($globalUnidad) 
  group by perspectiva, o.codigo, o.abreviatura, o.descripcion, gestion, nombreindicador, codigoindicador
  HAVING contador>0
  ORDER BY perspectiva, abreviatura";
}else{
  $sql="SELECT (SELECT count(*) from actividades_poa a where a.cod_unidadorganizacional in ($globalUnidad) and a.cod_area in ($globalArea) and a.cod_indicador=i.codigo and a.cod_estado=1 and a.cod_actividadpadre=0) as contador,
  (select p.nombre from perspectivas p where p.codigo=o.cod_perspectiva)as perspectiva, o.codigo, o.abreviatura, o.descripcion, (SELECT g.nombre from gestiones g WHERE g.codigo=o.cod_gestion) as gestion, i.nombre as nombreindicador, i.codigo as codigoindicador
    FROM objetivos o, indicadores i
  WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion'
  group by perspectiva, o.codigo, o.abreviatura, o.descripcion, gestion, nombreindicador, codigoindicador
  HAVING contador>0
  ORDER BY perspectiva, abreviatura";
}

//echo $sql;

$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('perspectiva', $perspectiva);
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('descripcion', $descripcion);
$stmt->bindColumn('gestion', $gestion);
$stmt->bindColumn('nombreindicador', $nombreIndicador);
$stmt->bindColumn('codigoindicador', $codigoIndicador);
$stmt->bindColumn('contador', $nroActividadesIndicador);
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
                  <h6 class="card-title">Unidad: <span class="text-danger"><?=$nameUnidad;?></span> - Area: <span class="text-danger"><?=$nameArea;?></span> - Sector: <span class="text-danger"><?=$nameSector;?></span></h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th data-orderable="false">Gestion</th>
                          <th>Perspectiva</th>
                          <th>Obj. Est.</th>
                          <th>Ind. Estrategico</th>
                          <th class="text-center" data-orderable="false">Actividades</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {

                          //$sqlNroAct="SELECT count(*)as contador from actividades_poa a where a.cod_unidadorganizacional in ($globalUnidad) and a.cod_area in ($globalArea) and a.cod_indicador='$codigoIndicador' and a.cod_estado=1 
                            //and a.cod_actividadpadre=0";
                          
                          //echo $sqlNroAct;

                          //$stmtNroAct = $dbh->prepare($sqlNroAct);
                          //$stmtNroAct->execute();
                          //$nroActividadesIndicador=0;
                          //while ($rowNroAct = $stmtNroAct->fetch(PDO::FETCH_ASSOC)) {
                          //    $nroActividadesIndicador=$rowNroAct['contador'];
                          //}
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$gestion;?></td>
                          <td><?=$perspectiva;?></td>
                          <td><?=$abreviatura;?></td>
                          <td><?=$nombreIndicador;?></td>
                          <td class="text-center">
                            <a href='index.php?opcion=listActividadesPOAI&codigo=<?=$codigoIndicador;?>&area=<?=$globalAreaPlanificacion;?>&unidad=<?=$globalUnidadPlanificacion;?>' rel="tooltip" title="Ver Actividades" class="<?=$buttonDetailVerde;?>">
                              <strong>
                                <?=($nroActividadesIndicador==0)?"-":$nroActividadesIndicador;?>
                              </strong>
                            </a>
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


<!-- Classic Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Definir Unidad/Area/Sector para la Programacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align:center;">
      <select class="selectpicker" name="unidadModal" id="unidadModal" data-style="<?=$comboColor;?>" required>
        <!--option disabled selected value="">Unidad</option-->
        <?php
        $sqlAreas="SELECT i.cod_indicador, u.codigo as codigoUnidad, u.nombre as nombreUnidad, u.abreviatura as abrevUnidad from indicadores_unidadesareas i, unidades_organizacionales u where i.cod_unidadorganizacional=u.codigo";
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
        <!--option disabled selected value="">Area</option-->
        <?php
        $sqlAreas="SELECT i.cod_indicador, a.codigo as codigoArea, a.nombre as nombreArea, a.abreviatura as abrevArea from indicadores_unidadesareas i, areas a where i.cod_area=a.codigo ";
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

      <select class="selectpicker" name="sectorModal" id="sectorModal" data-style="<?=$comboColor;?>" required>
        <option disabled selected value="">Sector Economico</option>
        <?php
        $sqlAreas="SELECT s.codigo, s.nombre from sectores_economicos s order by 2";
        $stmt = $dbh->prepare($sqlAreas);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $codigoS=$row['codigo'];
          $nombreS=$row['nombre'];
        ?>
         <option value="<?=$codigoS;?>" data-subtext="<?=$nombreS?>"><?=$nombreS;?></option>
        <?php 
        }
        ?>
      </select> 

      </div>
      <div class="modal-footer">
        <button type="button" class="<?=$button;?>" onclick="enviarDefinicionAreaUnidadSectorPOAI();">Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->

<?php
if($area==0 && $unidad==0 && $sector==0){
?>
<script>
  verificaModalArea();
</script>
<?php
}
?>