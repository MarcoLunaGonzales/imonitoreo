<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalAdmin=$_SESSION["globalAdmin"];
$codigo_proy=$_SESSION["globalProyecto"];
// echo $codigo_proy;
if($codigo_proy==''){
  $codigo_proy=$codigo_proy;
  include("principal_actividades.php");
}else{
  $nombre_proyecto=obtener_nombre_proyecto($codigo_proy);

  $dbh = new Conexion();

  $sqlX="SET NAMES 'utf8'";
  $stmtX = $dbh->prepare($sqlX);
  $stmtX->execute();

  $table="solicitud_fondos";
  $moduleName="Solicitud de Fondos - Proyecto ".$nombre_proyecto;

  $globalGestion=$_SESSION["globalGestion"];

  // Preparamos
  $sql="SELECT s.codigo, (SELECT g.nombre from gestiones g where g.codigo=s.cod_gestion)as gestion, s.fecha, s.observaciones, (SELECT sum(sd.monto) from solicitudfondos_detalle sd where sd.codigo=s.codigo)as monto from $table s where s.cod_gestion='$globalGestion' and s.cod_estado=1 and cod_proyecto=$codigo_proy order by s.fecha";
  $stmt = $dbh->prepare($sql);
  // Ejecutamos
  $stmt->execute();

  // bindColumn
  $stmt->bindColumn('codigo', $codigo);
  $stmt->bindColumn('gestion', $gestion);
  $stmt->bindColumn('fecha', $fecha);
  $stmt->bindColumn('observaciones', $observaciones);
  $stmt->bindColumn('monto', $monto);
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
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="tablePaginator">
                        <thead>
                          <tr>
                            <th class="text-center" data-orderable="false">-</th>
                            <th data-orderable="false">Gestion</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                            <th>Monto Total</th>
                            <th class="center" data-orderable="false">Detalle</th>
                            <th class="text-right" data-orderable="false">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $index=1;
                        	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                        ?>
                          <tr>
                            <td class="text-center"><?=$index;?></td>
                            <td><?=$gestion;?></td>
                            <td><?=$fecha;?></td>
                            <td><?=$observaciones;?></td>
                            <td><?=formatNumberDec($monto);?></td>
                            <td>
                                <button class="<?=$buttonDetailMin;?>" data-toggle="modal" data-target="#myModal" onClick="ajaxDetalleSolicitudFondoSIS(<?=$codigo;?>);" title="Ver Detalle"> 
                                  <i class="material-icons">description</i>
                                </button>
                            </td>
                            <td class="td-actions text-right">
                              <?php
                              if($globalAdmin==1){
                              ?>
                              <a href='index.php?opcion=editSolicitudSIS&codigo=<?=$codigo;?>' rel="tooltip" class="<?=$buttonEdit;?>">
                                <i class="material-icons">edit</i>
                              </a>
                              <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteSolicitudSIS&codigo=<?=$codigo;?>')">
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
                <?php
                if($globalAdmin==1){
                ?>
        				<div class="card-body">
                  <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerSolicitudFondoSIS'">Registrar</button>
                </div>
                <?php
                }
                ?>
              </div>
            </div>  
          </div>
      </div>

      <!-- DETALLE DE LA SOLICITUD DE FONDOS -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detalle Solicitud de Fondos - Proyecto <?=$nombre_proyecto?></h4>
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
<?php } ?>