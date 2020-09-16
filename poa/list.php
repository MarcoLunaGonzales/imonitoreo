<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

/*$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();*/


$nameUnidad="";
$nameArea="";
$nameSector="-";


if($area!=0 && $unidad!=0){
  $_SESSION["globalAreaPlanificacion"]=$area;
  $_SESSION["globalUnidadPlanificacion"]=$unidad;
  $nameUnidad=abrevUnidad($unidad);
  $nameArea=abrevArea($area);

  $areaIndicador=$area;
  $unidadIndicador=$unidad;
}

if($sector!=0){
  $_SESSION["globalSectorPlanificacion"]=$sector;
  $nameSector=nameSectorEconomico($sector);
}
if($sector==""){
  $_SESSION["globalSectorPlanificacion"]=0;
}


$table="poa";
$moduleName="POA Programacion";

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];


$sql="SELECT (select p.nombre from perspectivas p where p.codigo=o.cod_perspectiva)as perspectiva, o.codigo, o.abreviatura, o.descripcion, (SELECT g.nombre from gestiones g WHERE g.codigo=o.cod_gestion) as gestion, i.nombre as nombreindicador, i.codigo as codigoindicador
    FROM objetivos o, indicadores i, indicadores_unidadesareas iua
  WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador";
  $sql.=" and iua.cod_area in ($area) and iua.cod_unidadorganizacional in ($unidad) ";
$sql.=" group by i.codigo ORDER BY perspectiva, abreviatura";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();


$stmt->bindColumn('perspectiva', $perspectiva);
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('descripcion', $descripcion);
$stmt->bindColumn('gestion', $gestion);
$stmt->bindColumn('nombreindicador', $nombreIndicador);
$stmt->bindColumn('codigoindicador', $codigoIndicador);



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
              <table class="table table-striped" id="tablePaginator50">
                <thead>
                  <tr>
                    <th class="text-center">-</th>
                    <th data-orderable="false">Gestion</th>
                    <th>Perspectiva</th>
                    <th>Obj. Est.</th>
                    <th>Ind. Estrategico</th>
                    <th class="text-center" data-orderable="false">Actividades</th>
                    <th class="text-center" data-orderable="false">POAI</th>
                    <th class="text-center" data-orderable="false">Borrar</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $index=1;
                	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                      $sqlNroAct="SELECT count(*)as contador from actividades_poa a where a.cod_unidadorganizacional='$unidad' and a.cod_area='$area' and a.cod_indicador='$codigoIndicador' and a.cod_estado=1 and a.cod_actividadpadre=0 ";
                      if($sector>0){
                        $sqlNroAct.=" and a.cod_normapriorizada='$sector'";
                      }
                      $stmtNroAct = $dbh->prepare($sqlNroAct);
                      $stmtNroAct->execute();
                      $nroActividadesIndicador=0;
                      while ($rowNroAct = $stmtNroAct->fetch(PDO::FETCH_ASSOC)) {
                          $nroActividadesIndicador=$rowNroAct['contador'];
                      }
                ?>
                  <tr>
                    <td class="text-center"><?=$index;?></td>
                    <td><?=$gestion;?></td>
                    <td><?=$perspectiva;?></td>
                    <td><?=$abreviatura;?></td>
                    <td><?=$nombreIndicador;?></td>
                    <td class="text-center">
                      <a href='index.php?opcion=listActividadesPOA&codigo=<?=$codigoIndicador;?>&area=<?=$areaIndicador;?>&unidad=<?=$unidadIndicador;?>' rel="tooltip"  class="<?=$buttonDetail;?>">
                        <!--i class="material-icons" title="Ver Actividades">description</i-->
                          <strong>
                              <?=($nroActividadesIndicador==0)?"-":$nroActividadesIndicador;?>
                          </strong>
                      </a>
                    </td>
                    <?php
                    if($globalAdmin==1){
                    ?>
                    <td class="text-center">
                      <button class="<?=$buttonDetail;?>" data-toggle="modal" data-target="#myModal1" onClick="ajaxCargosPOAI(<?=$codigoIndicador?>);"> 
                          <i class="material-icons" title="Registrar Cargos POAI">settings</i>
                      </button>
                    </td>
                    <?php
                    }else{
                    ?>
                    <td class="text-center">
                      -
                    </td>
                    <?php
                    }
                    ?>

                    <?php
                    if($globalAdmin==1){
                    ?>
                    <td class="text-center">
                      <button class="<?=$buttonDetailDelete;?>" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=saveDeleteActxIndicador&codigo=<?=$codigoIndicador;?>&area=<?=$area;?>&unidad=<?=$unidad;?>&sector=<?=$sector;?>')"> 
                          <i class="material-icons" title="Borrar Todas las Actividades">delete</i>
                      </button>
                    </td>
                    <?php
                    }else{
                    ?>
                    <td class="text-center">
                      -
                    </td>
                    <?php
                    }
                    ?>

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
        <button type="button" class="<?=$button;?>" onclick="enviarDefinicionAreaUnidadSector();">Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->



<!-- PROPIEDAD DE CARGOS POAI -->
<form id="form1" class="form-horizontal" action="poa/saveConfigCargos.php" method="post">
  
  <input type="hidden" name="global_area" value="<?=$area;?>">
  <input type="hidden" name="global_unidad" value="<?=$unidad;?>">
  <input type="hidden" name="global_sector" value="<?=$sector;?>">

  <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Configuración Propiedad Cargos para POAI</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
          <div class="modal-footer">
            <button type="submit" class="<?=$button;?>">Guardar</button>
            <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cerrar</button>  
          </div>
      </div>
    </div>
  </div>
</form>
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