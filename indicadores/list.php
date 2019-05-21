<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalAdmin=$_SESSION["globalAdmin"];

$dbh = new Conexion();

$table="indicadores";
$moduleName="Indicadores Estrategicos";

$codigoObjetivo=$codigo;
$nombreObjetivo=nameObjetivo($codigoObjetivo);
// Preparamos
$sql="SELECT i.codigo, i.nombre, 
(SELECT g.nombre FROM gestiones g WHERE g.codigo=i.cod_gestion)gestion,
(SELECT p.nombre FROM periodos p WHERE p.codigo=i.cod_periodo)periodo, i.descripcion_calculo, i.lineamiento,
(SELECT t.nombre FROM tipos_calculo t WHERE t.codigo=i.cod_tipocalculo)tipocalculo, 
(SELECT t.nombre FROM tipos_resultado t WHERE t.codigo=i.cod_tiporesultado)tiporesultado
FROM indicadores i WHERE i.cod_objetivo='$codigoObjetivo' and i.cod_estado=1 ORDER BY i.nombre";
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();

// bindColumn
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
                  <h4 class="card-title"><?=$moduleName?></h4>
                  <h6 class="card-title">Objetivo: <?=$nombreObjetivo?></h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nombre</th>
                          <th>Periodicidad</th>
                          <th>Lineamiento</th>
                          <th>Desc. Calculo</th>
                          <th>Tipo Calculo</th>
                          <th>Tipo Resultado</th>
                          <th class="text-center">Configuración Propiedad</th>
                          <th class="text-center">Metas</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                      ?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$periodo;?></td>
                          <td><?=$lineamiento;?></td>
                          <td><?=$descripcionCalculo;?></td>
                          <td><?=$tipoCalculo;?></td>
                          <td><?=$tipoResultado;?></td>
                          <td class="text-center">
                            <button class="<?=$buttonDetail;?>" data-toggle="modal" data-target="#myModal" onClick="ajaxPropiedad(<?=$codigoObjetivo?>,<?=$codigo?>);" title="Ver Configuracion de Propiedad"> 
                              <i class="material-icons">description</i>
                            </button>
                          </td>
                          <td class="td-actions">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href="index.php?opcion=registerIndMetas&codigo_objetivo=<?=$codigoObjetivo?>&codigo=<?=$codigo;?>" rel="tooltip" class="<?=$buttonEdit;?>" title="Configurar Metas"> 
                              <i class="material-icons">build</i>
                            </a>
                            <?php
                            }
                            ?>
                            <button class="<?=$buttonDetailMin;?>" data-toggle="modal" data-target="#myModal2" onClick="ajaxMetas(<?=$codigoObjetivo?>,<?=$codigo?>);" title="Ver Metas"> 
                                <i class="material-icons">description</i>
                              </button>

                          </td>


                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=editIndicador&codigo_objetivo=<?=$codigoObjetivo?>&codigo=<?=$codigo;?>" title='Editar Indicador' class="<?=$buttonEdit;?>">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteIndicador&codigo=<?=$codigo;?>&codigo_objetivo=<?=$codigoObjetivo;?>')">
                              <i class="material-icons">close</i>
                            </button>
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
                    <?php
                    if($globalAdmin==1){
                    ?>
                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerIndicador&codigo=<?=$codigoObjetivo?>'">Registrar</button>
                    <?php
                    }
                    ?>
                    <a href="?opcion=listObjetivos" class="<?=$buttonCancel;?>">Cancelar</a>  
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

  <!-- METAS INDICADORES -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Metas para el indicador</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="material-icons">clear</i>
            </button>
          </div>
           <div class="modal-body" id="modal-body2">

           </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>     
        </div>
        </form>
      </div>
    </div>
  </div>
  <!--  End Modal -->
